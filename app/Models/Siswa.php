<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama', 'nisn', 'nis', 'tanggal_lahir', 'guardian_id',
        'nama_panggilan', 'jenis_kelamin', 'tempat_lahir', 'agama',
        'pendidikan_sebelumnya', 'alamat_siswa', 'no_wa_siswa',
        'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu',
        'no_wa_ortu', 'alamat_ortu', 'kelurahan', 'kecamatan', 'kota', 'provinsi',
        'nama_wali', 'pekerjaan_wali', 'alamat_wali',
        'kk', 'ktp_ayah', 'ktp_ibu', 'akta', 'kta', 'foto'
    ];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
}
