@extends('layouts.backend')

@section('title', 'Detail buku')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Buku</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Detail Buku</h4>
                            <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-box-arrow-left"></i> kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('images/buku/' . $buku->fotoBuku) }}" alt="Foto Buku"
                                        class="img-thumbnail mb-3"
                                        style="width: 180px; height: 210px; object-fit: cover; margin-top:20px;">
                                </div>

                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul Buku</label>
                                        <input type="text" name="judul" class="form-control"
                                            value="{{ $buku->judul }}" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="code" class="form-label">Kode Buku</label>
                                        <input type="text" name="code" class="form-control"
                                            value="{{ $buku->code }}" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="text" name="stok" class="form-control"
                                            value="{{ $buku->stok }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaKategori" class="form-label">Kategori</label>
                                        <input type="text" name="stok" class="form-control"
                                            value="{{ $buku->kategori->namaKategori }}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tahunTerbit" class="form-label">Tahun Terbit</label>
                                        <input type="text" name="tahunTerbit" class="form-control"
                                            value="{{ $buku->tahunTerbit }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaPenulis" class="form-label">Penulis</label>
                                        <input type="text" name="namaPenulis" class="form-control"
                                            value="{{ $buku->penulis->namaPenulis }}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="namaPenerbit" class="form-label">Penerbit</label>
                                        <input type="text" name="namaPenerbit" class="form-control"
                                            value="{{ $buku->penerbit->namaPenerbit }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="4" readonly>{{ $buku->deskripsi }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
