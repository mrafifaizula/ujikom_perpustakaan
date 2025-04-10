@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="{{ asset('front/assets/css/styleBaru.css') }}">
@endsection

<style>

</style>

@section('content')
    <section id="daftar-buku" class="bookshelf py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header align-center">
                        <h2 class="section-title">Daftar Buku</h2>
                    </div>

                    <ul class="tabs">
                        <li data-tab-target="#all-genre" class="active tab">All Genre</li>
                        <li data-tab-target="#business" class="tab">Business</li>
                        <li data-tab-target="#technology" class="tab">Technology</li>
                        <li data-tab-target="#romantic" class="tab">Romantic</li>
                        <li data-tab-target="#adventure" class="tab">Adventure</li>
                        <li data-tab-target="#fictional" class="tab">Fictional</li>
                    </ul>

                    <div class="tab-content">
                        <div id="all-genre" data-tab-content class="active">
                            <div class="row">
                                @foreach ($buku as $item)
                                    <div class="col-md-3">
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
                                                        class="btn btn-sm btn-detail" data-tooltip="Detail buku">
                                                        Detail
                                                    </a>
                                                    <a href="{{ url('user/pinjam-buku', $item->judul) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Pinjam Buku">
                                                        Pinjam
                                                    </a>
                                                    <a href="{{ route('tambah.favorit', $item->judul) }}"
                                                        class="btn btn-sm btn-detail" data-tooltip="Tambah Buku Favorit">
                                                        Favorit
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
