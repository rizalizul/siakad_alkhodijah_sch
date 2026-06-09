<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiTp;
use App\Models\NilaiSumatif;
use App\Models\NilaiEkstrakurikuler;
use App\Models\Rapor;
use App\Models\TahunAjaran;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    // --- Bagian Wali Kelas ---
    public function index()
    {
        $guru = Auth::user()->guru;
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        
        $kelas = Kelas::where('wali_kelas_id', $guru->id)
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->firstOrFail();

        $daftarSiswa = $kelas->kelasSiswa()->with(['siswa', 'rapor'])->get()->sortBy('siswa.nama');
        return view('admin.rapor.index', compact('kelas', 'daftarSiswa'));
    }

    public function proses(KelasSiswa $kelasSiswa)
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
        
        $rapor = Rapor::firstOrCreate(
            ['kelas_siswa_id' => $kelasSiswa->id, 'tahun_ajaran_id' => $tahunAjaranAktif->id],
            ['status_rapor' => 'draft']
        );
        $rapor->load('tahunAjaran');

        $nilaiAkademik = $this->getNilaiAkademik($kelasSiswa, $tahunAjaranAktif);
        $rekapAbsensi = $this->getRekapAbsensi($kelasSiswa);
        $ekskul = NilaiEkstrakurikuler::where('rapor_id', $rapor->id)->get();
        $ekskulOptions = Ekstrakurikuler::orderBy('nama_ekskul')->get();

        return view('admin.rapor.proses', compact('kelasSiswa', 'rapor', 'nilaiAkademik', 'rekapAbsensi', 'ekskul', 'ekskulOptions'));
    }

    public function update(Request $request, Rapor $rapor)
    {
        $request->validate([
            'catatan_wali_kelas' => 'nullable|string',
            'naik_kelas' => 'nullable|boolean',
            'ekskul' => 'nullable|array',
            'ekskul.*.nama' => 'required_with:ekskul.*.keterangan|string',
            'ekskul.*.keterangan' => 'required_with:ekskul.*.nama|string',
        ]);

        DB::transaction(function () use ($request, $rapor) {
            $rapor->update([
                'catatan_wali_kelas' => $request->catatan_wali_kelas,
                'naik_kelas' => $request->naik_kelas,
                'status_rapor' => 'final',
            ]);

            $rapor->nilaiEkstrakurikuler()->delete();
            if ($request->has('ekskul')) {
                foreach ($request->ekskul as $ekskulData) {
                    if (!empty($ekskulData['nama']) && !empty($ekskulData['keterangan'])) {
                        NilaiEkstrakurikuler::create([
                            'rapor_id' => $rapor->id,
                            'nama_ekskul' => $ekskulData['nama'],
                            'keterangan' => $ekskulData['keterangan'],
                        ]);
                    }
                }
            }
        });

        return redirect()->route('rapor.index')->with('success', 'Rapor untuk siswa ' . $rapor->kelasSiswa->siswa->nama . ' berhasil difinalisasi.');
    }

    public function cetak(Rapor $rapor)
    {
        // if ($rapor->status_rapor !== 'ditandatangani') {
        //     return back()->with('error', 'Rapor belum disetujui oleh Kepala Sekolah.');
        // }

        // Pastikan semua relasi yang dibutuhkan sudah di-load
        $rapor->load(['kelasSiswa.siswa', 'kelasSiswa.kelas.waliKelas', 'tahunAjaran', 'nilaiEkstrakurikuler']);

        $nilaiAkademik = $this->getNilaiAkademik($rapor->kelasSiswa, $rapor->tahunAjaran);
        $rekapAbsensi = $this->getRekapAbsensi($rapor->kelasSiswa);

        $pdf = Pdf::loadView('admin.rapor.pdf_rapor', compact('rapor', 'nilaiAkademik', 'rekapAbsensi'));
        return $pdf->stream('rapor-'.$rapor->kelasSiswa->siswa->nama.'.pdf');
    }

    // --- Bagian Kepala Sekolah ---
    // public function kepsekIndex()
    // {
    //     $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
    //     // PERBAIKAN: Filter rapor berdasarkan semester aktif
    //     $rapors = Rapor::with('kelasSiswa.siswa', 'kelasSiswa.kelas')
    //         ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //         ->where('status_rapor', 'final')
    //         ->get();
    //     return view('admin.rapor.kepsek_index', compact('rapors'));
    // }

    // public function kepsekApprove(Rapor $rapor)
    // {
    //     $rapor->update(['status_rapor' => 'ditandatangani']);
    //     return back()->with('success', 'Rapor berhasil disetujui.');
    // }

    private function getNilaiAkademik(KelasSiswa $kelasSiswa, TahunAjaran $tahunAjaran)
    {
        $nilaiAkademik = [];
        $mataPelajaranList = MataPelajaran::orderBy('id')->get();
        
        $nilaiTps = NilaiTp::where('kelas_siswa_id', $kelasSiswa->id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->get();
        
        $nilaiSumatifs = NilaiSumatif::where('kelas_siswa_id', $kelasSiswa->id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->get();
            
        foreach ($mataPelajaranList as $mapel) {
            $rataRataTP = $nilaiTps->where('mapel_id', $mapel->id)->avg('nilai') ?? 0;

            $nilaiSumatifSiswa = $nilaiSumatifs->where('mapel_id', $mapel->id)->first();
            $nilaiSTS = $nilaiSumatifSiswa->nilai_sts ?? 0;
            $nilaiSAS = $nilaiSumatifSiswa->nilai_sas ?? 0;
            $nilaiAkhir = round((($rataRataTP * 1) + ($nilaiSTS * 2) + ($nilaiSAS * 2)) / 5);
            
            // --- LOGIKA PERBAIKAN INI ---
            // Mencari nilai TP tertinggi untuk mata pelajaran saat ini
            $nilaiTpTertinggi = $nilaiTps->where('mapel_id', $mapel->id)->sortByDesc('nilai')->first();
            $deskripsiTertinggi = $nilaiTpTertinggi->deskripsi ?? 'Belum ada deskripsi.';

            $nilaiAkademik[] = [
                'mapel' => $mapel,
                'nilai_akhir' => $nilaiAkhir,
                'deskripsi' => $deskripsiTertinggi, // Mengirimkan satu deskripsi saja
            ];
        }
        return $nilaiAkademik;
    }

    private function getRekapAbsensi(KelasSiswa $kelasSiswa)
    {
        return Absensi::where('kelas_siswa_id', $kelasSiswa->id)
            ->where('status', '!=', 'Hadir')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
    }
}