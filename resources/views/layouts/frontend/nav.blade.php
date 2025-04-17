<style>

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
                            <li class="menu-item {{ request()->is('user/home') ? 'active' : '' }}"><a
                                    href="{{ url('user/home') }}">Home</a></li>
                            <li class="menu-item has-sub">
                                <a href="#pages" class="nav-link">Pages</a>

                                <ul>
                                    <li class="{{ request()->is('user/home') ? 'active' : '' }}"><a
                                            href="{{ url('user/home') }}">Home</a></li>
                                    <li class="{{ request()->is('user/daftar-buku') ? 'active' : '' }}"><a
                                            href="{{ url('user/daftar-buku') }}">Daftar Buku</a></li>
                                    <li class="{{ request()->is('user/buku-favorit/' . $user->name) ? 'active' : '' }}">
                                        <a href="{{ url('user/buku-favorit/' . $user->name) }}">Daftar Buku favorit</a>
                                    </li>
                                    <li
                                        class="{{ request()->is('profil/data-peminjaman/' . $user->name) ? 'active' : '' }}">
                                        <a href="{{ url('profil/data-peminjaman/' . $user->name) }}">Data
                                            Peminjaman</a>
                                    </li>
                                    <li class="{{ request()->is('user/riwayat-peminjaman') ? 'active' : '' }}">
                                        <a href="{{ url('user/riwayat-peminjaman') }}">Riwayat Peminjaman</a>
                                    </li>
                                    <li class="{{ request()->is('user/daftar-artikel') ? 'active' : '' }}">
                                        <a href="{{ url('user/daftar-artikel') }}">Daftar Artikel</a>
                                    </li>
                                    <li
                                        class="{{ request()->is('profil/data-peminjaman/' . $user->name) ? 'active' : '' }}">
                                        <a href="{{ url('profil/data-peminjaman/' . $user->name) }}">Data
                                            Peminjaman</a>
                                    </li>
                                    <li class="{{ request()->is('profil/denda/' . $user->name) ? 'active' : '' }}">
                                        <a href="{{ url('profil/denda/' . $user->name) }}">Data Denda</a>
                                    </li>
                                </ul>

                            </li>
                            <li class="menu-item"><a href="#sering-dipinjam" class="nav-link">Sering Dipinjam</a></li>
                            <li class="menu-item"><a href="#buku-populer" class="nav-link">Populer</a></li>
                            <li class="menu-item"><a href="#buku-terbaru" class="nav-link">Terbaru</a></li>
                            <li class="menu-item"><a href="#artikel-terbaru" class="nav-link">Artikel</a></li>
                            @guest
                                <li class="scroll-to-section"><a href="{{ url('login') }}">Login</a></li>
                                <li class="scroll-to-section"><a href="{{ url('register') }}">Register</a></li>
                            @endguest

                            @auth
                                <li class="dropdown">
                                    <a href="#" class="user-account for-buy" id="dropdownMenuButton">
                                        <img src="{{ asset('profil\assets/img/avatars/1.png') }}" class="profile-img">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li class="dropdown-header">
                                            <img src="{{ asset('profil\assets/img/avatars/1.png') }}" class="profile-img">
                                            <div class="user-info">
                                                <span class="username">John Doe</span>
                                                <span class="role">Admin</span>
                                            </div>
                                            <span class="status-indicator"></span>
                                        </li>
                                        <li class="menu-item">
                                            @if (Auth::user() && Auth::user()->role == 'admin')
                                                <a href="{{ url('admin/dashboard') }}"><i
                                                        class="fa fa-tachometer-alt"></i>Admin</a>
                                            @endif
                                        </li>
                                        <li class="menu-item"><a href="{{ url('profil/dashboard') }}"><i
                                                    class="fa fa-th"></i>
                                                Dahsboard</a></li>
                                        <li class="menu-item"><a href="{{ url('profil/profil') }}"><i
                                                    class="fa fa-user"></i>
                                                Profil</a></li>
                                        <li class="menu-item"><a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                    class="fa fa-sign-out-alt"></i> Log Out</a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </ul>
                                </li>
                            @endauth
                        </ul>


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
