<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $data = Ekstrakurikuler::orderBy('nama')->get();
        return view('ekstrakurikuler.data_ekstrakurikuler', compact('data'));
    }

    public function create()
    {
        return view('ekstrakurikuler.tambah_ekstrakurikuler');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:ekstrakurikuler,nama'
        ]);

        Ekstrakurikuler::create($request->only('nama'));
        return redirect()->route('ekstrakurikuler.index');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('ekstrakurikuler.ubah_ekstrakurikuler', compact('ekstrakurikuler'));
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $request->validate([
            'nama' => 'required|unique:ekstrakurikuler,nama,' . $ekstrakurikuler->id
        ]);

        $ekstrakurikuler->update($request->only('nama'));
        return redirect()->route('ekstrakurikuler.index');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->delete();
        return back();
    }
}
