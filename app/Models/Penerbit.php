<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $fillable = ['namaPenerbit'];
    protected $visible = ['namaPenerbit'];
    public $timestamps = true;

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_penerbit');  
    }
}
