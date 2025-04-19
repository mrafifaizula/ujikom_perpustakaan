<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Ulasan;
use Auth;
use App\Models\Buku;
use App\Models\Favorit;
use App\Models\PeminjamanBuku;
use App\Models\PengembalianBuku;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // home
    public function home()
    {

        $buku = Buku::all();
        $user = Auth::user();
        $bukuPalingBanyakDipinjam = DB::table('peminjaman_bukus')
            ->select('id_buku', DB::raw('count(*) as total'))
            ->where('status', 'selesai')
            ->groupBy('id_buku')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $bukuTerlaris = Buku::whereIn('id', $bukuPalingBanyakDipinjam->pluck('id_buku'))
            ->get()
            ->sortByDesc(function ($item) use ($bukuPalingBanyakDipinjam) {
                $total = $bukuPalingBanyakDipinjam->firstWhere('id_buku', $item->id)->total;
                return $total;
            });

        $bukuPalingBanyakDipinjam2 = DB::table('peminjaman_bukus')
            ->select('id_buku', DB::raw('count(*) as total'))
            ->where('status', 'selesai')
            ->groupBy('id_buku')
            ->orderByDesc('total')
            ->limit(1)
            ->get();

        $bukuPopuler = Buku::whereIn('id', $bukuPalingBanyakDipinjam2->pluck('id_buku'))
            ->get()
            ->sortByDesc(function ($item) use ($bukuPalingBanyakDipinjam2) {
                $total = $bukuPalingBanyakDipinjam2->firstWhere('id_buku', $item->id)->total;
                return $total;
            });

        $bukuTerbaru = Buku::orderBy('created_at', 'desc')->take(3)->get();
        $artikelTerbaru = Artikel::orderBy('created_at', 'desc')->take(3)->get();
        $bukuCoursel = Buku::orderBy('created_at', 'desc')->take(5)->get();

        return view('frontend.home', compact('buku', 'user', 'bukuTerlaris', 'bukuPopuler', 'bukuTerbaru', 'artikelTerbaru', 'bukuCoursel'));
    }

    // daftar buku
    public function daftarBuku()
    {

        $buku = Buku::all();
        $kategori = Kategori::all();
        $user = Auth::user();
        $favorit = Auth::check() ? Auth::user()->Favorit()->pluck('id_buku')->toArray() : [];

        return view('frontend.buku.daftar', compact('buku', 'kategori', 'user', 'favorit'));
    }

    // detail buku
    public function detailBuku($judul)
    {
        $buku = Buku::where('judul', $judul)->firstOrFail();
        $user = Auth::user();

        return view('frontend.buku.detail', compact('buku', 'user'));
    }

    // tampilan peminjaman buku
    public function showPinjamBuku($judul)
    {
        $buku = Buku::where('judul', $judul)->firstOrFail();
        $user = Auth::user();

        return view('frontend.buku.pinjam', compact('buku', 'user'));
    }

    // logika peminjaman buku
    public function pinjamBuku(Request $request, $judul)
    {
        $buku = Buku::where('judul', $judul)->firstOrFail();
        $user = Auth::user();
        $name = Auth::user()->name;

        $existingPeminjaman = PeminjamanBuku::where('id_buku', $buku->id)
            ->where('id_user', $user->id)
            ->whereNotIn('status', ['selesai', 'ditolak'])
            ->exists();



        if ($existingPeminjaman) {
            Alert::error('Error', 'Anda sudah meminjam buku ini!')->autoClose(2000);
            return back();
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'jumlah' => 'required|integer',
            ]);

            PeminjamanBuku::create([
                'tanggalPinjam' => now()->format('Y-m-d'),
                'batasPeminjaman' => now()->addDays(7)->format('Y-m-d'),
                'jumlah' => $request->input('jumlah'),
                'pesan' => $request->filled('pesan') ? $request->input('pesan') : null,
                'status' => 'ditahan',
                'id_buku' => $buku->id,
                'id_user' => auth()->id(),
            ]);

            Alert::success('Success', 'Pengajuan peminjaman buku berhasil dikirim')->autoClose(2000);
            return redirect()->route('data.peminjaman', ['name' => $name])->with('success', 'Peminjaman berhasil diajukan!');
        }

        return response()->json(['message' => 'Error: Invalid request'], 400);
    }

    // daftar buku favorit
    public function bukuFavorit($name)
    {
        $user = Auth::user();

        if ($user->name == $name) {
            $favorit = $user->Favorit()->get();
        }
        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('frontend.buku.favorit', compact('favorit', 'user'));
    }

    // tambah buku favorit
    public function tambahFavorit($judul)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $buku = Buku::where('judul', $judul)->first();

        if ($buku) {
            $existingFavorit = Favorit::where('id_buku', $buku->id)
                ->where('id_user', $user->id)
                ->first();

            if (!$existingFavorit) {
                Favorit::create([
                    'id_buku' => $buku->id,
                    'id_user' => $user->id,
                ]);

                Alert::success('Berhasil', 'Buku berhasil ditambahkan ke favorit')->autoClose(2000);
            } else {
                Alert::info('Informasi', 'Buku sudah ada di favorit')->autoClose(2000);
            }
        }

        return redirect()->back();
    }

    // hapus buku favorit
    public function hapusFavorit($id)
    {
        $favorit = Favorit::findOrFail($id);
        $favorit->delete();

        Alert::success('Success', 'Buku favorit berhasil dihapus')->autoClose(2000);
        return redirect()->back();
    }

    // riwayat
    public function riwayat()
    {
        $peminjamanBuku = PeminjamanBuku::whereIn('status', ['ditolak', 'selesai'])
            ->orderBy('created_at', 'desc')
            ->get();
        $user = Auth::user();

        return view('frontend.buku.riwayat', compact('peminjamanBuku', 'user'));
    }

    // tampilam ulasan
    public function ulasan($id)
    {
        $peminjamanBuku = peminjamanBuku::findOrFail($id);
        $user = Auth::user();

        return view('frontend.ulasan', compact('peminjamanBuku', 'user'));
    }

    // input ulasan
    public function inputUlasan(Request $request)
    {
        $validated = $request->validate([
            'pesan' => 'required|string|max:1000',
            'bintang' => 'required|integer|min:1|max:5',
        ]);

        if ($validated) {
            Ulasan::create([
                'pesan' => $request->input('pesan'),
                'bintang' => $request->input('bintang'),
                'id_pengembalian' => $request->input('id_pengembalian'),
            ]);

            Alert::success('Success', 'Testimoni Berhasil Dikirim')->autoClose(milliseconds: 2000);
            return redirect()->route('riwayat.peminjaman');
        }

        Alert::error('Error', 'Pastikan semua terisi dengan benar')->autoClose(milliseconds: 2000);
        return back()->withInput();
    }


    // daftar arikel
    public function daftarArtikel()
    {
        $artikel = Artikel::all();
        $user = Auth::user();

        return view('frontend.daftarArtikel', compact('artikel', 'user'));
    }


}

