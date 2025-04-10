@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Siswa</h4>
                        </div>
                        <div class="card-body">{{ $siswaCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far bi bi-book"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Buku Dipinjam</h4>
                        </div>
                        <div class="card-body">{{ $bukuYangDipinjam }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far bi bi-book-half"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Buku</h4>
                        </div>
                        <div class="card-body">{{ $bukuCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas bi bi-stack"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Data Kategori</h4>
                        </div>
                        <div class="card-body">{{ $kategoriCount }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">Laporan Hari Ini</h6>
                        <p class="text-sm text-muted mb-3">{{ $tanggalFormat }}</p>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <i class="bi bi-person-plus-fill text-success mb-1" style="font-size: 20px;"></i>
                                <p class="text-sm text-uppercase font-weight-bold mb-0">Pengguna Baru</p>
                                <h5 class="font-weight-bolder">1</h5>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-book-fill text-primary mb-1" style="font-size: 20px;"></i>
                                <p class="text-sm text-uppercase font-weight-bold mb-0">Peminjaman</p>
                                <h5 class="font-weight-bolder">{{ $jumlahPinjamBukuHariIni }}</h5>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-arrow-repeat text-info mb-1" style="font-size: 20px;"></i>
                                <p class="text-sm text-uppercase font-weight-bold mb-0">Pengembalian</p>
                                <h5 class="font-weight-bolder">{{ $jumlahPengembalianBukuHariIni }}</h5>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-exclamation-triangle-fill text-danger mb-1" style="font-size: 20px;"></i>
                                <p class="text-sm text-uppercase font-weight-bold mb-0">Jatuh Tempo</p>
                                <h5 class="font-weight-bolder">1</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card border-0 shadow-sm p-4 mb-3">
                    <div class="card-body p-3">
                        <h6 class="card-title text-uppercase text-muted mb-1" style="font-size: 14px;">Total Pendapatan
                            Denda</h6>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center">
                                <h4 class="text-dark mb-0" style="font-size: 18px;">Rp0</h4>
                            </div>
                            <div class="rounded-circle bg-success d-flex justify-content-center align-items-center shadow-sm"
                                style="width: 30px; height: 30px; position: relative;">
                                <i class="bi bi-currency-dollar text-white" style="font-size: 16px;"></i>
                            </div>
                        </div>
                        <p class="mb-1 text-muted" style="font-size: 12px;">{{ $tanggalFormat }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card border-0 shadow-sm p-4">
                    <div class="card-body p-3">
                        <h6 class="card-title text-uppercase text-muted mb-1" style="font-size: 14px;">Total Tunggakan
                        </h6>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center">
                                <h4 class="text-dark mb-0" style="font-size: 18px;">Rp 0</h4>
                            </div>
                            <div class="rounded-circle bg-danger d-flex justify-content-center align-items-center shadow-sm"
                                style="width: 30px; height: 30px; position: relative;">
                                <i class="bi bi-currency-dollar text-white" style="font-size: 16px;"></i>
                            </div>
                        </div>
                        <p class="mb-1 text-muted" style="font-size: 12px;">{{ $tanggalFormat }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="chartLine"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div id="chartBar"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        window.chartData = {
            bukuCount: {{ $bukuCount }},
            penulisCount: {{ $penulisCount }},
            penerbitCount: {{ $penerbitCount }},
            kategoriCount: {{ $kategoriCount }},
            peminjamanData: @json($dataGrafik),
            bulanArray: @json($bulanArray),
        };
    </script>
@endpush
