@extends('layouts.frontend')

<style>

</style>

@section('content')
    <section id="daftar-buku" class="bookshelf py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <h2 class="section-title">Daftar Buku Favorit</h2>
                    </div>
                    <div class="tab-content">

                        <div id="all-genre" data-tab-content class="active">
                            <div class="row">
                                @foreach ($favorit as $item)
                                    <div class="col-md-3">
                                        <div class="product-item">
                                            <figure class="product-style">
                                                <div class="book-favorite">
                                                    <i class="bi bi-heart-fill heart-icon" style="color: red"></i>
                                                </div>
                                                <img src="{{ asset('images/buku/' . $item->buku->fotoBuku) }}"
                                                    alt="Books" class="product-item">
                                            </figure>
                                            <figcaption>
                                                <h3>{{ $item->buku->judul }}</h3>
                                                <span class="category">{{ $item->buku->kategori->namaKategori }}</span>
                                                <div class="button-group">
                                                    <a href="{{ url('guest/detail-buku', $item->buku->judul) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Detail buku">
                                                        Detail
                                                    </a>
                                                    <a href="{{ url('guest/pinjam-buku', $item->buku->judul) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Pinjam Buku">
                                                        Pinjam
                                                    </a>
                                                    <a href="{{ route('hapus.favorit', $item->id) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Hapus Favorit"
                                                        data-confirm-delete="true">
                                                        Hapus
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
