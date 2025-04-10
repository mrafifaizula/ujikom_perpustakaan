<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\siswa;
use Auth;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use App\Models\PeminjamanBuku;
use App\Models\PengembalianBuku;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bukuCount = Buku::count();
        $penulisCount = Penulis::count();
        $penerbitCount = Penerbit::count();
        $kategoriCount = Kategori::count();
        $siswaCount = siswa::count();
        $bukuYangDipinjam = PeminjamanBuku::where('status', 'terima')->count();

        $peminjamanPerBulan = PeminjamanBuku::where('status', 'selesai')
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $bulanArray = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $dataGrafik = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataGrafik[] = $peminjamanPerBulan[$i] ?? 0;
        }

        $tanggalSekarang = Carbon::now();
        $namaBulanLengkap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $bulan = $namaBulanLengkap[$tanggalSekarang->month];
        $tanggalFormat = $tanggalSekarang->day . ' ' . $bulan . ' ' . $tanggalSekarang->year;

        $jumlahPinjamBukuHariIni = PeminjamanBuku::whereIn('status', ['diterima', 'menunggu', 'ditolak'])
            ->whereDate('created_at', Carbon::today())
            ->count();

        $jumlahPengembalianBukuHariIni = PeminjamanBuku::where('status', ['selesai'])
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('backend.dashboard', compact('bukuCount', 'penulisCount', 'penerbitCount', 'kategoriCount', 'siswaCount', 'bukuYangDipinjam', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'user'));
    }


    // view pengajuan buku
    public function viewPengajuan()
    {
        $peminjamanBuku = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->get();
        $user = Auth::user();

        return view('backend.pengajuanPeminjaman', compact('peminjamanBuku', 'user'));
    }


    // logika penerimaan peminjaman buku dan penolakan
    public function pengajuanPeminjaman(Request $request, $id)
    {
        $peminjaman = PeminjamanBuku::findOrFail($id);
        $buku = $peminjaman->buku;

        if ($request->has('terima')) {
            $buku->stok -= $peminjaman->jumlah;
            $buku->save();

            $peminjaman->status = 'diterima';
            $peminjaman->pesan = null;

            $peminjaman->save();
            Alert::success('Berhasil', 'Peminjaman diterima')->autoClose(2000);
        } elseif ($request->has('tolak')) {
            if (!$request->filled('pesan')) {
                Alert::error('Gagal', 'Alasan penolakan harus diisi')->autoClose(2000);
                return redirect()->back();
            }

            $peminjaman->status = 'ditolak';
            $peminjaman->pesan = $request->pesan;
            $peminjaman->save();
            Alert::success('Berhasil', 'Peminjaman ditolak')->autoClose(2000);
        }

        return redirect()->back();
    }


    public function daftarBukuDipinjam()
    {
        $peminjamanBuku = PeminjamanBuku::where('status', 'diterima')->get();
        $user = Auth::user();

        return view('backend.daftarBukuDipinjam', compact('peminjamanBuku', 'user'));
    }

    public function historyPeminjaman()
    {
        $peminajamanBuku = PeminjamanBuku::whereIn('status', ['ditolak', 'selesai'])->get();
        $user = Auth::user();

        return view('backend.historyPeminjaman', compact('peminajamanBuku', 'user'));
    }


    // logika penerimaan dan penolakan pegembalian buku
    public function pengajuanPengembalian(Request $request, $id)
    {
        $peminjamanBuku = PeminjamanBuku::findOrFail($id);
        $buku = $peminjamanBuku->buku;

        if ($request->has('terima')) {
            $buku->stok += $peminjamanBuku->jumlah;
            $buku->save();

            $pengembalianBuku = new PengembalianBuku();
            $pengembalianBuku->id_peminjaman = $peminjamanBuku->id;
            $pengembalianBuku->tanggalPengembalian = now();
            $pengembalianBuku->pesan = null;
            $pengembalianBuku->save();

            $peminjamanBuku->status = 'selesai';
            $peminjamanBuku->save();

            Alert::success('Berhasil', 'Pengembalian diterima dan selesai')->autoClose(2000);
        } elseif ($request->has('tolak')) {
            if (!$request->filled('pesan')) {
                Alert::error('Gagal', 'Alasan penolakan harus diisi')->autoClose(2000);
                return redirect()->back();
            }

            $peminjamanBuku->status = 'diterima';
            $peminjamanBuku->pesan = $request->pesan;
            $peminjamanBuku->save();

            Alert::success('Berhasil', 'Pengembalian ditolak')->autoClose(2000);
        }

        return redirect()->back();
    }

    // data ulasan
    public function dataUlsan()
    {
        
    }


}