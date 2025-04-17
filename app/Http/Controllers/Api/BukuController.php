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
        $buku = Buku::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Buku',
            'data' => $buku,
        ], 200);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'penulis', 'penerbit'])->findOrFail($id);

        return response()->json($buku);
    }
}
