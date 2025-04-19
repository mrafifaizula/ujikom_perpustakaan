<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\PengembalianBuku;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\Kategori;
use App\Models\PeminjamanBuku;
use App\Models\siswa;
use App\Models\Ulasan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



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
        $totalUlasan = Ulasan::count();
        $totalPeminjaman = PeminjamanBuku::where('status', 'diterima')->count();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();



        // chart
        $bukuCount = Buku::count();
        $penulisCount = Penulis::count();
        $penerbitCount = Penerbit::count();
        $kategoriCount = Kategori::count();
        $siswaCount = siswa::count();
        $totalStaf = User::where('role', 'staf')->count();

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
        $totalDenda = Denda::where('statusPembayaran', 'belum')->sum('totalDenda');
        $totalPendapatan = Denda::where('statusPembayaran', 'sudah')->sum('totalDenda');

        $today = Carbon::today();
        $userBaruHariIni = User::whereDate('created_at', $today)->count();
        $peminjamanHariIni = PeminjamanBuku::whereDate('created_at', $today)
            ->where('status', 'diterima')
            ->count();
        $pengembalianHariIni = PengembalianBuku::whereDate('created_at', $today)
            ->count();
        $jatuhTempo = Denda::where('statusPembayaran', 'belum')->count();


        if ($user->role === 'admin') {
            return view('backend.dashboard', compact('user', 'buku', 'penulis', 'penerbit', 'kategori', 'peminjamanBuku', 'bukuCount', 'penulisCount', 'penerbitCount', 'siswaCount', 'totalStaf', 'kategoriCount', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'favorit', 'totalUlasan', 'totalPeminjaman', 'notifPengajuanSidebar', 'bukuTerlaris', 'bukuPopuler', 'bukuTerbaru', 'artikelTerbaru', 'bukuCoursel', 'totalDenda', 'userBaruHariIni', 'peminjamanHariIni', 'pengembalianHariIni', 'jatuhTempo', 'totalPendapatan'));
        } elseif ($user->role === 'staf') {
            return view('backend.dashboard', compact('user', 'buku', 'penulis', 'penerbit', 'kategori', 'peminjamanBuku', 'bukuCount', 'penulisCount', 'penerbitCount', 'siswaCount', 'totalStaf', 'kategoriCount', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'favorit', 'totalUlasan', 'totalPeminjaman', 'notifPengajuanSidebar', 'bukuTerlaris', 'bukuPopuler', 'bukuTerbaru', 'artikelTerbaru', 'bukuCoursel', 'totalDenda', 'userBaruHariIni', 'peminjamanHariIni', 'pengembalianHariIni', 'jatuhTempo', 'totalPendapatan'));
        } else {
            return view('profil.dashboard', compact('user', 'buku', 'penulis', 'penerbit', 'kategori', 'peminjamanBuku', 'bukuCount', 'penulisCount', 'penerbitCount', 'siswaCount', 'totalStaf', 'kategoriCount', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'favorit', 'totalUlasan', 'totalPeminjaman', 'notifPengajuanSidebar', 'bukuTerlaris', 'bukuPopuler', 'bukuTerbaru', 'artikelTerbaru', 'bukuCoursel', 'totalDenda', 'userBaruHariIni', 'peminjamanHariIni', 'pengembalianHariIni', 'jatuhTempo', 'totalPendapatan'));
        }
    }
}
