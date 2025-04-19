<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
    <link rel="icon" type="image/x-icon" href="{{ asset('front/assets/images/main-logo.png') }}" />
    <title>Perpustakaan - @yield('title', 'Perpustakaan SMK Assalaam')</title>


    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- charts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styleBaru.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}" />
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js')}}", new Date());

        gtag("config", "UA-94034622-3");
    </script>
    <!-- /END GA -->
</head>

<body style="overflow-x: hidden">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            {{-- start navbar --}}
            @include('layouts.backend.nav')
            {{-- end navbar --}}

            <div class="main-sidebar sidebar-style-2">
                {{-- start sidebar --}}
                @include('layouts.backend.sidebar')
                {{-- end sidebar --}}
            </div>

            <!-- Main Content -->
            <div class="main-content">
                {{-- start content --}}
                @yield('content')
                {{-- end content --}}
            </div>

            {{-- start footer --}}
            @include('layouts.backend.footer')
            {{-- end footer --}}

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/scriptsBaru.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    {{-- alert --}}
    @include('sweetalert::alert')

    @stack('scripts')
</body>

</html>
