<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanBuku;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;



class BukuController extends Controller
{

    public function index()
    {
        $buku = Buku::orderBy("id", "desc")->get();
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.buku.index', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'notifPengajuanSidebar'));
    }

    public function create()
    {
        $buku = Buku::all();
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.buku.create', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'notifPengajuanSidebar'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:bukus,judul',
            'tahunTerbit' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'code' => 'required',
            'id_kategori' => 'required',
            'id_penulis' => 'required',
            'id_penerbit' => 'required',
            'fotoBuku' => 'required|max:4000|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $buku = new buku();
        $buku->judul = $request->judul;
        $buku->tahunTerbit = $request->tahunTerbit;
        $buku->stok = $request->stok;
        $buku->deskripsi = $request->deskripsi;
        $buku->code = $request->code;
        $buku->id_kategori = $request->id_kategori;
        $buku->id_penulis = $request->id_penulis;
        $buku->id_penerbit = $request->id_penerbit;

        if ($request->hasFile('fotoBuku')) {
            $img = $request->file('fotoBuku');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/buku/', $name);
            $buku->fotoBuku = $name;
        }

        $buku->save();
        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('buku.index');
    }

    public function show($id)
    {
        $buku = Buku::findorfail($id);
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.buku.detail', compact('buku', 'user', 'notifPengajuanSidebar'));
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.buku.edit', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'notifPengajuanSidebar'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => 'required',
                'tahunTerbit' => 'required',
                'stok' => 'required',
                'deskripsi' => 'required',
                'code' => 'required',
                'id_kategori' => 'required',
                'id_penulis' => 'required',
                'id_penerbit' => 'required',
                'fotoBuku' => 'nullable|max:4000|mimes:jpeg,png,jpg,gif,svg',
            ]
        );

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $buku = Buku::findOrFail($id);
        $buku->judul = $request->judul;
        $buku->tahunTerbit = $request->tahunTerbit;
        $buku->stok = $request->stok;
        $buku->deskripsi = $request->deskripsi;
        $buku->code = $request->code;
        $buku->id_kategori = $request->id_kategori;
        $buku->id_penulis = $request->id_penulis;
        $buku->id_penerbit = $request->id_penerbit;

        if ($request->hasFile('fotoBuku')) {
            $buku->deleteImage();
            $img = $request->file('fotoBuku');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/buku/', $name);
            $buku->fotoBuku = $name;
        }

        $buku->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('buku.index');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('buku.index');
    }

    public function import()
    {
        $buku = Buku::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.buku.importExcel', compact('buku', 'user', 'notifPengajuanSidebar'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file, "r");

        $duplikasi = [];
        $errors = [];

        if ($handle !== false) {
            while (($row = fgetcsv($handle, 1000, "\t")) !== false) {
                if (empty($row) || count($row) < 9) {
                    $errors[] = "Format CSV tidak valid atau data kurang di salah satu baris.";
                    continue;
                }

                if ($row[0] == "Judul" || empty($row[0])) {
                    continue; // Lewati header CSV
                }

                $judul = trim($row[0] ?? '');
                $stok = trim($row[1] ?? '');
                $tahunTerbit = trim($row[2] ?? '');
                $code = trim($row[3] ?? '');
                $fotoBuku = trim($row[4] ?? 'default.jpg'); // Default foto jika kosong
                $deskripsi = trim($row[5] ?? '');
                $id_kategori = trim($row[6] ?? '');
                $id_penulis = trim($row[7] ?? '');
                $id_penerbit = trim($row[8] ?? '');

                if (empty($judul) || empty($stok) || empty($tahunTerbit) || empty($code) || empty($id_kategori) || empty($id_penulis) || empty($id_penerbit)) {
                    $errors[] = "Data tidak lengkap untuk buku: $judul";
                    continue;
                }

                if (Buku::where('code', $code)->exists()) {
                    $duplikasi[] = $judul;
                } else {
                    Buku::create([
                        'judul' => $judul,
                        'stok' => $stok,
                        'tahunTerbit' => $tahunTerbit,
                        'code' => $code,
                        'fotoBuku' => $fotoBuku,
                        'deskripsi' => $deskripsi,
                        'id_kategori' => $id_kategori,
                        'id_penulis' => $id_penulis,
                        'id_penerbit' => $id_penerbit,
                    ]);
                }
            }
            fclose($handle);
        }

        // Tampilkan notifikasi jika ada duplikasi atau kesalahan data
        if (!empty($errors)) {
            Alert::error('Error', implode("\n", $errors))->autoClose(5000);
        } elseif (!empty($duplikasi)) {
            Alert::warning('Warning', 'Beberapa buku sudah ada: ' . implode(", ", $duplikasi))->autoClose(4000);
        } else {
            Alert::success('Success', 'Data buku berhasil diimport')->autoClose(2000);
        }

        return redirect()->route('buku.index');
    }


    public function exportCsv()
    {
        $fileName = 'buku.csv';

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Judul', 'Stok', 'Tahun Terbit', 'Code', 'Foto Buku', 'Deskripsi', 'Kategori', 'Penulis', 'Penerbit']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
