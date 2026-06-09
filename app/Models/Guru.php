<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $fillable = [
        'user_id', 'nip', 'nama', 'jenis_kelamin', 'email', 'telepon', 'alamat', 'foto'
    ];

    // Relasi ke model User
    public function user() { return $this->belongsTo(User::class); }

    // Relasi jika guru menjadi wali kelas
    public function kelasWali() { return $this->hasOne(Kelas::class, 'wali_kelas_id'); }
}