<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $fillable = ['nama', 'tahun_pelajaran_id', 'aktif'];

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }
}