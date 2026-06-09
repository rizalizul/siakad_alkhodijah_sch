<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;
    protected $table = 'guru_mapel';
    // protected $fillable = ['guru_id', 'mapel_id', 'tahun_ajaran_id'];
    protected $fillable = [
        'tahun_ajaran_nama',
        'guru_id', 
        'mapel_id'
    ];

    public function guru() { return $this->belongsTo(Guru::class); }
    public function mapel() { return $this->belongsTo(MataPelajaran::class, 'mapel_id'); }
}