@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('front/assets/css/styleBaru.css') }}">
@endsection


@section('content')
    <section id="daftar-buku" class="bookshelf py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <h2 class="section-title">Daftar Buku</h2>
                    </div>

                    <div class="filter-bar">
                        <!-- Input Cari Buku -->
                        <div class="search-wrapper">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari judul buku..."
                                onkeyup="filterByTitle()">
                            <i class="bi bi-search search-icon"></i>
                        </div>

                        <!-- Dropdown Kategori -->
                        <select id="genreDropdown" onchange="handleTabChange(this)">
                            <option value="#semua-kategori" selected>Semua Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="#{{ $item->namaKategori }}">{{ $item->namaKategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tab-content">
                        <div id="semua-kategori" data-tab-content class="active">
                            <div class="row">
                                @foreach ($buku as $item)
                                    <div class="col-md-3" data-kategor="{{ $item->kategori->namaKategori }}">
                                        <div class="product-item">
                                            <figure class="product-style">
                                                <div class="book-favorite">
                                                    <i class="bi {{ in_array($item->id, $favorit) ? 'bi-heart-fill' : 'bi-heart' }} heart-icon"
                                                        style="color: {{ in_array($item->id, $favorit) ? 'red' : 'gray' }};"></i>
                                                </div>
                                                <img src="{{ asset('images/buku/' . $item->fotoBuku) }}" alt="Books"
                                                    class="product-item">
                                            </figure>
                                            <figcaption>
                                                <h3>{{ $item->judul }}</h3>
                                                <div class="button-group">
                                                    <a href="{{ url('user/detail-buku', $item->judul) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Detail buku">Detail</a>
                                                    <a href="{{ url('user/pinjam-buku', $item->judul) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Pinjam Buku">Pinjam</a>
                                                    <a href="{{ route('tambah.favorit', $item->judul) }}"
                                                        class="btn btn-sm btn-detail"
                                                        data-tooltip="Tambah Buku Favorit">Favorit</a>
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