<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Register | BOOKSAW</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('front/assets/images/main-logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('profil/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('profil/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('profil/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('profil/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('profil/assets/vendor/css/pages/page-auth.css') }}" />


    <!-- Helpers -->
    <script src="{{ asset('profil/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('profil/assets/js/config.js') }}"></script>

    <!-- Custom Style -->
    <style>
        .card {
            max-width: 600px;
            margin: 0 auto;
        }

        .card-body {
            padding: 20px;
        }

        .authentication-wrapper {
            padding: 0;
        }

        .authentication-inner {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
        }

        .form-row .col-md-6,
        .form-row .col-md-12 {
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="#" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bolder">BOOKSAW</span>
                            </a>
                        </div>

                        <h4 class="mb-2">Selamat Datang! 🚀</h4>
                        <p class="mb-4">Buat akun Anda untuk memulai petualangan!</p>

                        <form class="mb-3" action="{{ route('register') }}" method="POST">
                            @csrf

                            <!-- Nama & Email -->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama" autofocus />
                                    @error('name')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email" />
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="********" />
                                    @error('password')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="********" />
                                </div>
                            </div>

                            <!-- Nis & No HP -->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="nis" class="form-label">NIS</label>
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror"
                                        id="nis" name="nis" placeholder="Masukkan NIS" />
                                    @error('nis')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                        id="no_hp" name="no_hp" placeholder="Masukkan No HP" />
                                    @error('no_hp')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kelas -->
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="id_kelas" class="form-label">Kelas</label>
                                    <select
                                        class="form-select text-dark bg-white @error('id_kelas') is-invalid @enderror"
                                        id="id_kelas" name="id_kelas" style="border: 1px solid #ced4da;">
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->namaKelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_kelas')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary d-grid w-100">Daftar</button>
                        </form>

                        <p class="text-center mt-2">
                            <span>Sudah punya akun?</span>
                            <a href="{{ route('login') }}">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('profil/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('profil/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('profil/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('profil/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('profil/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('profil/assets/js/main.js') }}"></script>
</body>

</html>
