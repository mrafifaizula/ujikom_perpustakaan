<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    protected $fillable = ['nis', 'no_hp', 'id_kelas', 'id_user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
