<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\kelas;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KelasController extends Controller
{

    public function index()
    {
        $kelas = Kelas::orderBy("id", "desc")->get();
        $user = Auth::user();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.kelas.index', compact('kelas', 'user'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaKelas' => 'required|unique:kelas,namaKelas',
        ], [
            'namaKelas.required' => 'Nama kelas wajib diisi.',
            'namaKelas.unique' => 'Nama kelas sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Error', 'Error: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $kelas = new kelas();
        $kelas->namaKelas = $request->namaKelas;
        $kelas->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('kelas.index');
    }


    public function show(kelas $kelas)
    {
        //
    }


    public function edit(kelas $kelas)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'namaKelas' => 'required',
        ], [
            'namaKelas.required' => 'Nama kelas Harus Diisi',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first('namaKelas');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kelas = kelas::findOrFail($id);
        $kelas->namaKelas = $request->namaKelas;

        $kelas->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('kelas.index');
    }


    public function destroy($id)
    {
        $kelas = kelas::findOrFail($id);

        if ($kelas->siswa()->count() > 0) {
            Alert::error('Error', 'kelas ini tidak bisa dihapus karena ada siswa yang terkait.')->autoClose(2000);
            return redirect()->route('kelas.index');
        }

        $kelas->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('kelas.index');
    }

    public function import()
    {
        $kelas = Kategori::all();
        $user = Auth::user();

        return view('backend.kelas.importExcel', compact('kelas', 'user'));
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
                $namaKelas = trim($row[0]);

                if (!empty($namaKelas) && $namaKelas != "Nama Kelas") {
                    if (Kelas::where('namaKelas', $namaKelas)->exists()) {
                        $duplikasi[] = $namaKelas;
                    } else {
                        Kelas::create(['namaKelas' => $namaKelas]);
                    }
                }
            }
            fclose($handle);
        }

        if (!empty($duplikasi)) {
            Alert::warning('Warning', 'Beberapa kelas sudah ada: ' . implode(", ", $duplikasi))->autoClose(4000);
        } else {
            Alert::success('Success', 'Data berhasil diimport')->autoClose(2000);
        }

        return redirect()->route('kelas.index');
    }

    public function exportCsv()
    {
        $fileName = 'kelas.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Kelas']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
