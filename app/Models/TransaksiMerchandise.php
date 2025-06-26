<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMerchandise extends Model
{
    protected $table = 'transaksi_merchandise';

    protected $primaryKey = 'id_transaksi_merch';

    public $timestamps = false;

    protected $fillable = [
        'tanggal_reedem',
        'tanggal_pengambilan',
        'id_pembeli',
        'id_merch',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'id_pembeli');
    }

    // Relasi ke Merchandise
    public function merchandise()
    {
        return $this->belongsTo(Merchandise::class, 'id_merch');
    }
}
