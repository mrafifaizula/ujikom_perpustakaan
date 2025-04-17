@extends('layouts.profil')

@section('title', 'Data Denda')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Denda</h4>
                        </div>

                        <div class="card-body">
                            <table id="tableDenda" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">#</th>
                                        <th>Nama Peminjam</th>
                                        <th>Judul Buku</th>
                                        <th>Batas Peminjaman</th>
                                        <th>Jenis Denda</th>
                                        <th>Telat Hari</th>
                                        <th>Total Denda</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($dendaUser as $item)
                                        <tr>
                                            <th class="text-left" scope="row">{{ $no++ }}</th>
                                            <td>{{ $item->peminjamanBuku->user->name }}</td>
                                            <td>{{ $item->peminjamanBuku->buku->judul }}</td>
                                            <td class="text-left">{{ $item->peminjamanBuku->batasPeminjaman }}</td>
                                            <td class="text-left">{{ $item->jenisDenda }}</td>
                                            <td class="text-left">{{ $item->hariTelat }} Hari</td>
                                            <td class="text-left">Rp {{ number_format($item->totalDenda, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm rounded-pill 
                                                        @if ($item->statusPembayaran == 'sudah') btn-success
                                                        @elseif ($item->statusPembayaran == 'belum') btn-danger
                                                        @elseif ($item->statusPembayaran == 'menunggu') btn-info
                                                        @else btn-secondary @endif">
                                                    {{ ucfirst($item->statusPembayaran) }}
                                                </button>
                                            </td>

                                            <td>
                                                {{-- Contoh aksi, bisa diganti sesuai kebutuhan --}}
                                                @if ($item->statusPembayaran == 'belum')
                                                    <a href="" class="btn btn-sm btn-primary">Bayar</a>
                                                @else
                                                    <span class="text-muted">Tidak ada aksi</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
