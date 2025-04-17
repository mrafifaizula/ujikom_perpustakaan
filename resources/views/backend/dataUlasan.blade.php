@extends('layouts.backend')

@section('title', 'Data ulasan')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Ulsan Peminjaman</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data ulasan</h4>
                        </div>

                        <div class="card-body">
                            <table id="tablePeminjaman" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left" scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col" class="text-center">Bintang</th>
                                        <th scope="col">Pesan</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                @php $no = 1; @endphp
                                <tbody>
                                    @foreach ($ulasan as $item)
                                        <tr>
                                            <th class="text-left" scope="row">{{ $no++ }}</th>
                                            <td>{{ $item->pengembalianBuku->peminjamanBuku->user->name }}</td>
                                            <td>{{ $item->pengembalianBuku->peminjamanBuku->buku->judul }}</td>
                                            <td class="text-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $item->bintang)
                                                        <i class="fas fa-star" style="color: gold;"></i>
                                                    @else
                                                        <i class="fas fa-star" style="color: lightgray;"></i>
                                                    @endif
                                                @endfor
                                            </td>
                                            <td
                                                style="white-space: normal; word-wrap: break-word; max-width: 300px; text-align: justify;">
                                                {{ $item->pesan }}
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
