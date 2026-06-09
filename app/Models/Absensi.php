<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = [
        'kelas_siswa_id', 'tanggal', 'status', 'keterangan', 'recorded_by'
    ];

    public function kelasSiswa() { return $this->belongsTo(KelasSiswa::class); }
    public function user() { return $this->belongsTo(User::class, 'recorded_by'); }
}