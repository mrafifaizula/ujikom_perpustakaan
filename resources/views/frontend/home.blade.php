@extends('layouts.frontend')

@section('content')
    <section id="billboard">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <button class="prev slick-arrow">
                        <i class="icon icon-arrow-left"></i>
                    </button>

                    <div class="main-slider pattern-overlay slick-carousel">
                        @foreach ($bukuCoursel as $item)
                            <div class="slider-item">
                                <div class="banner-content">
                                    <h2 class="banner-title">{{ $item->judul }}</h2>
                                    <p>{{ $item->deskripsi }}</p>
                                    <div class="btn-wrap">
                                        <a href="{{ url('user/detail-buku', $item->judul) }}"
                                            class="btn btn-outline-accent btn-accent-arrow">Lihat Detail<i
                                                class="icon icon-ns-arrow-right"></i></a>
                                    </div>
                                </div>
                                <img src="{{ asset('images/buku/' . $item->fotoBuku) }}" alt="banner" class="banner-image"
                                    style="width: 380px; height: 580px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>

                    <button class="next slick-arrow">
                        <i class="icon icon-arrow-right"></i>
                    </button>

                </div>
            </div>
        </div>
    </section>

    <section id="client-holder" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="inner-content">
                    <div class="logo-wrap">
                        <div class="grid">
                            <a href="#"><img src="{{ asset('front/assets/images/client-image1.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('front/assets/images/client-image2.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('front/assets/images/client-image3.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('front/assets/images/client-image4.png') }}"
                                    alt="client"></a>
                            <a href="#"><img src="{{ asset('front/assets/images/client-image5.png') }}"
                                    alt="client"></a>
                        </div>
                    </div><!--image-holder-->
                </div>
            </div>
        </div>
    </section>

    {{-- start buku unggulan --}}
    <section id="sering-dipinjam" class="py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header align-center">
                        <div class="title">
                            <span>Kumpulan buku berkualitas</span>
                        </div>
                        <h2 class="section-title">Buku Yang Sering Dipinjam</h2>
                    </div>
                    <div class="product-list" data-aos="fade-up">
                        <div class="row">
                            @foreach ($bukuTerlaris as $item)
                                <div class="col-md-3">
                                    <div class="product-item">
                                        <a href="{{ url('user/detail-buku', $item->judul) }}">
                                            <figure class="product-style">
                                                <img src="{{ asset('images/buku/' . $item->fotoBuku) }}" alt="Books"
                                                    class="product-item">
                                            </figure>
                                            <figcaption>
                                                <h3>{{ $item->judul }}</h3>
                                                <span>{{ $item->kategori->namaKategori }}</span>
                                            </figcaption>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- end buku unggulan --}}

            <div class="row">
                <div class="col-md-12">

                    <div class="btn-wrap align-right">
                        <a href="{{ url('user/daftar-buku') }}" class="btn-accent-arrow">Lihat Semua Buku <i
                                class="icon icon-ns-arrow-right"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="buku-populer" class="leaf-pattern-overlay">
        <div class="corner-pattern-overlay"></div>
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="row">
                        @foreach ($bukuPopuler as $item)
                            <div class="col-md-6">
                                <figure class="products-thumb">
                                    <img src="{{ asset('images/buku/' . $item->fotoBuku) }}" alt="book"
                                        class="single-image">
                                </figure>
                            </div>

                            <div class="col-md-6">
                                <div class="product-entry">
                                    <h2 class="section-title divider">Buku Popaler</h2>

                                    <div class="products-content">
                                        <div class="author-name">Ditulis Oleh {{ $item->penulis->namaPenulis }}</div>
                                        <h3 class="item-title">{{ $item->judul }}</h3>
                                        <p>{{ $item->deskripsi }}</p>
                                        <div class="btn-wrap">
                                            <a href="{{ url('user/detail-buku', $item->judul) }}"
                                                class="btn-accent-arrow">Lihat Detail<i
                                                    class="icon icon-ns-arrow-right"></i></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="quotation" class="align-center pb-5 mb-5 mt-5">
        <div class="inner-content">
            <h2 class="section-title divider">Kutipan hari ini</h2>
            <blockquote data-aos="fade-up">
                <q>"Semakin banyak yang Anda baca, semakin banyak hal yang akan Anda ketahui. Semakin banyak yang Anda
                    pelajari, semakin banyak tempat yang akan Anda kunjungi."
                </q>
                <div class="author-name">Dr. Seuss</div>
            </blockquote>
        </div>
    </section>

    <section id="buku-terbaru" class="bookshelf pb-5 mb-5">

        <div class="section-header align-center">
            <div class="title">
                <span>Raih kesempatan Anda</span>
            </div>
            <h2 class="section-title">Buku Terbaru</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="inner-content">
                    <div class="product-list" data-aos="fade-up">
                        <div class="grid product-grid">
                            @foreach ($bukuTerbaru as $item)
                                <div class="product-item">
                                    <figure class="product-style">
                                        <img src="{{ asset('images/buku/' . $item->fotoBuku) }}" alt="Books"
                                            class="product-item">
                                    </figure>
                                    <figcaption>
                                        <h3>{{ $item->judul }}</h3>
                                        <span>{{ $item->kategori->namaKategori }}</span>
                                </div>
                                </figcaption>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="artikel-terbaru" class="py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header align-center">
                        <div class="title">
                            <span>Baca artikel kami</span>
                        </div>
                        <h2 class="section-title">Artikel Terbaru</h2>
                    </div>
                    <div class="row">
                        @foreach ($artikelTerbaru as $item)
                            <div class="col-md-4">
                                <article class="column" data-aos="fade-up">
                                    <figure>
                                        <a href="#" class="image-hvr-effect">
                                            <img src="{{ asset('images/artikel/' . $item->gambar) }}" alt="post"
                                                class="post-image">
                                        </a>
                                    </figure>
                                    <div class="post-item">
                                        <div class="meta-date">{{ $item->created_at->format('M d, Y') }}</div>
                                        <h3><a href="#">{{ $item->judul }}</a></h3>
                                        <div class="links-element">
                                            <div class="categories">Terbaru</div>
                                            {{-- <div class="social-links">
                                                <ul>
                                                    <li>
                                                        <a href="#"><i class="icon icon-facebook"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-twitter"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="icon icon-behance-square"></i></a>
                                                    </li>
                                                </ul>
                                            </div> --}}
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="btn-wrap align-center">
                            <a href="#" class="btn btn-outline-accent btn-accent-arrow" tabindex="0">Read All
                                Articles<i class="icon icon-ns-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
