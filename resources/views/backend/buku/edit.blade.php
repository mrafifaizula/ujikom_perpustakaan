@extends('layouts.backend')

@section('title', 'Edit buku')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Buku</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Edit Buku</h4>
                            <a href="{{ route('buku.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-box-arrow-left"></i> kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('buku.update', $buku->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        @if ($buku->fotoBuku)
                                            <img src="{{ asset('images/buku/' . $buku->fotoBuku) }}" alt="Foto Buku"
                                                class="img-thumbnail mb-3"
                                                style="width: 150px; height: 190px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder"
                                                class="img-thumbnail mb-3"
                                                style="width: 150px; height: 190px; object-fit: cover;">
                                        @endif
                                        <input type="file" name="fotoBuku" accept="image/*"
                                            class="form-control @error('fotoBuku') is-invalid @enderror">
                                        @error('fotoBuku')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul Buku</label>
                                            <input type="text" name="judul"
                                                class="form-control @error('judul') is-invalid @enderror"
                                                value="{{ old('judul', $buku->judul) }}">
                                            @error('judul')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="code" class="form-label">Kode Buku</label>
                                            <input type="text" name="code"
                                                class="form-control @error('code') is-invalid @enderror"
                                                value="{{ old('code', $buku->code) }}">
                                            @error('code')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="stok" class="form-label">Stok</label>
                                            <input type="text" name="stok"
                                                class="form-control @error('stok') is-invalid @enderror"
                                                value="{{ old('stok', $buku->stok) }}">
                                            @error('stok')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_kategori" class="form-label">Kategori</label>
                                            <select name="id_kategori"
                                                class="form-control @error('id_kategori') is-invalid @enderror">
                                                <option value="" disabled selected>--Pilih Kategori--</option>
                                                @foreach ($kategori as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ old('id_kategori', $buku->id_kategori) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->namaKategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_kategori')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tahunTerbit" class="form-label">Tahun Terbit</label>
                                            <input type="text" name="tahunTerbit"
                                                class="form-control @error('tahunTerbit') is-invalid @enderror"
                                                value="{{ old('tahunTerbit', $buku->tahunTerbit) }}">
                                            @error('tahunTerbit')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_penulis" class="form-label">Penulis</label>
                                            <select name="id_penulis"
                                                class="form-control @error('id_penulis') is-invalid @enderror">
                                                <option value="" disabled selected>--Pilih Penulis--</option>
                                                @foreach ($penulis as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ old('id_penulis', $buku->id_penulis) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->namaPenulis }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_penulis')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="id_penerbit" class="form-label">Penerbit</label>
                                            <select name="id_penerbit"
                                                class="form-control @error('id_penerbit') is-invalid @enderror">
                                                <option value="" disabled selected>--Pilih Penerbit--</option>
                                                @foreach ($penerbit as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ old('id_penerbit', $buku->id_penerbit) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->namaPenerbit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_penerbit')
                                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" style="height: 100px">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
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
