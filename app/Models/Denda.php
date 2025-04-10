<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $fillable = ['totalDenda', 'statusPembayaran', 'denda', 'diskon', 'tanggalTelat', 'id_pengembalian'];
    protected $visible = ['totalDenda', 'statusPembayaran', 'denda', 'diskon', 'tanggalTelat', 'id_pengembalian'];
    public $timestamps = true;
}
