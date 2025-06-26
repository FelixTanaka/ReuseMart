<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organisasi extends Authenticatable
{
    use HasFactory, HasApiTokens;
    public $timestamps = false;

    protected $table = 'organisasi';
    protected $primaryKey = 'id_organisasi';

    protected $fillable = [
        'nama_organisasi',
        'alamat_organisasi',
        'no_telp_organisasi',
        'email_organisasi',
        'foto_organisasi',
        'password_organisasi'
    ];
}