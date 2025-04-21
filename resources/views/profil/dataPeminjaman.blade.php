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
                                        <th class="text-left align-middle">#</th>
                                        <th class="align-middle">Judul</th>
                                        <th class="text-left align-middle">Jumlah</th>
                                        <th class="text-left align-middle">Tanggal Pinjam</th>
                                        <th class="text-left align-middle">Batas Pengembalian</th>
                                        <th class="text-center align-middle">Status</th>
                                        <th class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($peminjamanBuku as $item)
                                        <tr>
                                            <th class="text-left align-middle">{{ $no++ }}</th>
                                            <td class="align-middle">{{ $item->buku->judul }}</td>
                                            <td class="text-left align-middle">{{ $item->jumlah }}</td>
                                            <td class="text-left align-middle">{{ $item->tanggalPinjam }}</td>
                                            <td class="text-left align-middle">{{ $item->batasPeminjaman }}</td>
                                            <td class="text-center align-middle">
                                                <button type="button"
                                                    class="btn btn-sm rounded-pill
                                                        @if ($item->status == 'diterima') btn-success
                                                        @elseif($item->status == 'ditahan') btn-warning
                                                        @elseif($item->status == 'menunggu') btn-info
                                                        @else btn-secondary @endif">
                                                    {{ $item->status }}
                                                </button>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center gap-1">
                                                    @if ($item->status == 'diterima')
                                                        <form id="form-pengembalian-{{ $item->id }}"
                                                            action="{{ route('ajukan.pengembalian', $item->id) }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <button type="button"
                                                                class="btn btn-sm rounded-pill btn-primary"
                                                                onclick="konfirmasiPengembalian({{ $item->id }})">
                                                                Ajukan
                                                            </button>
                                                        </form>
                                                    @elseif ($item->status == 'menunggu')
                                                        <form id="form-batal-pengembalian-{{ $item->id }}"
                                                            action="{{ route('batal.pengembalian', $item->id) }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            <button type="button"
                                                                class="btn btn-sm rounded-pill btn-danger"
                                                                onclick="konfirmasiPembatalan({{ $item->id }})">
                                                                Batal
                                                            </button>
                                                        </form>
                                                    @elseif ($item->status == 'ditahan')
                                                        <form id="form-batal-peminjaman-{{ $item->id }}"
                                                            action="{{ route('batal.peminjaman', $item->id) }}"
                                                            method="POST" style="margin: 0;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm rounded-pill btn-danger"
                                                                onclick="konfirmasiPembatalanPeminjaman({{ $item->id }})">
                                                                Batal
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
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

<!-- SweetAlert -->
<script>
   
</script>
