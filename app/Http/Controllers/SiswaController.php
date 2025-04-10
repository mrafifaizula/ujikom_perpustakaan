<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderBy("id", "desc")->get();
        $user = Auth::user();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.siswa.index', compact('siswa', 'user'));
    }


    public function create()
    {
        $siswa = Siswa::all();
        $kelas = kelas::all();
        $user = Auth::user();

        return view('backend.siswa.create', compact('siswa', 'kelas', 'user'));
    }


    public function store(Request $request)
    {
        // Validasi untuk memastikan data yang masuk sudah benar
        $validator = Validator::make($request->all(), [
            'nis' => 'required|unique:siswas,nis',
            'no_hp' => 'required',
            'id_kelas' => 'required',
            'email' => 'required|email|unique:users,email',  // Validasi email untuk user
            'password' => 'required|min:6',  // Validasi password untuk user
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data user ke tabel users dengan role 'siswa'
        $user = new User();
        $user->name = $request->name;  // Pastikan name ada di request
        $user->email = $request->email;
        $user->password = bcrypt($request->password);  // Enkripsi password
        $user->role = 'siswa';  // Set role menjadi 'siswa'
        $user->is_active = true;  // Atur status aktif user
        $user->save();

        // Simpan data siswa ke tabel siswas, pastikan untuk mengaitkan dengan user
        $siswa = new Siswa();
        $siswa->nis = $request->nis;
        $siswa->no_hp = $request->no_hp;
        $siswa->id_kelas = $request->id_kelas;
        $siswa->id_user = $user->id;  // Mengisi kolom id_user dengan ID user yang baru saja dibuat
        $siswa->save();

        // Menampilkan notifikasi sukses
        Alert::success('Success', 'Data Siswa dan User Berhasil Disimpan')->autoClose(1000);

        return redirect()->route('siswa.index')->with('success', 'Siswa dan User berhasil dibuat.');
    }



    public function show(siswa $siswa)
    {

    }


    public function edit(siswa $siswa)
    {

    }


    public function update(Request $request, siswa $siswa)
    {
        //
    }


    public function destroy(siswa $siswa)
    {
        //
    }
}
