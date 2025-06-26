<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_kategori';
    protected $table = 'kategoribarang'; // Nama tabel dalam database

    protected $fillable = [
        'nama_kategori'
    ];
}
