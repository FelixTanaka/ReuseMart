<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembeli extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    public $timestamps = false;
    protected $table = "pembeli";
    protected $primaryKey = 'id_pembeli';

    protected $fillable = [
        'nama_pembeli',
        'password_pembeli',
        'email_pembeli',
        'no_telp_pembeli',
        'poin_pembeli',
    ];

   
}
