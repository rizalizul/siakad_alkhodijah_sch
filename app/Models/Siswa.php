<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'no_pendaftaran', 'nama', 'nama_panggilan', 'nisn', 'nis', 'tanggal_lahir', 'tempat_lahir',
        'jenis_kelamin', 'agama', 'pendidikan_sebelumnya', 'alamat_siswa',
        'no_wa_siswa', 'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu',
        'no_wa_ortu', 'alamat_ortu', 'nama_wali', 'pekerjaan_wali', 'alamat_wali',
        'kk', 'ktp_ayah', 'ktp_ibu', 'foto', 'hasil_screening', 'akta_kelahiran', 'kia', 
        'status', 'tahun_ajaran_ppdb', 'guardian_user_id'
    ];

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}