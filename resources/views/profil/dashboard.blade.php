@extends('layouts.profil')

@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('profil/assets/css/styleBaru.css') }}">
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <!-- Sambutan -->
            <div class="col-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h4 class="text-primary fw-bold mb-3">Halo, {{ $user->name }}! 👋</h4>
                                <p class="mb-2">Selamat datang di dashboard BOOKSAW. Kamu bisa melihat status
                                    peminjaman, riwayat, dan informasi penting lainnya di sini.</p>
                                <p class="mb-0 text-muted small">Pastikan kamu mengembalikan buku tepat waktu untuk
                                    menghindari denda ya!</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('profil/assets/img/illustrations/man-with-laptop-light.png') }}"
                                alt="Welcome" height="130">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Ringkasan -->
            <div class="col-12 mb-4">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="bx bx-book-bookmark fs-2 text-info mb-2"></i>
                                <h5 class="fw-semibold mb-1">Dipinjam</h5>
                                <span class="text-muted small">{{ $jumlahBukuDipinjamUser }} Buku</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="bx bx-history fs-2 text-success mb-2"></i>
                                <h5 class="fw-semibold mb-1">Riwayat</h5>
                                <span class="text-muted small">{{ $jumlahRiwaytPeminajamUser }} Peminjaman</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="bx bx-error-circle fs-2 text-danger mb-2"></i>
                                <h5 class="fw-semibold mb-1">Denda</h5>
                                <span class="text-muted small">
                                    Rp {{ number_format($totalDendaUser, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                <i class="bx bx-book-add fs-2 text-warning mb-2"></i>
                                <h5 class="fw-semibold mb-1">Menunggu</h5>
                                <span class="text-muted small">{{ $jumlahMenungguPeminjamanUser }} Persetujuan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peraturan -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 d-flex align-items-center">
                        <i class="bx bx-book-bookmark text-primary fs-4 me-2"></i>
                        <h5 class="mb-0 fw-bold">Peraturan Peminjaman Buku</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex align-items-start mb-3">
                                <i class="bx bx-check-circle text-success fs-5 me-3 mt-1"></i>
                                <span class="text-secondary">Kembalikan buku tepat waktu untuk menghindari denda dan menjaga
                                    ketertiban peminjaman.</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bx bx-check-circle text-success fs-5 me-3 mt-1"></i>
                                <span class="text-secondary">Jangan merusak, mencoret, atau melipat halaman buku yang
                                    dipinjam.</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bx bx-check-circle text-success fs-5 me-3 mt-1"></i>
                                <span class="text-secondary">Segera laporkan ke petugas apabila buku hilang atau
                                    rusak.</span>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <i class="bx bx-check-circle text-success fs-5 me-3 mt-1"></i>
                                <span class="text-secondary">Ikuti batas waktu peminjaman sesuai kebijakan
                                    perpustakaan.</span>
                            </li>
                            <li class="d-flex align-items-start">
                                <i class="bx bx-check-circle text-success fs-5 me-3 mt-1"></i>
                                <span class="text-secondary">Bayar denda sesuai ketentuan jika melewati tanggal
                                    pengembalian.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
