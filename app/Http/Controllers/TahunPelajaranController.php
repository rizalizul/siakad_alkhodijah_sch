<?php

namespace App\Http\Controllers;

use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TahunPelajaran::orderByDesc('id')->get();
        return view('tahun_pelajaran.data_tahun_pelajaran', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tahun_pelajaran.tambah_tahun_pelajaran');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->aktif) {
            TahunPelajaran::where('aktif', true)->update(['aktif' => false]);
        }

        TahunPelajaran::create([
            'nama' => $request->nama,
            'aktif' => $request->has('aktif')
        ]);

        return redirect()->route('tahun-pelajaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunPelajaran $tahun_pelajaran)
    {
        return view('tahun_pelajaran.ubah_tahun_pelajaran', compact('tahun_pelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunPelajaran $tahun_pelajaran)
    {
        if ($request->aktif) {
            TahunPelajaran::where('aktif', true)->update(['aktif' => false]);
        }

        $tahun_pelajaran->update([
            'nama' => $request->nama,
            'aktif' => $request->has('aktif')
        ]);

        return redirect()->route('tahun-pelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunPelajaran $tahun_pelajaran)
    {
        $tahun_pelajaran->delete();
        return back();
    }
}
