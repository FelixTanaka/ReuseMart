<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id_barang';

    protected $table = 'barang'; // Nama tabel dalam database

    protected $fillable = [
        'gambar',
        'status',
        'deskripsi',
        'harga_satuan',
        'id_kategori',
        'id_pegawai',
        'id_penitip',
        'nama_barang',
        'tanggal_penitipan',
        'tanggal_keluar',
        'status_penitipan',
        'batas_ambil',
        'status_garansi',
        'masa_penitipan'
    ];

    // Relasi dengan Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi dengan Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }
}
