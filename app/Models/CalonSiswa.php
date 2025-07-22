<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;
    protected $table = 'calon_siswa';

    protected $fillable = [
        'nisn', 'nama_lengkap', 'nama_panggilan', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'agama', 'pendidikan_sebelumnya', 'alamat_siswa', 'no_wa_siswa',
        'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu', 'no_wa_ortu', 'alamat_ortu',
        'kelurahan', 'kecamatan', 'kota', 'provinsi',
        'nama_wali', 'pekerjaan_wali', 'alamat_wali',
        'kk', 'ktp_ayah', 'ktp_ibu', 'akta', 'kta', 'foto',
        'status',
    ];
}