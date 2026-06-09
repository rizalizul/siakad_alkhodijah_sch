<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalGuruController extends Controller
{
    /**
     * Helper function to get schedule data for the logged-in teacher.
     */
    private function getJadwalData()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$guru || !$tahunAjaranAktif) {
            return ['error' => 'Data guru atau tahun ajaran aktif tidak ditemukan.'];
        }

        $jadwals = JadwalPelajaran::where('guru_id', $guru->id)
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->with(['kelas', 'mapel'])
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return compact('guru', 'tahunAjaranAktif', 'jadwals', 'hari');
    }

    /**
     * Menampilkan halaman jadwal mengajar untuk guru yang login.
     */
    public function index()
    {
        $data = $this->getJadwalData();
        if (isset($data['error'])) {
            return redirect()->route('dashboard')->with('error', $data['error']);
        }
        return view('admin.jadwal_guru.index', $data);
    }

    public function cetak()
    {
        $data = $this->getJadwalData();
        if (isset($data['error'])) {
            return redirect()->route('dashboard')->with('error', $data['error']);
        }

        $pdf = Pdf::loadView('admin.jadwal_guru.pdf_jadwal', $data);
        return $pdf->stream('jadwal-mengajar-'.$data['guru']->nama.'.pdf');
    }
}