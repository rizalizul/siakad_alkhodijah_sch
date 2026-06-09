<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiSumatif;
use App\Models\NilaiTp;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user()->guru;
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        if (!$user || !$tahunAjaranAktif) {
            return redirect()->route('dashboard')->with('error', 'Data guru atau tahun ajaran aktif tidak ditemukan.');
        }
        $mapelIds = GuruMapel::where('guru_id', $user->id)->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)->pluck('mapel_id');
        $kelasIds = JadwalPelajaran::where('guru_id', $user->id)->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)->distinct()->pluck('kelas_id');
        $kelases = Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();
        $mapels = MataPelajaran::whereIn('id', $mapelIds)->orderBy('nama_mapel')->get();
        return view('admin.nilai.index', compact('kelases', 'mapels'));
    }

    private function getGradeData($kelas_id, $mapel_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = MataPelajaran::findOrFail($mapel_id);
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();

        $daftarKelasSiswa = KelasSiswa::where('kelas_id', $kelas->id)
            ->with('siswa')
            ->get()->sortBy('siswa.nama');

        $daftarKelasSiswaIds = $daftarKelasSiswa->pluck('id');

        // Ambil semua deskripsi TP yang unik untuk mata pelajaran ini
        $tpDeskripsi = NilaiTp::where('mapel_id', $mapel->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->distinct()
            ->pluck('deskripsi')
            ->sort(); // Urutkan untuk memastikan urutan konsisten

        $nilaiSumatifSiswa = NilaiSumatif::whereIn('kelas_siswa_id', $daftarKelasSiswaIds)
            ->where('mapel_id', $mapel->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get()->keyBy('kelas_siswa_id');

        // Ambil semua nilai TP untuk siswa di kelas ini dan kelompokkan berdasarkan ID siswa
        $nilaiTpSiswa = NilaiTp::whereIn('kelas_siswa_id', $daftarKelasSiswaIds)
            ->where('mapel_id', $mapel->id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get()
            ->groupBy('kelas_siswa_id');

        $dataNilaiSiswa = [];
        foreach ($daftarKelasSiswa as $item) {
            $sumatif = $nilaiSumatifSiswa->get($item->id);
            $tp = $nilaiTpSiswa->get($item->id);
            
            $rataRataTP = $tp ? $tp->avg('nilai') : 0;
            $nilaiSTS = $sumatif->nilai_sts ?? 0;
            $nilaiSAS = $sumatif->nilai_sas ?? 0;
            
            $nilaiAkhir = 0;
            if ($rataRataTP > 0 || $nilaiSTS > 0 || $nilaiSAS > 0) {
                $nilaiAkhir = round((($rataRataTP * 1) + ($nilaiSTS * 2) + ($nilaiSAS * 2)) / 5);
            }
            
            $dataNilaiSiswa[] = [
                'item' => $item,
                'nilai_tp' => $tp ? $tp->pluck('nilai', 'deskripsi') : collect(),
                'nilai_sts' => $sumatif,
                'nilai_sas' => $sumatif,
                'nilai_akhir' => $nilaiAkhir,
            ];
        }

        return compact('kelas', 'mapel', 'dataNilaiSiswa', 'tahunAjaranAktif', 'tpDeskripsi');
    }

    public function manage(Request $request)
    {
        $request->validate(['kelas_id' => 'required|exists:kelas,id', 'mapel_id' => 'required|exists:mata_pelajaran,id']);
        $data = $this->getGradeData($request->kelas_id, $request->mapel_id);
        return view('admin.nilai.manage', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'nilai' => 'required|array',
        ]);

        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();

        DB::transaction(function () use ($request, $tahunAjaranAktif) {
            foreach ($request->nilai as $kelas_siswa_id => $jenisNilai) {
                // Proses Nilai Sumatif (STS & SAS)
                if (isset($jenisNilai['STS']) || isset($jenisNilai['SAS'])) {
                    NilaiSumatif::updateOrCreate(
                        ['kelas_siswa_id' => $kelas_siswa_id, 'mapel_id' => $request->mapel_id, 'tahun_ajaran_id' => $tahunAjaranAktif->id],
                        ['nilai_sts' => $jenisNilai['STS'], 'nilai_sas' => $jenisNilai['SAS']]
                    );
                }

                // Proses Nilai TP
                if (isset($jenisNilai['TP'])) {
                    // Kunci array sekarang adalah deskripsi TP itu sendiri
                    foreach ($jenisNilai['TP'] as $deskripsi => $nilai) {
                        if (!is_null($nilai)) {
                            NilaiTp::updateOrCreate(
                                // Gunakan $deskripsi langsung untuk pencarian
                                ['kelas_siswa_id' => $kelas_siswa_id, 'mapel_id' => $request->mapel_id, 'tahun_ajaran_id' => $tahunAjaranAktif->id, 'deskripsi' => $deskripsi],
                                ['nilai' => $nilai]
                            );
                        } else {
                            // Gunakan $deskripsi langsung untuk menghapus
                            NilaiTp::where(['kelas_siswa_id' => $kelas_siswa_id, 'mapel_id' => $request->mapel_id, 'tahun_ajaran_id' => $tahunAjaranAktif->id, 'deskripsi' => $deskripsi])->delete();
                        }
                    }
                }
            }
        });
        
        return back()->with('success', 'Semua data nilai berhasil disimpan.');
    }

    public function storeTp(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'deskripsi' => 'required|string|max:255',
        ]);
    
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
    
        // Cek apakah deskripsi sudah ada
        $existingTp = NilaiTp::where('mapel_id', $request->mapel_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('deskripsi', $request->deskripsi)
            ->first();
    
        if ($existingTp) {
            return back()->with('error', 'Deskripsi TP yang Anda masukkan sudah ada.');
        }
    
        // Ambil semua siswa di kelas tersebut
        $daftarKelasSiswaIds = KelasSiswa::where('kelas_id', $request->kelas_id)->pluck('id');
    
        // Simpan deskripsi TP baru untuk semua siswa dengan nilai default 0
        foreach ($daftarKelasSiswaIds as $kelas_siswa_id) {
            NilaiTp::create([
                'kelas_siswa_id' => $kelas_siswa_id,
                'mapel_id' => $request->mapel_id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'deskripsi' => $request->deskripsi,
                'nilai' => 0, // Nilai default 0
            ]);
        }
    
        return back()->with('success', 'Deskripsi TP baru berhasil ditambahkan.');
    }
    
    public function updateTp(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'old_deskripsi' => 'required|string|max:255',
            'new_deskripsi' => 'required|string|max:255|unique:nilai_tp,deskripsi,' . $request->old_deskripsi . ',deskripsi,mapel_id,' . $request->mapel_id . ',tahun_ajaran_id,' . TahunAjaran::where('is_active', true)->firstOrFail()->id,
        ]);
    
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();
    
        NilaiTp::where('mapel_id', $request->mapel_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('deskripsi', $request->old_deskripsi)
            ->update(['deskripsi' => $request->new_deskripsi]);
    
        return back()->with('success', 'Deskripsi TP berhasil diubah.');
    }

    public function cetak(Request $request)
    {
        $request->validate(['kelas_id' => 'required|exists:kelas,id', 'mapel_id' => 'required|exists:mata_pelajaran,id']);
        $data = $this->getGradeData($request->kelas_id, $request->mapel_id);
        $pdf = Pdf::loadView('admin.nilai.pdf_nilai', $data);
        $pdf->setPaper('a3', 'landscape');
        return $pdf->stream('daftar-nilai-'.$data['kelas']->nama_kelas.'-'.$data['mapel']->nama_mapel.'.pdf');
    }
}
