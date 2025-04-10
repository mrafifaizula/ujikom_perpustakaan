@extends('layouts.backend')

@section('title', 'Data buku yang dipinjam')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Buku yang dipinjam</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data buku dipinjam</h4>
                        </div>

                        <div class="card-body">
                            <table id="tablePeminjaman" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Judul</th>
                                        <th class="text-left" scope="col">Tanggal pinjam</th>
                                        <th class="text-left" scope="col">Batas pengembalian</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($peminjamanBuku as $item)
                                        <tr>
                                            <th class="text-left" scope="row">{{ $no++ }}</th>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->buku->judul }}</td>
                                            <td class="text-left">{{ $item->tanggalPinjam }}</td>
                                            <td class="text-left">{{ $item->batasPeminjaman }}</td>
                                            <td class="text-center">
                                                <div class="badge badge-success">{{ $item->status }}</div>
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
