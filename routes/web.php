<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanBukuController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'cek.denda.telat', 'role:admin,staf']], function (): void {
    Route::get('dashboard', [BackendController::class, 'index']); // Menggunakan controller untuk 'dashboard'

    Route::resource('kategori', KategoriController::class);
    Route::resource('penulis', PenulisController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('user', UsersController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('artikel', ArtikelController::class);

    // pengajuan
    Route::get('pengajuan', [BackendController::class, 'viewPengajuan']);
    Route::post('pengajuan-peminjaman/{id}/buku', [BackendController::class, 'pengajuanPeminjaman'])->name('pengajuan.peminjaman');
    Route::post('pengajuan-pegembalian/{id}/buku', [BackendController::class, 'pengajuanPengembalian'])->name('pengajuan.pengembalian');

    // daftar buku yang dipinjam
    Route::get('buku-dipinjam', [BackendController::class, 'daftarBukuDipinjam']);

    // history peminjaman
    Route::get('history-peminjaman', [BackendController::class, 'historyPeminjaman']);

    // excel kategori
    Route::get('import/kategori', [KategoriController::class, 'import']);
    Route::post('import/kategori', [KategoriController::class, 'importExcel'])->name('import.kategori');
    Route::get('export/kategori', [KategoriController::class, 'exportCsv'])->name('export.kategori');

    // excel penerbit
    Route::get('import/penerbit', [PenerbitController::class, 'import']);
    Route::post('import/penerbit', [PenerbitController::class, 'importExcel'])->name('import.penerbit');
    Route::get('export/penerbit', [PenerbitController::class, 'exportCsv'])->name('export.penerbit');

    // excel penulis
    Route::get('import/penulis', [PenulisController::class, 'import']);
    Route::post('import/penulis', [PenulisController::class, 'importExcel'])->name('import.penulis');
    Route::get('export/penulis', [PenulisController::class, 'exportCsv'])->name('export.penulis');

    // excel kelas
    Route::get('import/kelas', [KelasController::class, 'import']);
    Route::post('import/kelas', [KelasController::class, 'importExcel'])->name('import.kelas');
    Route::get('export/kelas', [KelasController::class, 'exportCsv'])->name('export.kelas');

    // excel kelas
    Route::get('import/buku', [BukuController::class, 'import']);
    Route::post('import/buku', [BukuController::class, 'importExcel'])->name('import.buku');
    Route::get('export/buku', [BukuController::class, 'exportCsv'])->name('export.buku');

    // excel kelas
    Route::get('import/artikel', [ArtikelController::class, 'import']);
    Route::post('import/artikel', [ArtikelController::class, 'importExcel'])->name('import.artikel');
    Route::get('export/artikel', [ArtikelController::class, 'exportCsv'])->name('export.artikel');

    // data ulasan
    Route::get('data-ulasan', [BackendController::class, 'dataUlasan']);

    // denda
    Route::get('denda', [BackendController::class, 'dataDenda']);

    // pembayaran manual
    Route::post('danda/pembayaran-manual', [BackendController::class, 'pembayaranDendaManual'])->name('pembayaran.manual');

});


Route::group(['prefix' => 'profil', 'middleware' => ['auth', 'cek.denda.telat']], function () {
    Route::get('dashboard', [ProfilController::class, 'dashboard']);
    Route::get('profil', [ProfilController::class, 'profil']);

    // pengembalian buku
    Route::post('ajukan-pengembalian/{id}', [ProfilController::class, 'ajukanPengembalian'])->name('ajukan.pengembalian');
    // membatalkan pengembalian buku
    Route::post('batal-pengembalian/{id}', [ProfilController::class, 'batalPengembalian'])->name('batal.pengembalian');
    // membatalkan peminjaman buku
    Route::delete('batal-peminjaman/{id}', [ProfilController::class, 'batalPeminjaman'])->name('batal.peminjaman');

    // data peminjaman
    Route::get('data-peminjaman/{name}', [ProfilController::class, 'dataPeminjaman'])->name('data.peminjaman');

    // denda
    Route::get('denda/{name}', [ProfilController::class, 'dendaUser']);
});


Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::get('home', [FrontendController::class, 'home']);
    Route::get('daftar-buku', [FrontendController::class, 'daftarBuku']);
    Route::get('detail-buku/{judul}', [FrontendController::class, 'detailBuku']);

    Route::get('daftar-artikel', [FrontendController::class, 'daftarArtikel']);

    // peminjaman buku
    Route::get('pinjam-buku/{judul}', [FrontendController::class, 'showPinjamBuku']);
    Route::post('pinjam-buku/{judul}', [FrontendController::class, 'pinjamBuku'])->name('pinjam.buku');

    // buku favorit
    Route::get('buku-favorit/{name}', [FrontendController::class, 'bukuFavorit'])->name('buku.favorit');
    Route::get('tambah-favorit/{judul}', [FrontendController::class, 'tambahFavorit'])->name('tambah.favorit');
    Route::delete('hapus-favorit/{id}', [FrontendController::class, 'hapusFavorit'])->name('hapus.favorit');

    // riwayat peminjaman
    Route::get('riwayat-peminjaman', [FrontendController::class, 'riwayat'])->name('riwayat.peminjaman');
    Route::get('ulasan/{id}', [FrontendController::class, 'ulasan']);
    Route::post('ulasan', [FrontendController::class, 'inputUlasan'])->name('input.ulasan');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
