<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    // protected $fillable = ['nama_kelas', 'tingkat_kelas', 'tahun_ajaran_id', 'wali_kelas_id'];
    protected $fillable = [
        'tahun_ajaran_nama', 
        'nama_kelas', 
        'tingkat_kelas', 
        'wali_kelas_id'
    ];

    // public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class); }
    // Relasi ini tidak perlu diubah karena nama methodnya bebas
    public function tahunAjaran() { 
        // Namun, jika Anda perlu relasi langsung, ini perlu diubah logikanya
        // Untuk saat ini kita tidak membutuhkannya
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_nama', 'nama');
    }
    
    public function waliKelas() { return $this->belongsTo(Guru::class, 'wali_kelas_id'); }
    public function kelasSiswa() { return $this->hasMany(KelasSiswa::class); }
    public function jadwalPelajaran() { return $this->hasMany(JadwalPelajaran::class); }
}