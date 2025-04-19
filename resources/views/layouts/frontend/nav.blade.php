<style>
    .dropdown-menu {
        display: none;
    }
</style>

<header id="header">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-2">
                <div class="main-logo">
                    <a href="index.html"><img src="{{ asset('front/assets/images/main-logo.png') }}" alt="logo"></a>
                </div>
            </div>

            <div class="col-md-10">
                <nav id="navbar">
                    <div class="main-menu stellarnav">
                        <ul class="menu-list">
                            <!-- Home Selalu Tampil -->
                            <li class="menu-item {{ request()->is('user/home') ? 'active' : '' }}">
                                <a href="{{ url('user/home') }}">Home</a>
                            </li>

                            <!-- Pages -->
                            <li class="menu-item has-sub">
                                <a href="#pages" class="nav-link">Pages</a>
                                <ul>
                                    <!-- Ini Selalu Tampil -->
                                    <li class="{{ request()->is('user/home') ? 'active' : '' }}">
                                        <a href="{{ url('user/home') }}">Home</a>
                                    </li>
                                    <li class="{{ request()->is('user/daftar-buku') ? 'active' : '' }}">
                                        <a href="{{ url('user/daftar-buku') }}">Daftar Buku</a>
                                    </li>
                                    <li class="{{ request()->is('user/daftar-artikel') ? 'active' : '' }}">
                                        <a href="{{ url('user/daftar-artikel') }}">Daftar Artikel</a>
                                    </li>

                                    <!-- Ini Hanya Untuk yang Sudah Login -->
                                    @auth
                                        <li
                                            class="{{ request()->is('user/buku-favorit/' . Auth::user()->name) ? 'active' : '' }}">
                                            <a href="{{ url('user/buku-favorit/' . Auth::user()->name) }}">Daftar Buku
                                                Favorit</a>
                                        </li>
                                        <li
                                            class="{{ request()->is('profil/data-peminjaman/' . Auth::user()->name) ? 'active' : '' }}">
                                            <a href="{{ url('profil/data-peminjaman/' . Auth::user()->name) }}">Data
                                                Peminjaman</a>
                                        </li>
                                        <li class="{{ request()->is('user/riwayat-peminjaman') ? 'active' : '' }}">
                                            <a href="{{ url('user/riwayat-peminjaman') }}">Riwayat Peminjaman</a>
                                        </li>
                                        <li
                                            class="{{ request()->is('profil/denda/' . Auth::user()->name) ? 'active' : '' }}">
                                            <a href="{{ url('profil/denda/' . Auth::user()->name) }}">Data Denda</a>
                                        </li>
                                    @endauth
                                </ul>
                            </li>

                            <!-- Section Link -->
                            <li class="menu-item"><a href="#sering-dipinjam" class="nav-link">Sering Dipinjam</a></li>
                            <li class="menu-item"><a href="#buku-populer" class="nav-link">Populer</a></li>
                            <li class="menu-item"><a href="#buku-terbaru" class="nav-link">Terbaru</a></li>
                            <li class="menu-item"><a href="#artikel-terbaru" class="nav-link">Artikel</a></li>

                            <li class="dropdown">
                                <a href="#" class="user-account for-buy" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('profil/assets/img/avatars/1.png') }}" class="profile-img">
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @auth
                                        <li class="dropdown-header">
                                            <img src="{{ asset('profil/assets/img/avatars/1.png') }}" class="profile-img">
                                            <div class="user-info">
                                                <span class="username">{{ Auth::user()->name }}</span>
                                                <span class="role">{{ ucfirst(Auth::user()->role) }}</span>
                                            </div>
                                            <span class="status-indicator"></span>
                                        </li>

                                        @if (Auth::user()->role === 'admin')
                                            <li class="menu-item">
                                                <a href="{{ url('admin/dashboard') }}">
                                                    <i class="fa fa-tachometer-alt"></i> Admin
                                                </a>
                                            </li>
                                        @endif

                                        <li class="menu-item">
                                            <a href="{{ url('profil/dashboard') }}">
                                                <i class="fa fa-th"></i> Dashboard
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('profil/profil') }}">
                                                <i class="fa fa-user"></i> Profil
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out-alt"></i> Logout
                                            </a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    @endauth

                                    @guest
                                        <li class="menu-item">
                                            <a href="{{ url('login') }}"><i class="fa fa-sign-in-alt"></i> Login</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('register') }}"><i class="fa fa-user-plus"></i> Register</a>
                                        </li>
                                    @endguest
                                </ul>
                            </li>

                        </ul>

                        <!-- Hamburger Menu (Mobile) -->
                        <div class="hamburger">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </div>
                    </div>
                </nav>
            </div>


        </div>
    </div>
</header>
