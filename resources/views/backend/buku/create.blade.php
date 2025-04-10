@extends('layouts.backend')

@section('title', 'Create buku')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Buku</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Create Buku</h4>
                            <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-box-arrow-left"></i> kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="fotoBuku" class="form-label">Foto Buku</label>
                                        <input type="file" name="fotoBuku"
                                            class="form-control @error('fotoBuku') is-invalid @enderror" accept="image/*">
                                        @error('fotoBuku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="judul">Judul</label>
                                            <input type="text" placeholder="Judul"
                                                class="form-control @error('judul') is-invalid @enderror" name="judul">
                                            @error('judul')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="code">Kode Buku</label>
                                            <input type="text" placeholder="Kode Buku"
                                                class="form-control @error('code') is-invalid @enderror" name="code">
                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tahunTerbit">Tahun Terbit</label>
                                            <input type="text" placeholder="Tahun Terbit"
                                                class="form-control @error('tahunTerbit') is-invalid @enderror"
                                                name="tahunTerbit">
                                            @error('tahunTerbit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stok">Stok</label>
                                            <input type="number" placeholder="Stok"
                                                class="form-control @error('stok') is-invalid @enderror" name="stok">
                                            @error('stok')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="id_kategori" class="form-label">Kategori Buku</label>
                                        <select name="id_kategori"
                                            class="form-control @error('id_kategori') is-invalid @enderror">
                                            <option value="" disabled selected>--Pilih Kategori--</option>
                                            @foreach ($kategori as $data)
                                                <option value="{{ $data->id }}">{{ $data->namaKategori }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_kategori')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_penulis" class="form-label">Nama Penulis</label>
                                            <select name="id_penulis"
                                                class="form-control @error('id_penulis') is-invalid @enderror">
                                                <option value="" disabled selected>--Pilih Penulis--</option>
                                                @foreach ($penulis as $data)
                                                    <option value="{{ $data->id }}">{{ $data->namaPenulis }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_penulis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_penerbit" class="form-label">Nama Penerbit</label>
                                            <select name="id_penerbit"
                                                class="form-control @error('id_penerbit') is-invalid @enderror">
                                                <option value="" disabled selected>--Pilih Penerbit--</option>
                                                @foreach ($penerbit as $data)
                                                    <option value="{{ $data->id }}">{{ $data->namaPenerbit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_penerbit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" style="height: 100px"></textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <button class="btn btn-sm btn-success" type="submit">Simpan</button>
                                    <button class="btn btn-sm btn-warning" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
