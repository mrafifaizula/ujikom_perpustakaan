<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    protected $fillable = ['namaKelas'];
    protected $visible = ['namaKelas'];
    public $timestamps = true;

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
