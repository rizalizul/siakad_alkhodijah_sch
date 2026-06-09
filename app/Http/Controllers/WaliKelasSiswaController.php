<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliKelasSiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa di kelas perwalian.
     */
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$guru || !$tahunAjaranAktif) {
            return redirect()->route('dashboard')->with('error', 'Data guru atau tahun ajaran aktif tidak ditemukan.');
        }

        $kelas = Kelas::where('wali_kelas_id', $guru->id)
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->with('kelasSiswa.siswa') // Eager load siswa
            ->first();

        if (!$kelas) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak ditugaskan sebagai wali kelas pada tahun ajaran ini.');
        }
        
        // Ambil daftar siswa dari relasi yang sudah di-load
        $daftarSiswa = $kelas->kelasSiswa->sortBy('siswa.nama');

        return view('admin.wali_kelas.siswa_index', compact('kelas', 'daftarSiswa'));
    }
}