<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{

    protected $fillable = ['judul', 'tahunTerbit', 'stok', 'deskripsi', 'code', 'fotoBuku'];
    protected $visible = ['judul', 'tahunTerbit', 'stok', 'deskripsi', 'code', 'fotoBuku'];
    public $timestamps = true;

    public function deleteImage()
    {
        $imagePath = public_path('images/buku/' . $this->fotoBuku);

        if ($this->fotoBuku && file_exists($imagePath)) {
            return unlink($imagePath);
        }

        return false;
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function Penulis()
    {
        return $this->belongsTo(Penulis::class, 'id_penulis');
    }

    public function Penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function Favorit()
    {
        return $this->hasMany(Favorit::class, 'id_buku');
    }

    public function peminjamanBuku()
    {
        return $this->hasMany(PeminjamanBuku::class, 'id_buku');
    }

}
