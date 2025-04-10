@extends('layouts.frontend')

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-dark fw-bold mb-4">Formulir Testimoni</h2>

                <form action="{{ route('input.ulasan') }}" method="POST" id="formAccountSettings">
                    @csrf
                    <input type="hidden" name="id_pengembalian" value="{{ $peminjamanBuku->pengembalianBuku->first()->id }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nama</label>
                            <h4>{{ $peminjamanBuku->user->name }}</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Judul Buku</label>
                            <h4>{{ $peminjamanBuku->buku->judul }}</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Email</label>
                            <h4>{{ $peminjamanBuku->user->email }}</h4>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nomor Handphone</label>
                            <h4>...</h4>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="fw-bold">Testimoni Anda *</label>
                            <textarea class="form-control" rows="4" name="pesan" placeholder="Ketik di sini..." required></textarea>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="fw-bold">Penilaian layanan kami *</label>
                            <div class="star-rating">
                                <input type="hidden" name="bintang" id="rating-value" value="0">
                                <i class="bi bi-star-fill" data-value="1"></i>
                                <i class="bi bi-star-fill" data-value="2"></i>
                                <i class="bi bi-star-fill" data-value="3"></i>
                                <i class="bi bi-star-fill" data-value="4"></i>
                                <i class="bi bi-star-fill" data-value="5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 d-flex justify-content-end gap-2">
                        <a href="javascript:void(0)" class="btn btn-outline-secondary" id="submitButton">Kirim</a>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
