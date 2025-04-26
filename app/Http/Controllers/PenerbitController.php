<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class PenerbitController extends Controller
{

    public function index()
    {
        $penerbit = Penerbit::orderBy("id", "desc")->get();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.penerbit.index', compact('penerbit', 'user', 'notifPengajuanSidebar'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaPenerbit' => 'required|unique:penerbits,namaPenerbit',
        ], [
            'namaPenerbit.required' => 'Nama Penerbit wajib diisi.',
            'namaPenerbit.unique' => 'Nama Penerbit sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $penerbit = new Penerbit();
        $penerbit->namaPenerbit = $request->namaPenerbit;
        $penerbit->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('penerbit.index');
    }


    public function show(Penerbit $penerbit)
    {
        //
    }


    public function edit(Penerbit $penerbit)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'namaPenerbit' => 'required',
        ], [
            'namaPenerbit.required' => 'Nama penerbit Harus Diisi',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first('namaPenerbit');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penerbit = Penerbit::findOrFail($id);
        $penerbit->namaPenerbit = $request->namaPenerbit;

        $penerbit->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('penerbit.index');
    }


    public function destroy($id)
    {
        $penerbit = Penerbit::findOrFail($id);

        if ($penerbit->buku()->count() > 0) {
            Alert::error('Error', 'penerbit ini tidak bisa dihapus karena ada buku yang terkait.')->autoClose(2000);
            return redirect()->route('penerbit.index');
        }

        $penerbit->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('penerbit.index');
    }

    public function import()
    {
        $penerbit = Penerbit::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.penerbit.importExcel', compact('penerbit', 'user', 'notifPengajuanSidebar'));
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
                $namaPenerbit = trim($row[0]);

                if (!empty($namaPenerbit) && $namaPenerbit != "Nama Penerbit") {
                    if (Penerbit::where('namaPenerbit', $namaPenerbit)->exists()) {
                        $duplikasi[] = $namaPenerbit;
                    } else {
                        Penerbit::create(['namaPenerbit' => $namaPenerbit]);
                    }
                }
            }
            fclose($handle);
        }

        if (!empty($duplikasi)) {
            Alert::warning('Warning', 'Beberapa penerbit sudah ada: ' . implode(", ", $duplikasi))->autoClose(4000);
        } else {
            Alert::success('Success', 'Data berhasil diimport')->autoClose(2000);
        }

        return redirect()->route('penerbit.index');
    }

    public function exportCsv()
    {
        $fileName = 'penerbit.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Penerbit']); // Only the header without any data

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
