<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    protected $table = 'tagihan';
    protected $fillable = ['siswa_id', 'jenis_pembayaran_id', 'jumlah_tagihan', 'sisa_tagihan', 'status'];

    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function jenisPembayaran() { return $this->belongsTo(JenisPembayaran::class); }
    public function pembayaran() { return $this->hasMany(Pembayaran::class); }
}