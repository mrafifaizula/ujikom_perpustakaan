<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\Kategori;
use App\Models\PeminjamanBuku;
use App\Models\siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = Auth::user();
        $buku = Buku::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        $peminjamanBuku = PeminjamanBuku::all();


        // chart
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

        $favorit = $user->Favorit()->pluck('id')->toArray();


        if ($user->role === 'admin') {
            return view('backend.dashboard', compact('user', 'buku', 'penulis', 'penerbit', 'kategori', 'peminjamanBuku', 'bukuCount', 'penulisCount', 'penerbitCount', 'siswaCount', 'bukuYangDipinjam', 'kategoriCount', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'favorit'));
        } elseif ($user->role === 'staf') {
            return view('backend.dashboard', compact('user', 'buku', 'penulis', 'penerbit', 'kategori', 'peminjamanBuku', 'bukuCount', 'penulisCount', 'penerbitCount', 'siswaCount', 'bukuYangDipinjam', 'kategoriCount', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'favorit'));
        } else {
            return view('frontend.home', compact('user', 'buku', 'penulis', 'penerbit', 'kategori', 'peminjamanBuku', 'bukuCount', 'penulisCount', 'penerbitCount', 'siswaCount', 'bukuYangDipinjam', 'kategoriCount', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'favorit'));
        }
    }
}
