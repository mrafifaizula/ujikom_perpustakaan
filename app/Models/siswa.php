<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    protected $fillable = ['nis', 'foto', 'no_hp', 'id_kelas', 'id_user'];
    protected $visible = ['nis', 'foto', 'no_hp', 'id_kelas', 'id_user'];
    public $timestamps = true;

    public function deleteImage()
    {
        $imagePath = public_path('images/artikel/' . $this->foto);

        if ($this->foto && file_exists($imagePath)) {
            return unlink($imagePath);
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
