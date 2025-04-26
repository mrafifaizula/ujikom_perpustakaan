<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy("id", "desc")->get();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.kategori.index', compact('kategori', 'user', 'notifPengajuanSidebar'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaKategori' => 'required|unique:kategoris,namaKategori',
        ], [
            'namaKategori.required' => 'Nama Kategori wajib diisi.',
            'namaKategori.unique' => 'Nama Kategori sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Error', 'Error: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $kategori = new Kategori();
        $kategori->namaKategori = $request->namaKategori;
        $kategori->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('kategori.index');
    }

    public function show(Kategori $kategori)
    {
        //
    }

    public function edit(Kategori $kategori)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'namaKategori' => 'required',
        ], [
            'namaKategori.required' => 'Nama Kategori Harus Diisi',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first('namaKategori');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kategori = Kategori::findOrFail($id);
        $kategori->namaKategori = $request->namaKategori;

        $kategori->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->buku()->count() > 0) {
            Alert::error('Error', 'Kategori ini tidak bisa dihapus karena ada buku yang terkait.')->autoClose(2000);
            return redirect()->route('kategori.index');
        }

        $kategori->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route(route: 'kategori.index');
    }

    public function import()
    {
        $kategori = Kategori::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.kategori.importExcel', compact('kategori', 'user', 'notifPengajuanSidebar'));
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
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                $namaKategori = trim($row[0]);

                if (!empty($namaKategori) && $namaKategori != "Nama Kategori") {
                    // Cek apakah kategori sudah ada
                    if (Kategori::where('namaKategori', $namaKategori)->exists()) {
                        $duplikasi[] = $namaKategori;
                    } else {
                        Kategori::create(['namaKategori' => $namaKategori]);
                    }
                }
            }
            fclose($handle);
        }

        if (!empty($duplikasi)) {
            Alert::warning('Warning', 'Beberapa kategori sudah ada: ' . implode(", ", $duplikasi))->autoClose(4000);
        } else {
            Alert::success('Success', 'Data berhasil diimport')->autoClose(2000);
        }

        return redirect()->route('kategori.index');
    }

    public function exportCsv()
    {
        $fileName = 'kategori.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Kategori']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
