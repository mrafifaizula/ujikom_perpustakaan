<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    protected $fillable = [
        'tanggalPinjam',
        'batasPeminjaman',
        'jumlah',
        'pesan',
        'status',
        'id_buku',
        'id_user',
    ];
    protected $visible = [
        'tanggalPinjam',
        'batasPeminjaman',
        'jumlah',
        'pesan',
        'status',
        'id_buku',
        'id_user',
    ];
    public $timestamps = true;

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi dengan Buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    // PeminjamanBuku.php
    public function pengembalianBuku()
    {
        return $this->hasMany(PengembalianBuku::class, 'id_peminjaman');
    }

    public function denda()
    {
        return $this->hasMany(Denda::class, 'id_peminjaman');
    }

}
