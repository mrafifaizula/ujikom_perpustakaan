<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['namaKategori'];
    protected $visible = ['namaKategori'];
    public $timestamps = true;

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_kategori');  
    }
}
