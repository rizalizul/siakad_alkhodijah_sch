<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Rules\MinAge;

class SiswaController extends Controller
{
    public function index()
    {
        // Ambil nama tahun ajaran yang aktif
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();
        $tahunAjaranNama = $tahunAjaranAktif ? $tahunAjaranAktif->nama : null;

        // 
        $siswas = Siswa::where('status', 'aktif')
            ->with(['kelasSiswa' => function ($query) use ($tahunAjaranNama) {
                if ($tahunAjaranNama) {
                    $query->where('tahun_ajaran_nama', $tahunAjaranNama)->with('kelas');
                }
            }])->orderBy('nama', 'asc')->get();

        return view('admin.siswa.index', compact('siswas'));
    }

    public function show(Siswa $siswa)
    {
        // Menggunakan view dari PPDB karena tampilannya sama
        return view('admin.ppdb.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        // Menggunakan view dari PPDB karena formnya sama
        return view('admin.ppdb.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'nisn' => ['nullable', 'numeric', Rule::unique('siswa')->ignore($siswa->id)],
            'nis' => ['nullable', 'string', 'max:255', Rule::unique('siswa')->ignore($siswa->id)],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => ['required', 'date', new MinAge(5)],
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:255',
            'pendidikan_sebelumnya' => 'nullable|string|max:255',
            'alamat_siswa' => 'required|string',
            'no_wa_siswa' => 'nullable|numeric|max_digits:15',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'no_wa_ortu' => 'required|numeric|max_digits:15',
            'alamat_ortu' => 'required|string',
            'nama_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'alamat_wali' => 'nullable|string',
            'status' => 'required|in:calon,diverifikasi,menunggu_screening,aktif,lulus,pindah,tidak_diterima',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ayah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ibu' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kia' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // --- Logika untuk Capitalize Each Word ---
        $capitalizeFields = [
            'nama', 'nama_panggilan', 'tempat_lahir', 'agama', 'pendidikan_sebelumnya',
            'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu',
            'nama_wali', 'pekerjaan_wali'
        ];

        foreach ($capitalizeFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = ucwords(strtolower($validated[$field]));
            }
        }

        $updateFile = function ($fieldName, $path) use ($request, $siswa, &$validated) {
            if ($request->hasFile($fieldName)) {
                if ($siswa->$fieldName && Storage::disk('public')->exists($siswa->$fieldName)) {
                    Storage::disk('public')->delete($siswa->$fieldName);
                }
                $validated[$fieldName] = $request->file($fieldName)->store($path, 'public');
            }
        };

        $updateFile('kk', 'dokumen_ppdb/kk');
        $updateFile('ktp_ayah', 'dokumen_ppdb/ktp_ayah');
        $updateFile('ktp_ibu', 'dokumen_ppdb/ktp_ibu');
        $updateFile('akta_kelahiran', 'dokumen_ppdb/akta');
        $updateFile('kia', 'dokumen_ppdb/kia');
        $updateFile('foto', 'dokumen_ppdb/foto');

        $siswa->update($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        // Tambahkan validasi untuk mencegah penghapusan jika ada data terkait (misal: tagihan)
        if ($siswa->tagihan()->exists()) {
            return back()->with('error', 'Gagal menghapus! Siswa ini memiliki riwayat tagihan.');
        }

        // Hapus semua file terkait
        $fileFields = ['kk', 'ktp_ayah', 'ktp_ibu', 'akta_kelahiran', 'kia', 'foto', 'hasil_screening'];
        foreach ($fileFields as $field) {
            if ($siswa->$field && Storage::disk('public')->exists($siswa->$field)) {
                Storage::disk('public')->delete($siswa->$field);
            }
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus secara permanen.');
    }
}