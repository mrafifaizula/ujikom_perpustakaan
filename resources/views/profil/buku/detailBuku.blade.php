@extends('layouts.frontend')

@section('title', 'Detail buku')

@section('css')
    <link rel="stylesheet" href="{{ asset('profil/assets/css/styleBaru.css') }}">
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row d-flex">
                            <!-- Image Column -->
                            <div class="col-md-4 d-flex align-items-stretch">
                                <img src="{{ asset('images/buku/' . $buku->fotoBuku) }}" alt="No Image Available"
                                    class="img-fluid w-100 h-100" style="object-fit: cover;" />
                            </div>

                            <!-- Form Column -->
                            <div class="col-md-8 d-flex align-items-stretch">
                                <form id="formAccountSettings" method="POST" onsubmit="return false"
                                    class="w-100 d-flex flex-column">
                                    <h3 class="card-title text-center mb-7">{{ $buku->judul }}</h3>

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Kategori</label>
                                            <h6>{{ $buku->kategori->namaKategori }}</h6>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Tahun terbit</label>
                                            <h6>{{ $buku->tahunTerbit }}</h6>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Kode buku</label>
                                            <h6>{{ $buku->code }}</h6>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Stok buku</label>
                                            <h6>{{ $buku->stok }}</h6>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Nama penulis</label>
                                            <h6>{{ $buku->penulis->namaPenulis }}</h6>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Nama Penerbit</label>
                                            <h6>{{ $buku->penerbit->namaPenerbit }}</h6>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Deskripsi</label>
                                            <h6 class="deskripsi-text" style="text-align: justify;">{{ $buku->deskripsi }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="mt-2 d-flex justify-content-start gap-2">
                                        <a href="{{ url('user/pinjam-buku', $buku->judul) }}" class="btn btn-primary">
                                            Pinjam
                                        </a>
                                        <a href="{{ url('user/daftar-buku') }}" class="btn btn-outline-secondary">
                                            kembali
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
