<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiEkstrakurikuler extends Model
{
    use HasFactory;
    protected $table = 'nilai_ekstrakurikuler';
    protected $fillable = [
        'rapor_id',
        'nama_ekskul', 'keterangan'
    ];

    public function rapor() { return $this->belongsTo(Rapor::class); }
}