<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = ['judul', 'gambar', 'deskripsi'];
    protected $visible = ['judul', 'gambar', 'deskripsi'];
    public $timestamps = true;

    public function deleteImage()
    {
        $imagePath = public_path('images/artikel/' . $this->gambar);

        if ($this->gambar && file_exists($imagePath)) {
            return unlink($imagePath);
        }

        return false;
    }
}
