<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $data = Kelas::with('wali')->orderBy('nama')->get();
        return view('kelas.data_kelas', compact('data'));
    }

    public function create()
    {
        $guru = Guru::orderBy('nama')->get();
        return view('kelas.tambah_kelas', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kelas,nama',
            'wali_kelas_id' => 'nullable|exists:guru,id'
        ]);

        Kelas::create($request->only('nama', 'wali_kelas_id'));
        return redirect()->route('kelas.index');
    }

    public function edit(Kelas $kela)
    {
        $guru = Guru::orderBy('nama')->get();
        return view('kelas.ubah_kelas', ['kela' => $kela, 'guru' => $guru]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama' => 'required|unique:kelas,nama,' . $kela->id,
            'wali_kelas_id' => 'nullable|exists:guru,id'
        ]);

        $kela->update($request->only('nama', 'wali_kelas_id'));
        return redirect()->route('kelas.index');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return back();
    }
}
