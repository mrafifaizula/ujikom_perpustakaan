<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Http\Controllers\Controller;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.artikel.index', compact('artikel', 'user', 'notifPengajuanSidebar'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:artikels,judul',
            'gambar' => 'required|max:4000|mimes:jpeg,png,jpg,gif,svg',
            'deskripsi' => 'required',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.unique' => 'Judul sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Error', 'Error: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $artikel = new Artikel();
        $artikel->judul = $request->judul;
        $artikel->deskripsi = $request->deskripsi;
        if ($request->hasFile('gambar')) {
            $img = $request->file('gambar');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/artikel/', $name);
            $artikel->gambar = $name;
        }
        $artikel->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('artikel.index');
    }

    public function show(Artikel $artikel)
    {
        //
    }

    public function edit(Artikel $artikel)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'gambar' => 'nullable|max:4000|mimes:jpeg,png,jpg,gif,svg',
            'deskripsi' => 'required',
        ], [
            'judul.required' => 'Judul Harus Diisi',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first('judul');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $artikel = artikel::findOrFail($id);
        $artikel->judul = $request->judul;
        $artikel->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $artikel->deleteImage();
            $img = $request->file('gambar');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/artikel/', $name);
            $artikel->gambar = $name;
        }

        $artikel->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('artikel.index');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        $artikel->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('artikel.index');
    }
}
