<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TahunAjaranController extends Controller
{
    /**
     * Menampilkan daftar tahun ajaran.
     */
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        return view('tahun_ajaran.index', compact('tahunAjarans'));
    }

    /**
     * Menampilkan form untuk membuat tahun ajaran baru.
     */
    public function create()
    {
        return view('tahun_ajaran.create');
    }

    /**
     * Menyimpan tahun ajaran baru ke database.
     */
    public function store(Request $request)
    {
        // PERUBAHAN VALIDASI DI SINI
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tahun_ajaran')->where(function ($query) use ($request) {
                    return $query->where('semester', $request->semester);
                }),
            ],
            'semester' => 'required|in:1,2', 
        ]);

        TahunAjaran::create($request->all());

        return redirect()->route('tahun-ajaran.index')
                         ->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit tahun ajaran.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun_ajaran.edit', compact('tahunAjaran'));
    }

    /**
     * Memperbarui data tahun ajaran di database.
     */
    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        // PERUBAHAN VALIDASI DI SINI
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tahun_ajaran')->where(function ($query) use ($request) {
                    return $query->where('semester', $request->semester);
                })->ignore($tahunAjaran->id),
            ],
            'semester' => 'required|in:1,2',
        ]);

        $tahunAjaran->update($request->all());

        return redirect()->route('tahun-ajaran.index')
                         ->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    /**
     * Menghapus tahun ajaran dari database.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->is_active) {
            return redirect()->route('tahun-ajaran.index')
                             ->with('error', 'Tahun Ajaran yang aktif tidak dapat dihapus.');
        }
        $tahunAjaran->delete();
        return redirect()->route('tahun-ajaran.index')
                         ->with('success', 'Tahun Ajaran berhasil dihapus.');
    }

    /**
     * Mengaktifkan satu tahun ajaran dan menonaktifkan yang lain.
     */
    public function setActive(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
            $tahunAjaran = TahunAjaran::findOrFail($id);
            $tahunAjaran->is_active = true;
            $tahunAjaran->save();
        });

        return redirect()->route('tahun-ajaran.index')
                         ->with('success', 'Tahun Ajaran berhasil diaktifkan.');
    }

    public function setPpdbOpen(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            // Nonaktifkan semua status ppdb_open yang lain
            TahunAjaran::where('is_ppdb_open', true)->update(['is_ppdb_open' => false]);

            // Aktifkan yang dipilih
            $tahunAjaran = TahunAjaran::findOrFail($id);
            $tahunAjaran->is_ppdb_open = true;
            $tahunAjaran->save();
        });

        return redirect()->route('tahun-ajaran.index')
                        ->with('success', 'Tahun Ajaran untuk PPDB berhasil diaktifkan.');
    }

    public function closePpdbOpen(Request $request, $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->is_ppdb_open = false;
        $tahunAjaran->save();

        return redirect()->route('tahun-ajaran.index')
                         ->with('success', 'Pendaftaran PPDB untuk tahun ajaran berhasil ditutup.');
    }
}
