<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Penting
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rapor extends Model
{
    use HasFactory;
    protected $table = 'rapor';
    protected $fillable = [
        'kelas_siswa_id', 'tahun_ajaran_id', 'catatan_wali_kelas',
        'naik_kelas', 'status_rapor', 'tanggal_cetak'
    ];

    public function tahunAjaran(): BelongsTo
    {
        // Pastikan foreign key di tabel 'rapor' adalah 'tahun_ajaran_id'
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
    public function kelasSiswa() { return $this->belongsTo(KelasSiswa::class); }
    public function nilaiEkstrakurikuler() { return $this->hasMany(NilaiEkstrakurikuler::class); }
}