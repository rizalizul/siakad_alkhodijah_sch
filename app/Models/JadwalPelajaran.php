<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;
    protected $table = 'jadwal_pelajaran';

    protected $fillable = [
        'tahun_ajaran_nama',
        'kelas_id', 
        'mapel_id', 
        'guru_id', 
        'hari',
        'jam_mulai', 
        'jam_selesai'
    ];

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function mapel() { return $this->belongsTo(MataPelajaran::class, 'mapel_id'); }
    public function guru() { return $this->belongsTo(Guru::class); }
    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'guru_id', 'guru_id')
                    ->where('mapel_id', $this->mapel_id)
                    ->where('tahun_ajaran_nama', $this->tahun_ajaran_nama);
    }
}