<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    use HasFactory, HasApiTokens;
    public $timestamps = false;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'nama_pegawai',
        'no_telp_pegawai',
        'password_pegawai',
        'email_pegawai',
        'alamat_pegawai',
        'id_role'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function komisi()
    {
        return $this->hasMany(Komisi::class, 'id_pegawai', 'id_pegawai');
    }

}
