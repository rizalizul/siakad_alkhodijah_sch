<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'jenis_pembayaran';

    protected $fillable = ['nama_jenis', 'jumlah_default', 'tahun_ajaran_nama'];

    public function tahunAjaran()
    {
        return $this->hasMany(TahunAjaran::class, 'nama', 'tahun_ajaran_nama');
    }
    protected $casts = [
        'jumlah_default' => 'integer',
    ];
}
