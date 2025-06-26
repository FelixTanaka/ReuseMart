<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    protected $primaryKey = 'id_merch';

    public $timestamps = false;

    protected $table = 'merchandise';

    protected $fillable = [
        'id_merch',
        'nama_merch',
        'poin_merch',
        'foto_merch',
        'stok_merch',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
