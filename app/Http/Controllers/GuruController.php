<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::latest()->get();
        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        // PERBAIKAN: Sesuaikan validasi
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:guru,email',
            'nip' => 'nullable|string|unique:guru,nip',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi untuk foto
        ]);

        DB::transaction(function () use ($request, &$validated) {
            // Proses upload foto jika ada
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('foto_guru', 'public');
            }

            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make('12345678'),
                'role' => 'guru_mapel',
            ]);

            Guru::create(array_merge($validated, ['user_id' => $user->id]));
        });

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        // PERBAIKAN: Sesuaikan validasi
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:guru,email,' . $guru->id,
            'nip' => 'nullable|string|unique:guru,nip,' . $guru->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Proses update foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto_guru', 'public');
        }

        $guru->update($validated);

        if ($guru->user) {
            $guru->user->update(['name' => $validated['nama'], 'email' => $validated['email']]);
        }

        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        DB::transaction(function () use ($guru) {
            // Hapus foto dari storage
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            if ($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();
        });
        
        return redirect()->route('guru.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}