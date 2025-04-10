@extends('layouts.backend')

@section('title', 'Pengajuan peminjaman')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Pengajuan peminjaman</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data pengajuan peminjaman</h4>
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
                                            <td>
                                                @if ($item->status == 'ditahan')
                                                    <div class="badge badge-warning">{{ $item->status }}</div>
                                                @elseif ($item->status == 'menunggu')
                                                    <div class="badge badge-info">{{ $item->status }}</div>
                                                @endif
                                            </td>
                                            <td class="text-center">

                                                @if ($item->status == 'ditahan')
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalPeminjaman{{ $item->id }}" title="Lihat">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button>
                                                @elseif ($item->status == 'menunggu')
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalPengembalian{{ $item->id }}"
                                                        title="Lihat">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button>
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

    @foreach ($peminjamanBuku as $item)
        {{-- start modal peminjaman --}}
        <div class="modal fade" id="modalPeminjaman{{ $item->id }}" tabindex="-1"
            aria-labelledby="modalPeminjamanLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPeminjamanLabel-{{ $item->id }}">Detail Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan.peminjaman', $item->id) }}" method="post">
                            @csrf
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Nama</label>
                                            <h6>{{ $item->user->name }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <h6>{{ $item->buku->judul }}</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Jumlah buku</label>
                                            <h6>{{ $item->jumlah }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Kode buku</label>
                                            <h6>{{ $item->buku->code }}</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Tanggal peminjaman</label>
                                            <h6>{{ $item->tanggalPinjam }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Batas pengembalian</label>
                                            <h6>{{ $item->batasPeminjaman }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="pesan{{ $item->id }}">Alasan Penolakan</label>
                                        <textarea id="pesan{{ $item->id }}" name="pesan" class="form-control" rows="3"
                                            placeholder="Masukkan alasan penolakan" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-success" type="submit" name="terima">Terima</button>
                                <button class="btn btn-sm btn-danger tolak-btn" type="submit" name="tolak"
                                    data-id="{{ $item->id }}">Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal peminjama --}}

        {{-- start modal pengembalian --}}
        <div class="modal fade" id="modalPengembalian{{ $item->id }}" tabindex="-1"
            aria-labelledby="modalPengembalianLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPengembalianLabel-{{ $item->id }}">Detail Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pengajuan.pengembalian', $item->id) }}" method="post">
                            @csrf
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Nama11</label>
                                            <h6>{{ $item->user->name }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <h6>{{ $item->buku->judul }}</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Jumlah buku</label>
                                            <h6>{{ $item->jumlah }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Kode buku</label>
                                            <h6>{{ $item->buku->code }}</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Tanggal peminjaman</label>
                                            <h6>{{ $item->tanggalPinjam }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Batas pengembalian</label>
                                            <h6>{{ $item->batasPeminjaman }}</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="pesan{{ $item->id }}">Alasan Penolakan</label>
                                        <textarea id="pesan{{ $item->id }}" name="pesan" class="form-control" rows="3"
                                            placeholder="Masukkan alasan penolakan" style="height: 100px"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-sm btn-success" type="submit" name="terima">Terima</button>
                                <button class="btn btn-sm btn-danger tolak-btn" type="submit" name="tolak"
                                    data-id="{{ $item->id }}">Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End modal pengembalian --}}
    @endforeach
@endsection
