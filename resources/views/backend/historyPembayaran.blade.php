@extends('layouts.backend')

@section('title', 'History Pembayaran')

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
                            <table id="tableDenda" class="table">
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
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#pembayaranDendaManual{{ $item->id }}"
                                                    title="Lihat">
                                                    Bayar
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

@foreach ($denda as $item)
    <div class="modal fade" id="pembayaranDendaManual{{ $item->id }}" tabindex="-1"
        aria-labelledby="pembayaranDendaManualLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pembayaranDendaManualLabel{{ $item->id }}">Pembayaran Manual Denda
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pembayaran.manual') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_denda" value="{{ $item->id }}">

                        <div class="d-flex justify-content-between">
                            <div class="mb-3 me-3" style="width: 50%;">
                                <label class="form-label">Nama</label>
                                <h6>{{ $item->peminjamanBuku->user->name }}</h6>
                            </div>
                            <div class="mb-3" style="width: 50%;">
                                <label class="form-label">Total Denda</label>
                                <h6>Rp {{ number_format($item->totalDenda, 0, ',', '.') }}</h6>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="metodePembayaran" class="form-label">Metode Pembayaran</label>
                            <input type="text" class="form-control" id="metodePembayaran" name="metodePembayaran"
                                placeholder="Contoh: Tunai, Transfer, dll">
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3"></textarea>
                        </div>

                        <div class="mb-2">
                            <button class="btn btn-sm btn-success" type="submit">Simpan</button>
                            <button class="btn btn-sm btn-secondary" type="button"
                                data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
