<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    protected $fillable = ['namaPenulis'];
    protected $visible = ['namaPenulis'];
    public $timestamps = true;

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_penulis');  
    }
}
