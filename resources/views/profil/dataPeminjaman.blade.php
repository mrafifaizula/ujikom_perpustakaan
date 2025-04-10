@extends('layouts.profil')

@section('title', 'Data Peminjaman Buku')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Buku yang Dipinjam</h4>
                        </div>

                        <div class="card-body">
                            <table id="tableProfil" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">#</th>
                                        <th>Judul</th>
                                        <th style="text-align: left">Jumlah</th>
                                        <th style="text-align: left">Tanggal Pinjam</th>
                                        <th style="text-align: left">Batas Pengembalian</th>
                                        <th style="text-align: center">Status</th>
                                        <th style="text-align: center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($peminjamanBuku as $item)
                                        <tr>
                                            <th style="text-align: left">{{ $no++ }}</th>
                                            <td>{{ $item->buku->judul }}</td>
                                            <td style="text-align: left">{{ $item->jumlah }}</td>
                                            <td style="text-align: left">{{ $item->tanggalPinjam }}</td>
                                            <td style="text-align: left">{{ $item->batasPeminjaman }}</td>
                                            <td style="text-align: center">
                                                <button type="button"
                                                    class="btn btn-sm rounded-pill 
                                                        @if ($item->status == 'diterima') btn-success
                                                        @elseif($item->status == 'ditahan')
                                                            btn-warning
                                                        @elseif($item->status == 'menunggu')
                                                            btn-info
                                                        @else
                                                            btn-secondary @endif
                                                ">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td style="text-align: center">
                                                @if ($item->status == 'diterima')
                                                    <form action="{{ route('ajukan.pengembalian', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm rounded-pill btn-primary"
                                                            onclick="return confirm('Ajukan pengembalian buku ini?')">
                                                            Ajukan
                                                        </button>
                                                    </form>
                                                @elseif ($item->status == 'menunggu')
                                                    <form action="{{ route('batal.pengembalian', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm rounded-pill btn-danger"
                                                            onclick="return confirm('Apakah anda yakin untuk membatalkan pegembalian?')">
                                                            Batal
                                                        </button>
                                                    </form>
                                                @elseif ($item->status == 'ditahan')
                                                    <form action="{{ route('batal.peminjaman', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE') <!-- Menambahkan metode DELETE -->
                                                        <button type="submit" class="btn btn-sm rounded-pill btn-danger">
                                                            Batal
                                                        </button>
                                                    </form>
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
