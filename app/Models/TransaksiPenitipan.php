<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenitipan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'transaksi_penitipan';
    protected $primaryKey = 'id_transaksi_penitipan';

    protected $fillable = [
        'id_barang',
        'id_pegawai',
        'bonus',
        'total_penghasilan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

}
