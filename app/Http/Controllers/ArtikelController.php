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


    public function import()
    {
        $artikel = Artikel::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.artikel.importExcel', compact('artikel', 'user', 'notifPengajuanSidebar'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file, "r");

        $duplikasi = [];

        if ($handle !== false) {
            $isFirstRow = true;

            while (($row = fgetcsv($handle, 1000, ";")) !== false) {
                // Skip header
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }

                // Pastikan minimal ada 3 kolom
                if (count($row) < 3) {
                    continue;
                }

                $judul = trim($row[0]);
                $deskripsi = trim($row[1]);
                $gambar = trim($row[2]);

                if (!empty($judul)) {
                    if (Artikel::where('judul', $judul)->exists()) {
                        $duplikasi[] = $judul;
                    } else {
                        Artikel::create([
                            'judul' => $judul,
                            'deskripsi' => $deskripsi,
                            'gambar' => $gambar ?: 'default.jpg', // Optional: isi default kalau kosong
                        ]);
                    }
                }
            }

            fclose($handle);
        }

        // Feedback
        if (!empty($duplikasi)) {
            Alert::warning('Duplikat', 'Beberapa artikel sudah ada: ' . implode(', ', $duplikasi))->autoClose(4000);
        } else {
            Alert::success('Berhasil', 'Data artikel berhasil diimpor')->autoClose(2000);
        }

        return redirect()->route('artikel.index'); // Ganti kalau route-nya beda
    }


    public function exportCsv()
    {
        $fileName = 'artikel.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['judul artikelss', 'Deskripsi', 'Image'], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
