<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use App\Models\Penulis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PenulisController extends Controller
{

    public function index()
    {
        $penulis = Penulis::orderBy("id", "desc")->get();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();


        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.penulis.index', compact('penulis', 'user', 'notifPengajuanSidebar'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaPenulis' => 'required|unique:penulis,namaPenulis',
        ], [
            'namaPenulis.required' => 'Nama Kategori wajib diisi.',
            'namaPenulis.unique' => 'Nama Kategori sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $penulis = new Penulis();
        $penulis->namaPenulis = $request->namaPenulis;
        $penulis->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('penulis.index');
    }


    public function show(Penulis $penulis)
    {
        //
    }


    public function edit(Penulis $penulis)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'namaPenulis' => 'required',
        ], [
            'namaPenulis.required' => 'Nama penulis Harus Diisi',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first('namaPenulis');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penulis = Penulis::findOrFail($id);
        $penulis->namaPenulis = $request->namaPenulis;

        $penulis->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('penulis.index');
    }


    public function destroy($id)
    {
        $penulis = Penulis::findOrFail($id);

        if ($penulis->buku()->count() > 0) {
            Alert::error('Error', 'penulis ini tidak bisa dihapus karena ada buku yang terkait.')->autoClose(2000);
            return redirect()->route('penulis.index');
        }

        $penulis->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('penulis.index');
    }

    public function import()
    {
        $penulis = Penulis::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.penulis.importExcel', compact('penulis', 'user', 'notifPengajuanSidebar'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file, "r");

        $duplikasi = []; // Array untuk menyimpan penulis yang sudah ada

        if ($handle !== false) {
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                $namaPenulis = trim($row[0]);

                if (!empty($namaPenulis) && $namaPenulis != "Nama Penulis") {
                    // Cek apakah Penulis sudah ada
                    if (Penulis::where('namaPenulis', $namaPenulis)->exists()) {
                        $duplikasi[] = $namaPenulis;
                    } else {
                        Penulis::create(['namaPenulis' => $namaPenulis]);
                    }
                }
            }
            fclose($handle);
        }

        // Jika ada duplikasi, tampilkan pesan
        if (!empty($duplikasi)) {
            Alert::warning('Warning', 'Beberapa penulis sudah ada: ' . implode(", ", $duplikasi))->autoClose(4000);
        } else {
            Alert::success('Success', 'Data berhasil diimport')->autoClose(2000);
        }

        return redirect()->route('penulis.index');
    }

    public function exportCsv()
    {
        $fileName = 'penulis.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Penulis']); // Only the header without any data

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
