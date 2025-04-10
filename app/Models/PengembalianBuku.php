<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianBuku extends Model
{
    protected $fillable = ['id_peminjaman', 'tanggalPengembalian', 'pesan'];
    protected $visible = ['id_peminjaman', 'tanggalPengembalian', 'pesan'];
    public $timestamps = true;

    // PengembalianBuku.php
    public function peminjamanBuku()
    {
        return $this->belongsTo(PeminjamanBuku::class, 'id_peminjaman');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_pengembalian');
    }


}
