<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\NilaiEkstrakurikuler;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekskuls = Ekstrakurikuler::latest()->get();
        return view('admin.ekstrakurikuler.index', compact('ekskuls'));
    }

    public function create()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_ekskul' => 'required|string|max:255|unique:ekstrakurikuler,nama_ekskul']);
        Ekstrakurikuler::create($request->all());
        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $request->validate(['nama_ekskul' => 'required|string|max:255|unique:ekstrakurikuler,nama_ekskul,' . $ekstrakurikuler->id]);
        $ekstrakurikuler->update($request->all());
        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        // Cek apakah ekskul sudah digunakan di rapor
        $isUsed = NilaiEkstrakurikuler::where('nama_ekskul', $ekstrakurikuler->nama_ekskul)->exists();
        if ($isUsed) {
            return back()->with('error', 'Gagal menghapus! Ekstrakurikuler ini sudah digunakan di dalam rapor siswa.');
        }
        $ekstrakurikuler->delete();
        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
