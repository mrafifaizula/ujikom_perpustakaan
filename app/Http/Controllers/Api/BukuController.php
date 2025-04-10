<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index()
    {
        // Ambil semua data buku
        $buku = Buku::all()->map(function ($item) {
            // Memastikan fotoBuku memiliki URL lengkap
            if (!Str::startsWith($item->fotoBuku, 'http')) {
                $item->fotoBuku = url('images/buku/' . $item->fotoBuku);  // Menghasilkan URL lengkap
            }
            return $item;
        });

        // Mengembalikan data buku dalam format JSON
        return response()->json(['buku' => $buku->toArray()]);
    }



    public function show($id)
    {
        $buku = Buku::with(['kategori', 'penulis', 'penerbit'])->findOrFail($id);

        return response()->json($buku);
    }
}
