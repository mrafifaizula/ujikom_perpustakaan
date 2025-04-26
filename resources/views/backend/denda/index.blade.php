@extends('layouts.backend')

@section('title', 'History peminjaman')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Denda Peminjaman Buku</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Denda Peminjaman Buku</h4>
                        </div>

                        <div class="card-body">
                            <table id="tablePeminjaman" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Judul</th>
                                        <th class="text-left" scope="col">Batas Peminjaman</th>
                                        <th class="text-left" scope="col">Jenis Denda</th>
                                        <th class="text-left" scope="col">Telat Hari</th>
                                        <th class="text-left" scope="col">Total Denda</th>
                                        <th class="text-left" scope="col">Status</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($denda as $item)
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
                                                @if ($item->statusPembayaran == 'belum')
                                                    <div class="badge badge-danger">{{ $item->statusPembayaran }}</div>
                                                @elseif($item->statusPembayaran == 'sudah')
                                                    <div class="badge badge-success">{{ $item->statusPembayaran }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#modelPengajuan{{ $item->id }}" title="Lihat">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
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
