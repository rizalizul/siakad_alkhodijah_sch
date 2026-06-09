<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTp extends Model
{
    use HasFactory;
    protected $table = 'nilai_tp';
    protected $fillable = ['kelas_siswa_id', 'mapel_id', 'tahun_ajaran_id', 'deskripsi', 'nilai'];
}