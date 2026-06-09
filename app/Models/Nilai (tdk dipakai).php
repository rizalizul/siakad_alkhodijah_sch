<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    protected $fillable = [
        'kelas_siswa_id', 'mapel_id', 'tahun_ajaran_id',
        'jenis_nilai', 'nilai', 'deskripsi'
    ];

    public function kelasSiswa() { return $this->belongsTo(KelasSiswa::class); }
    public function mapel() { return $this->belongsTo(MataPelajaran::class, 'mapel_id'); }
}