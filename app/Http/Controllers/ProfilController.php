<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Kategori;
use App\Models\User;
use Auth;
use App\Models\Buku;
use App\Models\Favorit;
use App\Models\PeminjamanBuku;
use App\Models\PengembalianBuku;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    // dashboar user
    public function dashboard()
    {
        $user = Auth::user();

        return view('profil.dashboard', compact('user'));
    }

    // daftar buku
    public function daftarBuku()
    {
        $buku = Buku::all();
        $user = Auth::user();
        $kategori = Kategori::all();

        $favorit = $user ? $user->Favorit()->pluck('id_buku')->toArray() : [];

        return view('profil.buku.daftarBuku', compact('buku', 'user', 'favorit', 'kategori'));
    }


    // detail daftar buku
    public function detailBuku($judul)
    {
        $buku = Buku::where('judul', $judul)->firstOrFail();
        $user = Auth::user();

        return view('profil.buku.detailBuku', compact('buku', 'user'));
    }


    // profil
    public function profil()
    {
        $user = Auth::user();

        return view('profil.profil', compact('user'));
    }

    // data peminjaman sesuai user
    public function dataPeminjaman($name)
    {
        $user = Auth::user();

        if ($user->name == $name) {
            $peminjamanBuku = PeminjamanBuku::where('id_user', $user->id)
                ->whereIn('status', ['ditahan', 'diterima', 'menunggu'])
                ->get();
        } else {
            return back();
        }

        confirmDelete('Delete', 'Apakah Kamu Yakin?');

        return view('profil.dataPeminjaman', compact('peminjamanBuku', 'user'));
    }


    // ajukan pengembalian buku
    public function ajukanPengembalian($id)
    {
        $peminjamanBuku = PeminjamanBuku::findOrFail($id);

        // Cek apakah ada denda yang belum dibayar (statusPembayaran = 'belum')
        $dendaBelumLunas = $peminjamanBuku->denda()
            ->where('statusPembayaran', 'belum')
            ->exists();

        if ($dendaBelumLunas) {
            Alert::error('Gagal', 'Masih ada denda yang belum dibayar')->autoClose(3000);
            return redirect()->back();
        }

        // Kalau semua aman, lanjut ajukan pengembalian
        $peminjamanBuku->update([
            'status' => 'menunggu'
        ]);

        Alert::success('Success', 'Pengembalian berhasil diajukan')->autoClose(2000);
        return redirect()->back();
    }


    // membatalkan pengembalian
    public function batalPengembalian($id)
    {
        $peminjamanBuku = PeminjamanBuku::findOrFail($id);

        $peminjamanBuku->update([
            'status' => 'diterima'
        ]);

        Alert::success('Success', 'Pengembalian berhasil dibatalkan')->autoClose(2000);
        return redirect()->back();
    }

    // membatalkan peminjaman
    public function batalPeminjaman($id)
    {
        $PeminjamanBuku = PeminjamanBuku::findOrFail($id);
        $PeminjamanBuku->delete();

        Alert::success('Success', 'Peminjaman berhasil dibatalkan')->autoClose(2000);
        return redirect()->back();
    }

    // buku favorit
    public function bukuFavorit($name)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Memastikan bahwa nama pengguna yang sedang login sesuai dengan nama yang diberikan di URL
        if ($user->name == $name) {
            // Mengambil data buku favorit yang dimiliki oleh pengguna
            $favorit = $user->Favorit()->get();
        }

        // Menampilkan view dengan data favorit buku dan pengguna
        return view('profil.bukuFavorit', compact('favorit', 'user'));
    }


    // logika untuk menambah buku favorit
    public function tambahFavorit($judul)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Mencari buku berdasarkan judul
        $buku = Buku::where('judul', $judul)->first();

        if ($buku) {
            // Mengecek apakah buku sudah ada di favorit pengguna
            $existingFavorit = Favorit::where('id_buku', $buku->id)
                ->where('id_user', $user->id)
                ->first();

            if (!$existingFavorit) {
                // Menambahkan buku ke favorit
                Favorit::create([
                    'id_buku' => $buku->id,
                    'id_user' => $user->id,
                ]);

                // Menampilkan pesan sukses menggunakan SweetAlert
                Alert::success('Berhasil', 'Buku berhasil ditambahkan ke favorit')->autoClose(2000);
            } else {
                // Jika buku sudah ada di favorit, tampilkan pesan info
                Alert::info('Informasi', 'Buku sudah ada di favorit')->autoClose(2000);
            }
        }

        // Kembali ke halaman sebelumnya
        return redirect()->back();
    }

    // hapus favorit
    public function hapusFavorit($id)
    {
        $favorit = Favorit::findOrFail($id);
        $favorit->delete();

        Alert::success('Success', 'Buku favorit berhasil dihapus')->autoClose(2000);
        return redirect()->back();
    }

    public function dendaUser($name)
    {
        $user = Auth::user();
        $user = User::where('name', $name)->firstOrFail();
        $dendaUser = Denda::where('statusPembayaran', 'belum')
            ->whereHas('peminjamanBuku', function ($query) use ($user) {
                $query->where('id_user', $user->id);
            })
            ->get();


        return view('profil.dendaUser', compact('dendaUser', 'user'));
    }



}

