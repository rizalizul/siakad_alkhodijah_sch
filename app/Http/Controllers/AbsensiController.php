<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    /**
     * Helper function to get essential data for the logged-in Wali Kelas.
     */
    private function getWaliKelasData()
    {
        $user = Auth::user()->guru;
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        if (!$user || !$tahunAjaranAktif) {
            return ['error' => 'Data guru atau tahun ajaran aktif tidak ditemukan.'];
        }
        
        $kelas = Kelas::where('wali_kelas_id', $user->id)
                      ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
                      ->first();
        if (!$kelas) {
            return ['error' => 'Anda tidak ditugaskan sebagai wali kelas pada tahun ajaran ini.'];
        }

        return ['kelas' => $kelas, 'tahunAjaranAktif' => $tahunAjaranAktif];
    }

    /**
     * Menampilkan halaman utama absensi dengan kalender interaktif.
     */
    public function index(Request $request)
    {
        $data = $this->getWaliKelasData();
        if (isset($data['error'])) {
            return redirect()->route('dashboard')->with('error', $data['error']);
        }
        $kelas = $data['kelas'];

        // Tentukan bulan yang akan ditampilkan (dari request atau default bulan ini)
        $bulan = $request->has('bulan') ? Carbon::parse($request->bulan) : Carbon::now();
        
        $daftarSiswa = $kelas->kelasSiswa()->with('siswa')->get()->sortBy('siswa.nama');
        
        $absensiData = Absensi::whereIn('kelas_siswa_id', $daftarSiswa->pluck('id'))
            ->whereYear('tanggal', $bulan->year)
            ->whereMonth('tanggal', $bulan->month)
            ->get();

        // Proses data untuk tampilan grid
        $report = [];
        foreach ($daftarSiswa as $item) {
            $kehadiranSiswa = [];
            for ($i = 1; $i <= $bulan->daysInMonth; $i++) {
                $tanggalCek = $bulan->copy()->day($i);
                $absensiHariIni = $absensiData->first(function ($abs) use ($item, $tanggalCek) {
                    return $abs->kelas_siswa_id == $item->id && Carbon::parse($abs->tanggal)->isSameDay($tanggalCek);
                });
                $kehadiranSiswa[$i] = $absensiHariIni->status ?? null; // null jika belum ada data
            }
            $report[$item->id] = ['siswa' => $item->siswa, 'kehadiran' => $kehadiranSiswa];
        }

        return view('admin.absensi.index', compact('kelas', 'bulan', 'report'));
    }

    /**
     * Menampilkan form untuk mengelola absensi pada tanggal tertentu.
     */
    public function manage(Request $request)
    {
        $request->validate(['tanggal' => 'required|date']);
        $tanggal = Carbon::parse($request->tanggal);
        
        $data = $this->getWaliKelasData();
        if (isset($data['error'])) {
            return redirect()->route('dashboard')->with('error', $data['error']);
        }
        $kelas = $data['kelas'];

        $daftarSiswa = $kelas->kelasSiswa()->with('siswa')->get()->sortBy('siswa.nama');
        $absensiSudahAda = Absensi::whereIn('kelas_siswa_id', $daftarSiswa->pluck('id'))
            ->where('tanggal', $tanggal->format('Y-m-d'))
            ->get()
            ->keyBy('kelas_siswa_id');
            
        return view('admin.absensi.manage', compact('kelas', 'daftarSiswa', 'tanggal', 'absensiSudahAda'));
    }

    /**
     * Menyimpan data absensi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
            'absensi' => 'required|array',
            'absensi.*.status' => 'required|in:Hadir,Sakit,Izin,Tanpa Keterangan',
        ]);

        $tanggal = $request->tanggal;
        $user_id = Auth::id();

        foreach ($request->absensi as $kelas_siswa_id => $data) {
            Absensi::updateOrCreate(
                ['kelas_siswa_id' => $kelas_siswa_id, 'tanggal' => $tanggal],
                ['status' => $data['status'], 'keterangan' => $data['keterangan'] ?? null, 'recorded_by' => $user_id]
            );
        }

        return redirect()->route('absensi.index', ['bulan' => Carbon::parse($tanggal)->format('Y-m')])
                         ->with('success', 'Data absensi tanggal ' . Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM Y') . ' berhasil disimpan.');
    }

    /**
     * Menampilkan laporan absensi bulanan (versi web).
     */
    public function monthlyReport(Request $request)
    {
        $request->validate(['bulan' => 'required|date_format:Y-m']);
        $data = $this->getWaliKelasData();
        if (isset($data['error'])) return redirect()->back()->with('error', $data['error']);
        
        $kelas = $data['kelas'];
        $bulan = Carbon::parse($request->bulan);
        $report = $this->generateMonthlyReportData($kelas, $bulan);

        if ($request->has('cetak')) {
            return $this->cetakLaporanBulanan($kelas, $bulan, $report);
        }

        return view('admin.absensi.monthly', compact('kelas', 'bulan', 'report'));
    }

    /**
     * Helper untuk generate data laporan bulanan.
     */
    private function generateMonthlyReportData($kelas, $bulan)
    {
        $daftarSiswa = $kelas->kelasSiswa()->with('siswa')->get()->sortBy('siswa.nama');
        $absensiData = Absensi::whereIn('kelas_siswa_id', $daftarSiswa->pluck('id'))
            ->whereYear('tanggal', $bulan->year)->whereMonth('tanggal', $bulan->month)->get();

        $report = [];
        foreach ($daftarSiswa as $item) {
            $kehadiranSiswa = [];
            $rekap = ['S' => 0, 'I' => 0, 'A' => 0];
            for ($i = 1; $i <= $bulan->daysInMonth; $i++) {
                $tanggalCek = $bulan->copy()->day($i);
                $absensiHariIni = $absensiData->first(fn($abs) => $abs->kelas_siswa_id == $item->id && Carbon::parse($abs->tanggal)->isSameDay($tanggalCek));
                $status = '';
                if ($absensiHariIni) {
                    switch ($absensiHariIni->status) {
                        case 'Sakit': $status = 'S'; $rekap['S']++; break;
                        case 'Izin': $status = 'I'; $rekap['I']++; break;
                        case 'Tanpa Keterangan': $status = 'A'; $rekap['A']++; break;
                    }
                }
                $kehadiranSiswa[$i] = $status;
            }
            $report[] = ['siswa' => $item->siswa, 'kehadiran' => $kehadiranSiswa, 'rekap' => $rekap];
        }
        return $report;
    }

    private function cetakLaporanBulanan($kelas, $bulan, $report)
    {
        $pdf = Pdf::loadView('admin.absensi.pdf_monthly', compact('kelas', 'bulan', 'report'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-absensi-'.$kelas->nama_kelas.'-'.$bulan->format('F-Y').'.pdf');
    }

    public function cetakBlanko(Request $request)
    {
        $request->validate(['bulan' => 'required|date_format:Y-m']);
        $data = $this->getWaliKelasData();
        if (isset($data['error'])) return redirect()->back()->with('error', $data['error']);
        
        $kelas = $data['kelas'];
        $bulan = Carbon::parse($request->bulan);
        $daftarSiswa = $kelas->kelasSiswa()->with('siswa')->get()->sortBy('siswa.nama');

        $pdf = Pdf::loadView('admin.absensi.pdf_blanko', compact('kelas', 'bulan', 'daftarSiswa'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('blanko-absensi-'.$kelas->nama_kelas.'-'.$bulan->format('F-Y').'.pdf');
    }

    public function cetakSemester()
    {
        $data = $this->getWaliKelasData();
        if (isset($data['error'])) return redirect()->back()->with('error', $data['error']);

        $kelas = $data['kelas'];
        $tahunAjaranAktif = $data['tahunAjaranAktif'];
        $daftarSiswa = $kelas->kelasSiswa()->with('siswa')->get()->sortBy('siswa.nama');

        $startMonth = $tahunAjaranAktif->semester == 1 ? 7 : 1;
        $endMonth = $tahunAjaranAktif->semester == 1 ? 12 : 6;
        $year = explode('/', $tahunAjaranAktif->nama)[0];
        if ($tahunAjaranAktif->semester == 2 && $startMonth == 1) $year++;

        $startDate = Carbon::create($year, $startMonth, 1)->startOfMonth();
        $endDate = Carbon::create($year, $endMonth, 1)->endOfMonth();

        $absensiData = Absensi::whereIn('kelas_siswa_id', $daftarSiswa->pluck('id'))
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', '!=', 'Hadir')
            ->select('kelas_siswa_id', 'status', DB::raw('count(*) as total'))
            ->groupBy('kelas_siswa_id', 'status')
            ->get();

        $report = [];
        foreach($daftarSiswa as $item) {
            $absensiSiswa = $absensiData->where('kelas_siswa_id', $item->id);
            $report[] = [
                'siswa' => $item->siswa,
                'S' => $absensiSiswa->where('status', 'Sakit')->first()->total ?? 0,
                'I' => $absensiSiswa->where('status', 'Izin')->first()->total ?? 0,
                'A' => $absensiSiswa->where('status', 'Tanpa Keterangan')->first()->total ?? 0,
            ];
        }

        $pdf = Pdf::loadView('admin.absensi.pdf_semester', compact('kelas', 'tahunAjaranAktif', 'report'));
        return $pdf->stream('rekap-semester-absensi-'.$kelas->nama_kelas.'.pdf');
    }
}