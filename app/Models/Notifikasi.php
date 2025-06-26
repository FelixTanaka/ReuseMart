<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi'; // nama tabel kamu

    protected $primaryKey = 'id_notifikasi';

    public $timestamps = false; // jika tidak ada created_at / updated_at

    protected $fillable = [
        'pesan_pembeli',
        'id_transaksi_pembelian',
        'pesan_penitip',
    ];

    public function transaksipembelian()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'id_transaksi_pembelian', 'id_transaksi_pembelian');
    }
}
