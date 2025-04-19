<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Login - BOOKSAW</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('front/assets/images/main-logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('profil/assets/vendor/fonts/boxicons.css') }}" />

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

    <script src="{{ asset('profil/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('profil/assets/js/config.js') }}"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bolder">BOOKSAW</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-2">Selamat Datang Kembali! 👋</h4>
                        <p class="mb-4">Silakan masuk ke akun Anda dan mulai petualangan</p>

                        <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email"
                                    value="{{ old('email') }}" autofocus />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            <small>Forgot Password?</small>
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Belum punya akun?</span>
                            <a href="{{ route('register') }}">
                                <span>Daftar di sini</span>
                            </a>
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
