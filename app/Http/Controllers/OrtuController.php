<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\KelasSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiSumatif; // Menggunakan model NilaiSumatif
use App\Models\NilaiTp;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OrtuController extends Controller
{
    public function showLoginForm()
    {
        return view('ortu.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required|string',
            'tanggal_lahir' => 'required|date',
        ]);

        // Cari siswa berdasarkan NIS/NISN dan tanggal lahir
        $siswa = Siswa::where(function ($query) use ($credentials) {
                $query->where('nis', $credentials['nis'])
                      ->orWhere('nisn', $credentials['nis']);
            })
            ->where('tanggal_lahir', $credentials['tanggal_lahir'])
            ->where('status', 'aktif') // Hanya siswa aktif yang bisa login
            ->first();

        if ($siswa) {
            // Jika siswa ditemukan, simpan ID-nya di session
            session(['siswa_id' => $siswa->id]);
            return redirect()->route('ortu.dashboard');
        }

        // Jika tidak ditemukan, kembali dengan pesan error
        return back()->withErrors([
            'nis' => 'NIS/NISN atau Tanggal Lahir tidak sesuai.',
        ])->withInput();
    }

    /**
     * Menampilkan dashboard orang tua.
     */
    public function dashboard()
    {
        $siswaId = session('siswa_id');
        $siswa = Siswa::findOrFail($siswaId);
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();

        $kelasSiswa = KelasSiswa::where('siswa_id', $siswaId)
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->with('kelas.waliKelas')
            ->first();

        if (!$kelasSiswa) {
            return view('ortu.dashboard_kosong', compact('siswa'));
        }

        // Ambil rekap absensi
        $rekapAbsensi = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->where('status', '!=', 'Hadir')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Mengambil semua nilai TP dan Sumatif untuk siswa pada tahun ajaran aktif
        // Ini lebih efisien daripada melakukan query di dalam loop
        $mataPelajaranList = MataPelajaran::orderBy('id')->get();
        $semuaNilaiTp = NilaiTp::where('kelas_siswa_id', $kelasSiswa->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();
        
        $semuaNilaiSumatif = NilaiSumatif::where('kelas_siswa_id', $kelasSiswa->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get()->keyBy('mapel_id'); // Mengelompokkan nilai sumatif per mata pelajaran
        
        $nilaiAkademikLengkap = [];
        foreach ($mataPelajaranList as $mapel) {
            // Filter koleksi di memori untuk mendapatkan nilai yang relevan
            $nilaiTpPerMapel = $semuaNilaiTp->where('mapel_id', $mapel->id);
            $nilaiSumatifPerMapel = $semuaNilaiSumatif->get($mapel->id);

            // Hitung rata-rata nilai TP dari koleksi yang sudah difilter
            $rataRataTP = $nilaiTpPerMapel->avg('nilai');
            
            // Ambil nilai STS dan SAS dari satu record NilaiSumatif
            $nilaiSTS = $nilaiSumatifPerMapel->nilai_sts ?? null;
            $nilaiSAS = $nilaiSumatifPerMapel->nilai_sas ?? null;
            
            $nilaiAkhir = 0;
            if ($rataRataTP || $nilaiSTS || $nilaiSAS) {
                $nilaiAkhir = round(((($rataRataTP ?? 0) * 1) + (($nilaiSTS ?? 0) * 2) + (($nilaiSAS ?? 0) * 2)) / 5);
            }

            $nilaiAkademikLengkap[] = [
                'mapel' => $mapel,
                'rata_rata_tp' => $rataRataTP ? round($rataRataTP) : null,
                'sts' => $nilaiSTS,
                'sas' => $nilaiSAS,
                'nilai_akhir' => $nilaiAkhir,
            ];
        }

        // Ambil Jadwal Pelajaran
        $jadwals = JadwalPelajaran::where('kelas_id', $kelasSiswa->kelas_id)
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->with(['mapel', 'guru'])
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return view('ortu.dashboard', compact('siswa', 'kelasSiswa', 'tahunAjaranAktif', 'rekapAbsensi', 'nilaiAkademikLengkap', 'jadwals', 'hari'));
    }

    public function detailAbsensi(Request $request)
    {
        $siswaId = session('siswa_id');
        $siswa = Siswa::findOrFail($siswaId);
        $bulan = $request->has('bulan') ? Carbon::parse($request->bulan) : Carbon::now();
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        $kelasSiswa = KelasSiswa::where('siswa_id', $siswaId)->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)->firstOrFail();

        $absensiData = Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->whereYear('tanggal', $bulan->year)
            ->whereMonth('tanggal', $bulan->month)
            ->get()->keyBy(fn($item) => Carbon::parse($item->tanggal)->day);

        return view('ortu.absensi_detail', compact('siswa', 'bulan', 'absensiData'));
    }

    public function cetakJadwal()
    {
        $siswaId = session('siswa_id');
        $siswa = Siswa::findOrFail($siswaId);
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        $kelasSiswa = KelasSiswa::where('siswa_id', $siswaId)->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)->firstOrFail();
        
        $jadwals = JadwalPelajaran::where('kelas_id', $kelasSiswa->kelas_id)
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->with(['mapel', 'guru'])
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        $pdf = Pdf::loadView('ortu.pdf_jadwal', compact('siswa', 'kelasSiswa', 'jadwals', 'hari'));
        return $pdf->stream('jadwal-pelajaran-'.$siswa->nama.'.pdf');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('siswa_id');
        $request->session()->flush();
        return redirect()->route('ortu.login.form');
    }
}