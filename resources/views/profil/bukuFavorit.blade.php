@extends('layouts.frontend')

@section('title', 'Buku favorit')

@section('css')
    <link rel="stylesheet" href="{{ asset('profil/assets/css/styleBaru.css') }}">
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            @foreach ($favorit as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="position-relative">
                            <span class="kategori-buku">{{ $item->buku->kategori->namaKategori }}</span>
                            <img class="card-img-top fixed-image" src="{{ asset('images/buku/' . $item->buku->fotoBuku) }}"
                                alt="Card image cap" />
                            <i class="bx bxs-heart heart-icon" style="color: red;"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ $item->buku->judul }}</h5>
                            <div class="mt-auto d-flex justify-content-center gap-2">
                                <a href="{{ url('user/detail-buku', $item->buku->judul) }}" class="btn btn-outline-primary"
                                    data-bs-toggle="tooltip" data-bs-title="Detail buku">Detail</a>
                                <a href="{{ url('user/pinjam-buku', $item->buku->judul) }}"
                                    class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                                    data-bs-title="Pinjam buku">Pinjam</a>
                                <form action="{{ route('hapus.favorit', $item->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"data-bs-toggle="tooltip"
                                        data-bs-title="Hapus favorit">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
