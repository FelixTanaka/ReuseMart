<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komisi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'id_komisi';

    protected $table = 'komisi';

    protected $fillable = [
        'komisi_hunter',
        'komisi_reusemart',
        'komisi_penitip',
        'id_transaksi_pembelian',
        'id_pegawai',
    ];

    // Relasi dengan Kategori
    public function transaksipembelian()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'id_transaksi_pembelian');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    
}
