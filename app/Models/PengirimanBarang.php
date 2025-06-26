<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengirimanBarang extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id_pengiriman';

    protected $table = 'pengiriman_barang'; // Nama tabel dalam database

    protected $fillable = [
        'id_pegawai',
        'id_transaksi_pembelian',
    ];

    // Relasi dengan Kategori
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    // Relasi dengan Pegawai
    public function transaksiPembelian()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'id_transaksi_pembelian');
    }

}
