@extends('layouts.frontend')

<style>

</style>

@section('content')
    <section id="daftar-buku" class="bookshelf py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <h2 class="section-title">Riwayat Peminjaman</h2>
                    </div>
                    <div class="tab-content">

                        <div id="all-genre" data-tab-content class="active">
                            <div class="row">
                                @foreach ($peminjamanBuku as $item)
                                    <div class="col-md-3">
                                        <div class="product-item">
                                            <figure class="product-style">
                                                <img src="{{ asset('images/buku/' . $item->buku->fotoBuku) }}"
                                                    alt="Books" class="product-item">
                                                <div class="book-status">
                                                    <span class="status-text">
                                                        {{ $item->status }}
                                                    </span>
                                                </div>
                                            </figure>
                                            <figcaption>
                                                <h3>{{ $item->buku->judul }}</h3>
                                                <span class="category">{{ $item->buku->kategori->namaKategori }}</span>
                                                <div class="button-group">
                                                    @if ($item->status !== 'ditolak')
                                                        <a href="{{ url('user/ulasan', $item->id) }}"
                                                            class="btn btn-sm btn-detail" data-tooltip="Berikan ulasan">
                                                            Ulasan
                                                        </a>
                                                    @endif
                                                    <a href="" class="btn btn-sm btn-detail"
                                                        data-tooltip="Detail peminjaman">
                                                        Detail
                                                    </a>
                                                </div>
                                            </figcaption>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><!--inner-tabs-->
            </div>
        </div>
    </section>
@endsection
