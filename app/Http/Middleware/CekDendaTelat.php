<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;
use App\Models\Denda;
use Carbon\Carbon;

class CekDendaTelat
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $today = Carbon::today();

            // Ambil semua peminjaman yang sudah diterima dan lewat batas peminjaman
            $peminjamans = PeminjamanBuku::where('id_user', auth()->id())
                ->where('status', 'diterima')
                ->whereDate('batasPeminjaman', '<', $today)
                ->get();

            foreach ($peminjamans as $peminjaman) {
                $batas = Carbon::parse($peminjaman->batasPeminjaman);

                if ($today->greaterThan($batas)) {
                    $hariTelat = $batas->diffInDays($today); // hitung berapa hari telat

                    $denda = Denda::where('id_peminjaman', $peminjaman->id)
                        ->where('jenisDenda', 'telat')
                        ->first();

                    if (!$denda) {
                        // Buat denda baru
                        Denda::create([
                            'totalDenda' => $hariTelat * 10000,
                            'statusPembayaran' => 'belum',
                            'jenisDenda' => 'telat',
                            'hariTelat' => $hariTelat,
                            'id_peminjaman' => $peminjaman->id,
                            'id_pengembalian' => null,
                        ]);
                    } else {
                        // Update denda yang sudah ada
                        $denda->update([
                            'hariTelat' => $hariTelat,
                            'totalDenda' => $hariTelat * 10000,
                        ]);
                    }
                }
            }
        }

        return $next($request);
    }
}
