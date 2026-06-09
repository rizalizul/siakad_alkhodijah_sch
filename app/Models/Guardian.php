<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Guardian extends Authenticatable
{
    use HasRoles;
    protected $fillable = ['name', 'email', 'phone'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
