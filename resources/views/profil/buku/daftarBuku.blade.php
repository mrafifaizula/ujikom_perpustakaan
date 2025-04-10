@extends('layouts.frontend')

@section('title', 'Daftar buku')

@section('css')
    <link rel="stylesheet" href="{{ asset('profil/assets/css/styleBaru.css') }}">
@endsection

<style>

</style>

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            @foreach ($buku as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            <span class="kategori-buku">{{ $item->kategori->namaKategori }}</span>
                            <img class="card-img-top fixed-image" src="{{ asset('images/buku/' . $item->fotoBuku) }}"
                                alt="Card image cap" />
                            <i class="bx {{ in_array($item->id, $favorit) ? 'bxs-heart' : 'bx-heart' }} heart-icon"
                                style="color: {{ in_array($item->id, $favorit) ? 'red' : 'gray' }};"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ $item->judul }}</h5>
                            <div class="mt-auto d-flex justify-content-center gap-2">
                                <a href="{{ url('user/detail-buku', $item->judul) }}" class="btn btn-outline-primary"
                                    data-bs-toggle="tooltip" data-bs-title="Detail buku">Detail</a>
                                <a href="{{ url('user/pinjam-buku', $item->judul) }}" class="btn btn-outline-secondary"
                                    data-bs-toggle="tooltip" data-bs-title="Pinjam buku">Pinjam</a>
                                <a href="{{ route('tambah.favorit', $item->judul) }}" class="btn btn-outline-danger"
                                    data-bs-toggle="tooltip" data-bs-title="Tambah favorit">
                                    Favorit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
