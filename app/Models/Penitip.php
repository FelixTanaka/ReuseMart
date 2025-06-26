<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Penitip extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    public $timestamps = false;

    protected $table = 'penitip';
    protected $primaryKey = 'id_penitip';

    protected $fillable = [
        'nama_penitip',
        'no_telp_penitip',
        'email_penitip',
        'password_penitip',
        'poin_penitip',
        'saldo_penitip',
        'nik_penitip',
        'badge_penitip',
        'rating_penitip',
        'total_barang_terjual',
        'gambar_penitip',
    ];
}