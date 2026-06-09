<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $fillable = [
        'tagihan_id', 'nomor_kwitansi', 'jumlah_bayar', 'tanggal_bayar',
        'metode_bayar', 'bukti_pembayaran', 'termin_ke', 'dicatat_oleh_user_id', 'keterangan'
    ];

    public function tagihan() { return $this->belongsTo(Tagihan::class); }
    public function user() { return $this->belongsTo(User::class, 'dicatat_oleh_user_id'); }
}