<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class GuruMapelController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        if (!$tahunAjaranAktif) { return back()->with('error', 'Tidak ada tahun ajaran yang aktif.'); }
        
        // PERBAIKAN: Filter berdasarkan nama tahun ajaran
        $penugasan = GuruMapel::with(['guru', 'mapel'])
            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
            ->get();
        return view('admin.guru_mapel.index', compact('penugasan', 'tahunAjaranAktif'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama_mapel')->get();
        return view('admin.guru_mapel.create', compact('gurus', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate(['guru_id' => 'required|exists:guru,id', 'mapel_id' => 'required|exists:mata_pelajaran,id']);
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->firstOrFail();

        // PERBAIKAN: Cek duplikasi berdasarkan nama tahun ajaran
        $exists = GuruMapel::where('guru_id', $request->guru_id)
                            ->where('mapel_id', $request->mapel_id)
                            ->where('tahun_ajaran_nama', $tahunAjaranAktif->nama)
                            ->exists();
        if ($exists) { return back()->with('error', 'Guru ini sudah ditugaskan untuk mengajar mata pelajaran tersebut.'); }

        // PERBAIKAN: Simpan nama tahun ajaran
        GuruMapel::create([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'tahun_ajaran_nama' => $tahunAjaranAktif->nama,
        ]);
        return redirect()->route('guru-mapel.index')->with('success', 'Penugasan guru berhasil ditambahkan.');
    }
    
    public function destroy(GuruMapel $guruMapel)
    {
        $guruMapel->delete();
        return redirect()->route('guru-mapel.index')->with('success', 'Data penugasan berhasil dihapus.');
    }
}