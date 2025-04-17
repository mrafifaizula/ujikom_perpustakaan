<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranManual extends Model
{
    protected $fillable = [
        'tanggalPembayaran',
        'metodePembayaran',
        'catatan',
        'id_denda',
    ];

    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_denda');
    }
}
