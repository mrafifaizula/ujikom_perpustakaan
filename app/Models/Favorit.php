<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $fillable = ['id_buku', 'id_user'];
    protected $visible = ['id_buku', 'id_user'];
    public $timestamps = true;

    public function Buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
