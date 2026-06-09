<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::latest()->get();
        return view('mata_pelajaran.index', compact('mapels'));
    }

    public function create()
    {
        return view('mata_pelajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel',
            'kelompok' => 'required|in:Wajib,Seni Pilihan,Muatan Lokal',
        ]);

        MataPelajaran::create($request->all());
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('mata_pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:mata_pelajaran,nama_mapel,' . $mataPelajaran->id,
            'kelompok' => 'required|in:Wajib,Seni Pilihan,Muatan Lokal',
        ]);

        $mataPelajaran->update($request->all());
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}