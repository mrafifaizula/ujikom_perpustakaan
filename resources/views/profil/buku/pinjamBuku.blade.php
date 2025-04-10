@extends('layouts.frontend')

@section('title', 'Peminjaman buku')

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
                                <form id="formAccountSettings" method="POST"
                                    action="{{ route('pinjam.buku', ['judul' => $buku->judul]) }}">
                                    @csrf
                                    <h3 class="card-title text-center mb-7">{{ $buku->judul }}</h3>

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Kategori</label>
                                            <h6>{{ $buku->kategori->namaKategori }}</h6>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Kode buku</label>
                                            <h6>{{ $buku->code }}</h6>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Tanggal pinjam</label>
                                            <h6>{{ now()->format('Y-m-d') }}</h6>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Batas pengembalian</label>
                                            <h6>{{ now()->addDays(7)->format('Y-m-d') }}</h6>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="jumlah" class="form-label">Jumlah</label>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="decreaseValue()">-</button>
                                                <input class="form-control text-center mx-2" type="number" id="jumlah"
                                                    name="jumlah" value="1" min="1" required />
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="increaseValue()">+</button>
                                            </div>
                                        </div>

                                        <script>
                                            function decreaseValue() {
                                                let jumlah = document.getElementById('jumlah');
                                                let value = parseInt(jumlah.value);
                                                if (value > 1) {
                                                    jumlah.value = value - 1;
                                                }
                                            }

                                            function increaseValue() {
                                                let jumlah = document.getElementById('jumlah');
                                                jumlah.value = parseInt(jumlah.value) + 1;
                                            }
                                        </script>

                                    </div>

                                    <div class="mt-2 d-flex justify-content-start gap-2">
                                        <button type="submit" class="btn btn-primary">Pinjam</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
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
