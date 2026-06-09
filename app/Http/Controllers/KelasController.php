<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KelasController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tidak ada tahun ajaran yang aktif. Silakan aktifkan satu tahun ajaran terlebih dahulu.');
        }
        // PERBAIKAN: Filter berdasarkan nama tahun ajaran
        $kelases = Kelas::with(['waliKelas', 'kelasSiswa'])
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->get();
        return view('admin.kelas.index', compact('kelases', 'tahunAjaranAktif'));
    }

    public function create()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        // PERBAIKAN: Filter berdasarkan nama tahun ajaran
        $assignedWaliKelasIds = Kelas::where('tahun_ajaran_nama', $tahunAjaranAktif->nama)->pluck('wali_kelas_id');
        $gurus = Guru::whereNotIn('id', $assignedWaliKelasIds)->orderBy('nama')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat_kelas' => 'required|integer|between:1,6',
            'wali_kelas_id' => 'required|exists:guru,id',
        ]);

        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        
        DB::transaction(function () use ($request, $tahunAjaranAktif) {
            // PERBAIKAN: Simpan nama tahun ajaran, bukan ID semester
            Kelas::create(array_merge($request->all(), [
                'tahun_ajaran_nama' => $tahunAjaranAktif->nama
            ]));
            $guru = Guru::find($request->wali_kelas_id);
            if ($guru && $guru->user) {
                $guru->user->update(['role' => 'wali_kelas']);
            }
        });

        return redirect()->route('kelas.index')->with('success', 'Kelas baru berhasil dibuat.');
    }

    public function show(Kelas $kela)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();

        // Ambil siswa yang sudah ada di kelas ini (untuk ditampilkan di tabel)
        $siswaDiKelas = KelasSiswa::where('kelas_id', $kela->id)->with('siswa')->get()->sortBy('siswa.nama');
        $siswaDiKelasIds = $siswaDiKelas->pluck('siswa_id');

        // Ambil siswa yang sudah ada di kelas lain pada tahun ajaran aktif
        $siswaDiKelasLainIds = KelasSiswa::where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
                                        ->where('kelas_id', '!=', $kela->id)
                                        ->pluck('siswa_id');

        // Siswa yang tersedia untuk ditambahkan (status aktif dan belum masuk kelas manapun)
        $siswaTersedia = Siswa::where('status', 'aktif')
                                ->whereNotIn('id', $siswaDiKelasLainIds)
                                ->orderBy('nama')->get();
        
        // --- FITUR NAIK KELAS ---
        // 1. Dapatkan nama tahun ajaran sebelumnya
        $currentYearParts = explode('/', $tahunAjaranAktif->nama);
        $previousYearStart = (int)$currentYearParts[0] - 1;
        $previousYearEnd = (int)$currentYearParts[1] - 1;
        $tahunAjaranSebelumnyaNama = "{$previousYearStart}/{$previousYearEnd}";

        // 2. Ambil daftar kelas dari tahun ajaran sebelumnya
        $kelasLama = Kelas::where('tahun_ajaran_nama', $tahunAjaranSebelumnyaNama)->orderBy('nama_kelas')->get();

        return view('admin.kelas.show', compact('kela', 'siswaDiKelas', 'siswaDiKelasIds', 'siswaTersedia', 'kelasLama'));
    }

    public function updateSiswa(Request $request, Kelas $kela)
    {
        $request->validate(['siswa_ids' => 'nullable|array']);
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();

        DB::transaction(function () use ($request, $kela, $tahunAjaranAktif) {
            KelasSiswa::where('kelas_id', $kela->id)->delete();
            if ($request->has('siswa_ids')) {
                foreach ($request->siswa_ids as $siswaId) {
                    KelasSiswa::create([
                        'kelas_id' => $kela->id,
                        'siswa_id' => $siswaId,
                        'tahun_ajaran_nama' => $tahunAjaranAktif->nama,
                    ]);
                }
            }
        });
        return redirect()->route('kelas.show', $kela->id)->with('success', 'Data siswa di dalam kelas berhasil diperbarui.');
    }

    
    // FITUR BARU: Endpoint untuk mengambil daftar ID siswa dari kelas lama via AJAX.
    public function fetchSiswaFromKelas(Kelas $kelas)
    {
        $siswaIds = KelasSiswa::where('kelas_id', $kelas->id)->pluck('siswa_id');
        return response()->json($siswaIds);
    }
    
    public function destroy(Kelas $kela)
    {
        DB::transaction(function () use ($kela) {
            $waliKelas = $kela->waliKelas;
            $kela->delete();
            if ($waliKelas && $waliKelas->user) {
                $isStillWaliKelas = Kelas::where('wali_kelas_id', $waliKelas->id)->exists();
                if (!$isStillWaliKelas) {
                    $waliKelas->user->update(['role' => 'guru_mapel']);
                }
            }
        });
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function cetakSiswa(Kelas $kela)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        $daftarSiswa = KelasSiswa::with('siswa')->where('kelas_id', $kela->id)->get()->sortBy('siswa.nama');
        $pdf = Pdf::loadView('admin.kelas.pdf_siswa', [
            'kelas' => $kela,
            'daftarSiswa' => $daftarSiswa,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
        return $pdf->stream('daftar-siswa-'.$kela->nama_kelas.'.pdf');
    }
}