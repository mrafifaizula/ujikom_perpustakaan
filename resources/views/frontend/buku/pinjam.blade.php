@extends('layouts.frontend')

<style>
   
</style>

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row d-flex">
                            <!-- Kolom Gambar -->
                            <div class="col-md-4 d-flex card-img-container">
                                <img src="{{ asset('images/buku/' . $buku->fotoBuku) }}" alt="No Image Available"
                                    class="img-fluid" />
                            </div>

                            <!-- Kolom Informasi Buku -->
                            <div class="col-md-8">
                                <form id="formAccountSettings" method="POST"
                                    action="{{ route('pinjam.buku', ['judul' => $buku->judul]) }}">
                                    @csrf
                                    <h3 class="card-title text-center mb-4">{{ $buku->judul }}</h3>

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
                                            <div class="quantity-container">
                                                <span onclick="decreaseValue()" class="quantity-btn">-</span>
                                                <input type="number" id="jumlah" name="jumlah" value="1"
                                                    min="1" required class="quantity-input" />
                                                <span onclick="increaseValue()" class="quantity-btn">+</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2 d-flex justify-content-start gap-2">
                                        <a href="#" class="btn btn-outline-secondary"
                                            onclick="document.getElementById('formAccountSettings').submit(); return false;">Pinjam</a>
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

<script>
   
</script>
