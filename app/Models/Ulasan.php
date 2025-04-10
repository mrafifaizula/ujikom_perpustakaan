<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = ['pesan', 'bintang', 'id_pengembalian'];
    protected $visible = ['pesan', 'bintang', 'id_pengembalian'];
    public $timestamps = true;

    public function pengembalianBuku()
    {
        return $this->belongsTo(PengembalianBuku::class, 'id_pengembalian');
    }
}
