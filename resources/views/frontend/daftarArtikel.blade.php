@extends('layouts.frontend')

@section('title', 'Daftar Artikel')


@section('css')
    <link rel="stylesheet" href="{{ asset('front/assets/css/styleBaru.css') }}">
@endsection


@section('content')
    <section id="artikel-terbaru" class="py-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header align-center">
                        {{-- <div class="title">
                            <span>Baca artikel kami</span>
                        </div> --}}
                        <h2 class="section-title">Daftar Artikel</h2>
                    </div>
                    <div class="row">
                        @foreach ($artikel as $item)
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

                    {{-- <div class="row">
                        <div class="btn-wrap align-center">
                            <a href="#" class="btn btn-outline-accent btn-accent-arrow" tabindex="0">Read All
                                Articles<i class="icon icon-ns-arrow-right"></i></a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
