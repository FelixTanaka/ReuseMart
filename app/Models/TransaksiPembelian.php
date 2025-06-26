<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'transaksi_pembelian';
    protected $primaryKey= 'id_transaksi_pembelian';

    protected $fillable = [
        'tanggal_transaksi',
        'harga_barang',
        'total_harga_transaksi',
        'harga_ongkir',
        'poin_masuk',
        'poin_keluar',
        'poin_pembeli',
        'status_pembelian',
        'jadwal_pengiriman',
        'metode_pengiriman',
        'status_pengiriman',
        'alamat_pengiriman',
        'jadwal_pengambilan',
        'id_pembeli',
        'id_pegawai',
        'id_barang',
    ];

    // Relasi dengan Pembeli
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli');
    }

    // Relasi dengan Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
