<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $fillable = ['totalDenda', 'statusPembayaran', 'jenisDenda', 'hariTelat', 'id_peminjaman', 'id_pengembalian'];
    protected $visible = ['totalDenda', 'statusPembayaran', 'jenisDenda', 'hariTelat', 'id_peminjaman', 'id_pengembalian'];
    public $timestamps = true;

    public function peminjamanBuku()
    {
        return $this->belongsTo(PeminjamanBuku::class, 'id_peminjaman');
    }
}
