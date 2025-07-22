<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = ['nama', 'nip', 'jenis_kelamin', 'email', 'no_hp', 'foto'];
}
