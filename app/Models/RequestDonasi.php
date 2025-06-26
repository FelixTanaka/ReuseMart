<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestDonasi extends Model
{
    protected $primaryKey = 'id_request';

    public $timestamps = false;

    protected $table = 'requestdonasi';

    protected $fillable = [
        'deskripsi_request',
        'tanggal_request',
        'status_request',
        'id_organisasi',
        'id_pegawai',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi');
    }
}
