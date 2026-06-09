<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class KelasSiswa extends Model
{
    use HasFactory;
    protected $table = 'kelas_siswa';
    // protected $fillable = ['siswa_id', 'kelas_id', 'tahun_ajaran_id'];
    protected $fillable = [
        'tahun_ajaran_nama',
        'siswa_id', 
        'kelas_id'
    ];

    public function siswa(): BelongsTo 
    { 
        return $this->belongsTo(Siswa::class); 
    }

    public function kelas(): BelongsTo 
    { 
        return $this->belongsTo(Kelas::class); 
    }

    public function rapor(): HasOne
    {
        return $this->hasOne(Rapor::class, 'kelas_siswa_id');
    }
    public function nilaiSumatif()
    {
        return $this->hasMany(NilaiSumatif::class);
    }

    public function nilaiTp()
    {
        return $this->hasMany(NilaiTp::class);
    }
}