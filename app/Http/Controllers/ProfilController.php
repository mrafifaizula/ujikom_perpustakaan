<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Kategori;
use App\Models\siswa;
use App\Models\User;
use Auth;
use App\Models\Buku;
use App\Models\Favorit;
use App\Models\PeminjamanBuku;
use App\Models\PengembalianBuku;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Models\Pembayaran;
use Midtrans\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ProfilController extends Controller
{
    // dashboar user
    public function dashboard()
    {
        $user = Auth::user();

        $jumlahBukuDipinjamUser = PeminjamanBuku::where('status', 'diterima')
            ->where('id_user', $user->id)
            ->count();

        $jumlahRiwaytPeminajamUser = PeminjamanBuku::where('status', 'selesai')
            ->where('id_user', $user->id)
            ->count();

        $totalDendaUser = DB::table('dendas')
            ->join('peminjaman_bukus', 'dendas.id_peminjaman', '=', 'peminjaman_bukus.id')
            ->where('peminjaman_bukus.id_user', $user->id)
            ->sum(DB::raw('CAST(totalDenda AS UNSIGNED)'));

        $jumlahMenungguPeminjamanUser = PeminjamanBuku::where('status', ['menunggu', 'ditahan'])
            ->where('id_user', $user->id)
            ->count();

        return view('profil.dashboard', compact('user', 'jumlahBukuDipinjamUser', 'jumlahRiwaytPeminajamUser', 'totalDendaUser', 'jumlahMenungguPeminjamanUser'));
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
        $siswa = Siswa::where('id_user', $user->id)->first();

        return view('profil.profil', compact('user', 'siswa'));
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

    public function historyPembayaranUser($name)
    {
        $user = Auth::user();
        $user = User::where('name', $name)->firstOrFail();
        $historyPembayaranUser = Denda::where('statusPembayaran', 'sudah')
            ->whereHas('peminjamanBuku', function ($query) use ($user) {
                $query->where('id_user', $user->id);
            })
            ->get();

        return view('profil.historyPembayaranUser', compact('historyPembayaranUser', 'user'));
    }

    // Fungsi untuk mendapatkan snap token Midtrans
    public function getSnapToken(Request $request)
    {
        $denda = Denda::with('peminjamanBuku.user')->findOrFail($request->id_denda);

        // Cegah jika total denda 0
        if ((int) $denda->totalDenda <= 0) {
            return response()->json(['message' => 'Total denda tidak valid'], 400);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = 'ORDER-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $denda->totalDenda,
            ],
            'customer_details' => [
                'first_name' => $denda->peminjamanBuku->user->name ?? 'User',
                'email' => $denda->peminjamanBuku->user->email ?? 'dummy@email.com',
            ],
            'custom_field1' => $denda->id,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mendapatkan token'], 500);
        }
    }


    // Fungsi callback untuk Midtrans
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function handleMidtransCallback(Request $request)
    {
        // Ambil data notification dari Midtrans
        $notif = new Notification();
        $order_id = $notif->order_id;  // Ambil order_id dari notifikasi

        // Periksa status pembayaran dari Midtrans
        $status = $notif->transaction_status;
        $payment_type = $notif->payment_type;

        // Proses pembayaran berdasarkan status transaksi
        if ($status == 'capture' && $payment_type == 'credit_card') {
            // Pembayaran berhasil menggunakan kartu kredit
            Pembayaran::create([
                'order_id' => $order_id,
                'totalPembayaran' => $notif->gross_amount,
                'tanggalPembayaran' => now(),
                'metodePembayaran' => 'credit_card',
                'statusPembayaran' => 'sudah',
            ]);
        } elseif ($status == 'settlement') {
            // Pembayaran berhasil
            Pembayaran::create([
                'order_id' => $order_id,
                'totalPembayaran' => $notif->gross_amount,
                'tanggalPembayaran' => now(),
                'metodePembayaran' => $notif->payment_type,
                'statusPembayaran' => 'sudah',
            ]);
        } elseif ($status == 'pending') {
            // Pembayaran masih pending
            Pembayaran::create([
                'order_id' => $order_id,
                'totalPembayaran' => $notif->gross_amount,
                'tanggalPembayaran' => now(),
                'metodePembayaran' => $notif->payment_type,
                'statusPembayaran' => 'belum',
            ]);
        } elseif ($status == 'failed') {
            // Pembayaran gagal
            Pembayaran::create([
                'order_id' => $order_id,
                'totalPembayaran' => $notif->gross_amount,
                'tanggalPembayaran' => now(),
                'metodePembayaran' => $notif->payment_type,
                'statusPembayaran' => 'gagal',
            ]);
        }

        return response()->json(['status' => 'success']);
    }


    // update user
    public function updateProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            Alert::error('Gagal', 'Gagal ' . $error)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $siswa = $user->siswa;

        // Update name jika diisi
        if ($request->filled('name')) {
            $user->name = $request->name;
            $user->save();
        }

        if ($siswa) {
            $siswa->no_hp = $request->no_hp;
            $siswa->alamat = $request->alamat;

            if ($request->hasFile('foto')) {
                $siswa->deleteImage();
                $img = $request->file('foto');
                $name = rand(2000, 9999) . $img->getClientOriginalName();
                $img->move('images/siswa/', $name);
                $siswa->foto = $name;
            }

            $siswa->save();
        }

        Alert::success('Success', 'Profil berhasil diperbarui')->autoClose(2000);
        return redirect()->route('profil.index');
    }



}

