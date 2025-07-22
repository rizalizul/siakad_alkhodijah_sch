<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::latest()->get();
        return view('guru.data_guru', compact('data'));
    }

    public function create()
    {
        return view('guru.tambah_guru');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:guru,nip',
            'jenis_kelamin' => 'required',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // max = 2MB
        ]);

        $fotoPath = null; 

        if ($request->hasFile('foto')) {
            $ext = $request->file('foto')->getClientOriginalExtension();
            $filename = $request->nip . '.' . $ext;

            // Simpan file langsung ke 'guru/' di dalam disk 'public'
            // Ini akan menyimpannya di storage/app/public/guru/filename.jpg
            $request->file('foto')->storeAs('guru', $filename, 'public');
            // Path yang akan disimpan di database adalah 'guru/filename.jpg'
            $fotoPath = 'guru/' . $filename;
        }

        Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'foto' => $fotoPath, // Gunakan $fotoPath
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function edit(Guru $guru)
    {
        return view('guru.ubah_guru', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|unique:guru,nip,' . $guru->id,
            'jenis_kelamin' => 'required',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = $guru->foto; // Ambil path foto lama

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            $ext = $request->file('foto')->getClientOriginalExtension();
            $filename = $request->nip . '.' . $ext;

            // Simpan file baru
            $request->file('foto')->storeAs('guru', $filename, 'public');
            $fotoPath = 'guru/' . $filename;
        }
        if (!$request->hasFile('foto') && $request->input('clear_foto_checkbox_name')) { // Contoh checkbox untuk hapus foto
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = null;
        }


        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'foto' => $fotoPath, // Gunakan $fotoPath
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru)
    {
        // Hapus file foto dari storage sebelum menghapus record dari database
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();
        return back()->with('success', 'Data guru berhasil dihapus!');
    }
}