<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $data = Semester::with('tahunPelajaran')->latest()->get();
        return view('semester.data_semester', compact('data'));
    }

    public function create()
    {
        $tahun = TahunPelajaran::all();
        return view('semester.tambah_semester', compact('tahun'));
    }

    public function store(Request $request)
    {
        if ($request->aktif) {
            Semester::where('aktif', true)->update(['aktif' => false]);
        }

        Semester::create([
            'nama' => $request->nama,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('semester.index');
    }

    public function edit(Semester $semester)
    {
        $tahun = TahunPelajaran::all();
        return view('semester.ubah_semester', compact('semester', 'tahun'));
    }

    public function update(Request $request, Semester $semester)
    {
        if ($request->aktif) {
            Semester::where('aktif', true)->update(['aktif' => false]);
        }

        $semester->update([
            'nama' => $request->nama,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('semester.index');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return back();
    }
}