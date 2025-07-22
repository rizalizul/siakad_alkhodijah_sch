<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $data = MataPelajaran::orderBy('kode')->get();
        return view('mata_pelajaran.data_mata_pelajaran', compact('data'));
    }

    public function create()
    {
        return view('mata_pelajaran.tambah_mata_pelajaran');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mata_pelajaran,kode',
            'nama' => 'required'
        ]);

        MataPelajaran::create($request->only('kode', 'nama'));
        return redirect()->route('mata-pelajaran.index');
    }

    public function edit(MataPelajaran $mata_pelajaran)
    {
        return view('mata_pelajaran.ubah_mata_pelajaran', compact('mata_pelajaran'));
    }

    public function update(Request $request, MataPelajaran $mata_pelajaran)
    {
        $request->validate([
            'kode' => 'required|unique:mata_pelajaran,kode,' . $mata_pelajaran->id,
            'nama' => 'required'
        ]);

        $mata_pelajaran->update($request->only('kode', 'nama'));
        return redirect()->route('mata-pelajaran.index');
    }

    public function destroy(MataPelajaran $mata_pelajaran)
    {
        $mata_pelajaran->delete();
        return back();
    }
}
