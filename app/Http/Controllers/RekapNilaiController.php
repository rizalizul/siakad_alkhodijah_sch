<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\MataPelajaran;
use App\Models\NilaiSumatif;
use App\Models\NilaiTp;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapNilaiController extends Controller
{
    /**
     * Helper function to get and process grade summary data.
     */
    private function getRekapData()
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

        $mataPelajaranList = MataPelajaran::orderBy('id')->get();
        $daftarSiswa = $kelas->kelasSiswa()->with('siswa')->get();
        $daftarSiswaIds = $daftarSiswa->pluck('id');

        // Ambil semua nilai yang relevan untuk seluruh kelas sekaligus
        $semuaNilaiSumatif = NilaiSumatif::whereIn('kelas_siswa_id', $daftarSiswaIds)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();
        $semuaNilaiTp = NilaiTp::whereIn('kelas_siswa_id', $daftarSiswaIds)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->get();

        $dataRekap = [];
        foreach ($daftarSiswa as $item) {
            $nilaiAkhirPerMapel = [];
            $totalNilaiAkhir = 0;

            foreach ($mataPelajaranList as $mapel) {
                $sumatif = $semuaNilaiSumatif->where('kelas_siswa_id', $item->id)->where('mapel_id', $mapel->id)->first();
                $tp = $semuaNilaiTp->where('kelas_siswa_id', $item->id)->where('mapel_id', $mapel->id);
                
                $rataRataTP = $tp->isNotEmpty() ? $tp->avg('nilai') : 0;
                $nilaiSTS = $sumatif->nilai_sts ?? 0;
                $nilaiSAS = $sumatif->nilai_sas ?? 0;
                
                $nilaiAkhir = 0;
                if ($rataRataTP > 0 || $nilaiSTS > 0 || $nilaiSAS > 0) {
                    $nilaiAkhir = round((($rataRataTP * 1) + ($nilaiSTS * 2) + ($nilaiSAS * 2)) / 5);
                }
                
                $nilaiAkhirPerMapel[$mapel->id] = $nilaiAkhir;
                $totalNilaiAkhir += $nilaiAkhir;
            }

            $dataRekap[] = [
                'siswa' => $item->siswa,
                'nilai_akhir' => $nilaiAkhirPerMapel,
                'jumlah' => $totalNilaiAkhir,
                'rata_rata' => $mataPelajaranList->count() > 0 ? round($totalNilaiAkhir / $mataPelajaranList->count(), 2) : 0,
            ];
        }

        // Logika Perangkingan
        usort($dataRekap, fn($a, $b) => $b['rata_rata'] <=> $a['rata_rata']);
        $rank = 0; $prev_rata_rata = -1; $counter = 0;
        foreach ($dataRekap as &$rekap) {
            $counter++;
            if ($rekap['rata_rata'] !== $prev_rata_rata) {
                $rank = $counter;
            }
            $rekap['ranking'] = $rank;
            $prev_rata_rata = $rekap['rata_rata'];
        }

        return compact('kelas', 'tahunAjaranAktif', 'mataPelajaranList', 'dataRekap');
    }

    public function index()
    {
        $data = $this->getRekapData();
        if (isset($data['error'])) {
            return redirect()->route('dashboard')->with('error', $data['error']);
        }
        return view('admin.rekap_nilai.index', $data);
    }

    public function cetak()
    {
        $data = $this->getRekapData();
        if (isset($data['error'])) {
            return redirect()->route('dashboard')->with('error', $data['error']);
        }
        $pdf = Pdf::loadView('admin.rekap_nilai.pdf_rekap', $data);
        $pdf->setPaper('a3', 'landscape');
        return $pdf->stream('rekap-nilai-'.$data['kelas']->nama_kelas.'.pdf');
    }
}