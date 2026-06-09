<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $data = [];

        // 1. Ambil daftar NAMA tahun ajaran yang unik untuk dropdown
        $data['semuaTahunAjaranNama'] = TahunAjaran::select('nama')->distinct()->orderBy('nama', 'desc')->pluck('nama');
        
        // 2. Tentukan tahun ajaran aktif dan tahun ajaran yang dipilih untuk filter
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        $selectedTahunAjaranNama = $request->input('tahun_ajaran_nama', $tahunAjaranAktif?->nama);

        $data['tahunAjaranAktif'] = $tahunAjaranAktif;
        $data['selectedTahunAjaranNama'] = $selectedTahunAjaranNama;
        
        // Jika tidak ada tahun ajaran sama sekali, tampilkan data default
        if (!$selectedTahunAjaranNama) {
            $data['totalSiswa'] = Siswa::where('status', 'aktif')->count();
            $data['totalGuru'] = Guru::count();
            $data['totalKelas'] = 0;
            return view('dashboard', $data);
        }

        // 3. Ambil data statistik berdasarkan NAMA tahun ajaran yang difilter
        $data['totalSiswa'] = Siswa::where('status', 'aktif')
            ->whereHas('kelasSiswa', function ($query) use ($selectedTahunAjaranNama) {
                $query->where('tahun_ajaran_nama', $selectedTahunAjaranNama);
            })->count();
            
        $data['totalGuru'] = Guru::count(); // Total guru tidak bergantung tahun ajaran
        $data['totalKelas'] = Kelas::where('tahun_ajaran_nama', $selectedTahunAjaranNama)->count();

        // 4. Data spesifik berdasarkan peran (role) juga difilter
        if ($role == 'wali_kelas' && $user->guru) {
            $data['kelasWali'] = Kelas::where('wali_kelas_id', $user->guru->id)
                ->where('tahun_ajaran_nama', $selectedTahunAjaranNama)
                ->withCount('kelasSiswa')
                ->first();
        } 
        
        if ($role == 'guru_mapel' && $user->guru) {
            $data['jadwals'] = JadwalPelajaran::where('guru_id', $user->guru->id)
                ->where('tahun_ajaran_nama', $selectedTahunAjaranNama)
                ->with(['kelas', 'mapel'])
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('hari');
            $data['hari'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        }

        // --- AKHIR DARI PERUBAHAN ---

        return view('dashboard', $data);
    }
}