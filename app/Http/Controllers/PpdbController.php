<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Rules\MinAge;
use Illuminate\Validation\Rule;

class PpdbController extends Controller
{
    // --- Bagian Publik (Untuk Orang Tua) ---
    public function create()
    {
        // PERUBAHAN: Cek tahun ajaran yang PPDB-nya dibuka
        $tahunAjaranPpdb = TahunAjaran::where('is_ppdb_open', true)->first();
        if (!$tahunAjaranPpdb) {
            return view('ppdb.closed'); // Buat view baru untuk info pendaftaran tutup
        }
        return view('ppdb.create', compact('tahunAjaranPpdb'));
    }

    public function store(Request $request)
    {
        $tahunAjaranPpdb = TahunAjaran::where('is_ppdb_open', true)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'nisn' => 'nullable|numeric|unique:siswa,nisn',
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
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ayah' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ibu' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kia' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $capitalizeFields = [
            'nama', 'nama_panggilan', 'tempat_lahir', 'agama', 'pendidikan_sebelumnya',
            'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu',
            'nama_wali', 'pekerjaan_wali'
        ];

        foreach ($capitalizeFields as $field) {
            if (isset($validated[$field])) {
                // Menggunakan strtolower() dulu untuk menangani input seperti "JOHN DOE"
                $validated[$field] = ucwords(strtolower($validated[$field]));
            }
        }

        // PERUBAHAN: Generate Nomor Pendaftaran
        $tahun = date('Y');
        $latestPendaftar = Siswa::where('no_pendaftaran', 'like', "PPDB-{$tahun}-%")->orderBy('no_pendaftaran', 'desc')->first();
        $newNumber = $latestPendaftar ? ((int) substr($latestPendaftar->no_pendaftaran, -4)) + 1 : 1;
        $validated['no_pendaftaran'] = "PPDB-{$tahun}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        // PERUBAHAN: Simpan tahun ajaran pendaftaran
        $validated['tahun_ajaran_ppdb'] = $tahunAjaranPpdb->nama;

        // Fungsi untuk menyimpan file
        $saveFile = function ($file, $path) {
            return $file ? $file->store($path, 'public') : null;
        };

        // Proses upload file
        $validated['kk'] = $saveFile($request->file('kk'), 'dokumen_ppdb/kk');
        $validated['ktp_ayah'] = $saveFile($request->file('ktp_ayah'), 'dokumen_ppdb/ktp_ayah');
        $validated['ktp_ibu'] = $saveFile($request->file('ktp_ibu'), 'dokumen_ppdb/ktp_ibu');
        $validated['akta_kelahiran'] = $saveFile($request->file('akta_kelahiran'), 'dokumen_ppdb/akta');
        $validated['kia'] = $saveFile($request->file('kia'), 'dokumen_ppdb/kia');
        $validated['foto'] = $saveFile($request->file('foto'), 'dokumen_ppdb/foto');
        
        // Set status default
        $validated['status'] = 'calon';
        Siswa::create($validated);
        return redirect()->route('ppdb.success');
    }

    public function success()
    {
        return view('ppdb.success');
    }

    // --- Bagian Admin (Untuk Staf Administrasi) ---
    public function adminIndex()
    {
        $statusPpdb = ['calon', 'diverifikasi', 'menunggu_screening', 'tidak_diterima'];
        $calonSiswa = Siswa::whereIn('status', $statusPpdb)
                            ->orderBy('created_at', 'desc')
                            ->get();    
        return view('admin.ppdb.index', compact('calonSiswa'));
    }

    public function adminShow(Siswa $siswa)
    {
        return view('admin.ppdb.show', compact('siswa'));
    }

    public function adminEdit(Siswa $siswa)
    {
        return view('admin.ppdb.edit', compact('siswa'));
    }

    /**
     * Memproses pembaruan data pendaftar.
     */
    public function adminUpdate(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:255',
            'nisn' => ['nullable', 'string', 'max:255', Rule::unique('siswa')->ignore($siswa->id)],
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
            // Dokumen bersifat opsional saat update
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ayah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ibu' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kia' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Fungsi untuk mengupdate file: hapus yang lama, simpan yang baru
        $updateFile = function ($fieldName, $path) use ($request, $siswa, &$validated) {
            if ($request->hasFile($fieldName)) {
                // Hapus file lama jika ada
                if ($siswa->$fieldName && Storage::disk('public')->exists($siswa->$fieldName)) {
                    Storage::disk('public')->delete($siswa->$fieldName);
                }
                // Simpan file baru
                $validated[$fieldName] = $request->file($fieldName)->store($path, 'public');
            }
        };

        // Panggil fungsi untuk setiap file
        $updateFile('kk', 'dokumen_ppdb/kk');
        $updateFile('ktp_ayah', 'dokumen_ppdb/ktp_ayah');
        $updateFile('ktp_ibu', 'dokumen_ppdb/ktp_ibu');
        $updateFile('akta_kelahiran', 'dokumen_ppdb/akta');
        $updateFile('kia', 'dokumen_ppdb/kia');
        $updateFile('foto', 'dokumen_ppdb/foto');

        $siswa->update($validated);

        return redirect()->route('admin.ppdb.show', $siswa->id)->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    /**
     * Mengubah status calon siswa.
     */
    public function updateStatus(Request $request, Siswa $siswa)
    {
        // PERBARUI LOGIKA STATUS
        $request->validate([
            'status' => 'required|in:diverifikasi,tidak_diterima', // Admin hanya bisa verifikasi atau tolak
        ]);

        $siswa->status = $request->status;
        $siswa->save();

        $pesan = $request->status == 'diverifikasi'
            ? 'Data siswa berhasil diverifikasi dan diteruskan ke bagian keuangan.'
            : 'Pendaftaran siswa berhasil ditolak.';

        return redirect()->route('admin.ppdb.index')->with('success', $pesan);
    }

    // --- Bagian Screening (Untuk Wali Kelas / Tim) ---
    public function screeningIndex()
    {
        $siswaMenungguScreening = Siswa::where('status', 'menunggu_screening')->latest()->get();
        return view('admin.screening.index', compact('siswaMenungguScreening'));
    }

    public function screeningUpdate(Request $request, Siswa $siswa)
    {
        $request->validate([
            'status' => 'required|in:aktif,tidak_diterima',
            // Tambah validasi untuk file (opsional)
            'hasil_screening' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $updateData = ['status' => $request->status];

        // Proses upload file jika ada
        if ($request->hasFile('hasil_screening')) {
            // Hapus file lama jika ada
            if ($siswa->hasil_screening && Storage::disk('public')->exists($siswa->hasil_screening)) {
                Storage::disk('public')->delete($siswa->hasil_screening);
            }
            // Simpan file baru dan tambahkan path ke data update
            $updateData['hasil_screening'] = $request->file('hasil_screening')->store('hasil_screening', 'public');
        }

        // Generate NIS jika status diubah menjadi 'aktif' dan NIS belum ada
        if ($request->status == 'aktif' && is_null($siswa->nis)) {
            $latestSiswa = Siswa::whereNotNull('nis')->orderBy('nis', 'desc')->first();
            $newNumber = $latestSiswa ? ((int) $latestSiswa->nis) + 1 : 1;
            $updateData['nis'] = str_pad($newNumber, 6, '0', STR_PAD_LEFT);
        }

        $siswa->update($updateData);

        return redirect()->route('screening.index')->with('success', 'Hasil screening siswa berhasil disimpan.');
    }
}