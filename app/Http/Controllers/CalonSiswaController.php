<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa; // model siswa

class CalonSiswaController extends Controller
{
    public function index()
    {
        $data = CalonSiswa::latest()->get();
        return view('ppdb.data_calon_siswa', compact('data'));
    }

    public function formulir()
    {
        return view('ppdb.pendaftaran_siswa_baru');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_wa_ortu' => 'required|string',
            // validasi file opsional
            'kk' => 'nullable|image|max:2048',
            'ktp_ayah' => 'nullable|image|max:2048',
            'ktp_ibu' => 'nullable|image|max:2048',
            'akta' => 'nullable|image|max:2048',
            'kta' => 'nullable|image|max:2048',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Upload file
        $uploadFields = ['kk', 'ktp_ayah', 'ktp_ibu', 'akta', 'kta', 'foto'];
        $data = $request->except($uploadFields);

        foreach ($uploadFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('ppdb', 'public');
            }
        }

        CalonSiswa::create($data);

        return redirect()->route('ppdb.index')->with('success', 'Pendaftaran berhasil!');
    }

    public function verifikasiForm($id)
    {
        $calon = CalonSiswa::findOrFail($id);
        return view('ppdb.verifikasi_calon', compact('calon'));
    }

    public function prosesVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak'
        ]);

        $calon = CalonSiswa::findOrFail($id);
        $calon->status = $request->status;
        $calon->save();

        // Jika diterima, simpan ke tabel siswa
        if ($request->status === 'diterima') {
            $latestNis = Siswa::max('nis');
            $newNis = $latestNis ? (int)$latestNis + 1 : 1;
            $newNisFormatted = str_pad($newNis, 6, '0', STR_PAD_LEFT);

            Siswa::create([
                'nisn' => $calon->nisn,
                'nis' => $newNisFormatted,
                'nama' => $calon->nama_lengkap,
                'nama_panggilan' => $calon->nama_panggilan,
                'jenis_kelamin' => $calon->jenis_kelamin,
                'tempat_lahir' => $calon->tempat_lahir,
                'tanggal_lahir' => $calon->tanggal_lahir,
                'agama' => $calon->agama,
                'pendidikan_sebelumnya' => $calon->pendidikan_sebelumnya,
                'alamat_siswa' => $calon->alamat_siswa,
                'no_wa_siswa' => $calon->no_wa_siswa,

                'nama_ayah' => $calon->nama_ayah,
                'nama_ibu' => $calon->nama_ibu,
                'pekerjaan_ayah' => $calon->pekerjaan_ayah,
                'pekerjaan_ibu' => $calon->pekerjaan_ibu,
                'no_wa_ortu' => $calon->no_wa_ortu,
                'alamat_ortu' => $calon->alamat_ortu,
                'kelurahan' => $calon->kelurahan,
                'kecamatan' => $calon->kecamatan,
                'kota' => $calon->kota,
                'provinsi' => $calon->provinsi,
                'nama_wali' => $calon->nama_wali,
                'pekerjaan_wali' => $calon->pekerjaan_wali,
                'alamat_wali' => $calon->alamat_wali,

                'kk' => $calon->kk,
                'ktp_ayah' => $calon->ktp_ayah,
                'ktp_ibu' => $calon->ktp_ibu,
                'akta' => $calon->akta,
                'kta' => $calon->kta,
                'foto' => $calon->foto,

                'guardian_id' => null,
            ]);
        }
        return redirect()->route('ppdb.index')->with('success', 'Verifikasi berhasil disimpan.');
    }
}
