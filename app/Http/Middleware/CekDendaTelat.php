<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;
use App\Models\Denda;
use App\Models\PembayaranManual;
use Carbon\Carbon;

class CekDendaTelat
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $today = Carbon::now('Asia/Jakarta')->startOfDay();
        $userId = auth()->id();
        $hargaPerHari = 10000;

        $peminjamans = PeminjamanBuku::where('id_user', $userId)
            ->where('status', 'diterima')
            ->whereDate('batasPeminjaman', '<', $today)
            ->get();

        foreach ($peminjamans as $peminjaman) {
            $batas = Carbon::parse($peminjaman->batasPeminjaman)->startOfDay();
            $jumlahBuku = $peminjaman->jumlah ?? 1;

            if ($today->lte($batas)) {
                continue;
            }

            // 1. Cek denda belum dibayar
            $dendaBelumBayar = Denda::where('id_peminjaman', $peminjaman->id)
                ->where('jenisDenda', 'telat')
                ->where('statusPembayaran', 'belum')
                ->latest()
                ->first();

            if ($dendaBelumBayar) {
                // Cek apakah denda ini dibuat karena sudah pernah bayar sebelumnya
                $dendaSebelumnya = Denda::where('id_peminjaman', $peminjaman->id)
                    ->where('jenisDenda', 'telat')
                    ->where('statusPembayaran', 'sudah')
                    ->latest()
                    ->first();

                if ($dendaSebelumnya) {
                    $pembayaran = PembayaranManual::where('id_denda', $dendaSebelumnya->id)
                        ->latest('tanggalPembayaran')
                        ->first();

                    if ($pembayaran) {
                        $tanggalBayar = Carbon::parse($pembayaran->tanggalPembayaran)->timezone('Asia/Jakarta')->startOfDay();
                        $hariTelat = $tanggalBayar->diffInDays($today);
                        $totalDenda = $hariTelat * $hargaPerHari * $jumlahBuku;

                        $dendaBelumBayar->update([
                            'hariTelat' => $hariTelat,
                            'totalDenda' => $totalDenda,
                        ]);

                        continue;
                    }
                }

                // Jika tidak ada riwayat bayar sebelumnya, berarti ini denda pertama → hitung dari batas
                $hariTelat = $batas->diffInDays($today);
                $totalDenda = $hariTelat * $hargaPerHari * $jumlahBuku;

                $dendaBelumBayar->update([
                    'hariTelat' => $hariTelat,
                    'totalDenda' => $totalDenda,
                ]);
                continue;
            }

            // 2. Jika semua denda sudah dibayar → buat denda baru dari tanggal bayar terakhir
            $dendaTerakhirDibayar = Denda::where('id_peminjaman', $peminjaman->id)
                ->where('jenisDenda', 'telat')
                ->where('statusPembayaran', 'sudah')
                ->latest()
                ->first();

            if ($dendaTerakhirDibayar) {
                $pembayaran = PembayaranManual::where('id_denda', $dendaTerakhirDibayar->id)
                    ->latest('tanggalPembayaran')
                    ->first();

                if ($pembayaran) {
                    $tanggalBayar = Carbon::parse($pembayaran->tanggalPembayaran)->timezone('Asia/Jakarta')->startOfDay();
                    $hariTelatBaru = $tanggalBayar->diffInDays($today);

                    if ($hariTelatBaru > 0) {
                        $totalDendaBaru = $hariTelatBaru * $hargaPerHari * $jumlahBuku;

                        Denda::create([
                            'id_peminjaman' => $peminjaman->id,
                            'jenisDenda' => 'telat',
                            'hariTelat' => $hariTelatBaru,
                            'totalDenda' => $totalDendaBaru,
                            'statusPembayaran' => 'belum',
                            'id_pengembalian' => null,
                        ]);
                    }
                }
            } else {
                // 3. Tidak ada denda sama sekali → buat denda dari batas peminjaman
                $hariTelat = $batas->diffInDays($today);
                $totalDenda = $hariTelat * $hargaPerHari * $jumlahBuku;

                Denda::create([
                    'id_peminjaman' => $peminjaman->id,
                    'jenisDenda' => 'telat',
                    'hariTelat' => $hariTelat,
                    'totalDenda' => $totalDenda,
                    'statusPembayaran' => 'belum',
                    'id_pengembalian' => null,
                ]);
            }
        }

        return $next($request);
    }
}
