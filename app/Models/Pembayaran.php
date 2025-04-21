<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{

    protected $fillable = [
        'tanggalPembayaran',
        'metodePembayaran',
        'totalPembayaran',
        'id_denda'
    ];


    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_denda');
    }
}
