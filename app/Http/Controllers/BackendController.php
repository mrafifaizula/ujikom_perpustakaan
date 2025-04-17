<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Favorit;
use App\Models\PembayaranManual;
use App\Models\siswa;
use App\Models\Ulasan;
use App\Models\User;
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
        $totalStaf = User::where('role', 'staf')->count();
        $totalUlasan = Ulasan::count();
        $totalPeminjaman = PeminjamanBuku::where('status', 'diterima')->count();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();
        $totalDenda = Denda::sum('totalDenda');

        $today = Carbon::today();
        $userBaruHariIni = User::whereDate('created_at', $today)->count();
        $peminjamanHariIni = PeminjamanBuku::whereDate('created_at', $today)
            ->where('status', 'diterima')
            ->count();
        $pengembalianHariIni = PengembalianBuku::whereDate('created_at', $today)
            ->count();
        $jatuhTempo = Denda::count();

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

        return view('backend.dashboard', compact('bukuCount', 'penulisCount', 'penerbitCount', 'kategoriCount', 'siswaCount', 'totalStaf', 'dataGrafik', 'bulanArray', 'tanggalFormat', 'user', 'totalUlasan', 'totalPeminjaman', 'notifPengajuanSidebar', 'totalDenda', 'userBaruHariIni', 'peminjamanHariIni', 'pengembalianHariIni', 'jatuhTempo'));
    }


    // view pengajuan buku
    public function viewPengajuan()
    {
        $peminjamanBuku = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->get();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.pengajuanPeminjaman', compact('peminjamanBuku', 'user', 'notifPengajuanSidebar'));
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
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.daftarBukuDipinjam', compact('peminjamanBuku', 'user', 'notifPengajuanSidebar'));
    }

    public function historyPeminjaman()
    {
        $peminajamanBuku = PeminjamanBuku::whereIn('status', ['ditolak', 'selesai'])->get();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.historyPeminjaman', compact('peminajamanBuku', 'user', 'notifPengajuanSidebar'));
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
    public function dataUlasan()
    {
        $ulasan = Ulasan::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.dataUlasan', compact('ulasan', 'user', 'notifPengajuanSidebar'));
    }

    public function dataDenda()
    {
        $denda = Denda::all();
        $user = Auth::user();
        $notifPengajuanSidebar = PeminjamanBuku::whereIn('status', ['ditahan', 'menunggu'])->count();

        return view('backend.denda.index', compact('denda', 'user', 'notifPengajuanSidebar'));
    }

    // pembayaran denda manual
    public function pembayaranDendaManual(Request $request)
    {
        $request->validate([
            'id_denda' => 'required|exists:dendas,id',
            'metodePembayaran' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        // Simpan ke tabel pembayaran manual
        PembayaranManual::create([
            'id_denda' => $request->id_denda,
            'tanggalPembayaran' => now(),
            'metodePembayaran' => $request->metodePembayaran,
            'catatan' => $request->catatan,
        ]);

        // Update status pembayaran di tabel denda (opsional)
        $denda = Denda::findOrFail($request->id_denda);
        $denda->statusPembayaran = 'sudah';
        $denda->save();

        Alert::success('Berhasil', 'Pembabayran Berhasil')->autoClose(2000);
        return redirect()->back();
    }

}