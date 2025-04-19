<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">BOOKSAW</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('profil/dashboard') ? 'active' : '' }}">
            <a href="{{ url('profil/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
        </li>

        {{-- profil --}}
        <li class="menu-item {{ request()->is('profil/profil') ? 'active' : '' }}">
            <a href="{{ url('profil/profil') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-user-circle'></i>
                <div data-i18n="Analytics">Profil</div>
            </a>
        </li>

        {{-- daftar buku --}}
        {{-- <li class="menu-item {{ request()->is('profil/daftar-buku') ? 'active' : '' }}">
            <a href="{{ url('profil/daftar-buku') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-book-alt'></i>
                <div data-i18n="Analytics">Daftar buku</div>
            </a>
        </li> --}}

        {{-- buku favorit --}}
        {{-- <li class="menu-item {{ request()->is('profil/buku-favorit/' . $profil->name) ? 'active' : '' }}">
            <a href="{{ url('profil/buku-favorit/' . $profil->name) }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-book-heart'></i>
                <div data-i18n="Analytics">Buku favorit</div>
            </a>
        </li> --}}

        {{-- data peminjaman --}}
        <li class="menu-item {{ request()->is('profil/data-peminjaman/' . $user->name) ? 'active' : '' }}">
            <a href="{{ url('profil/data-peminjaman/' . $user->name) }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-check-circle'></i>
                <div data-i18n="Analytics">Data peminjaman</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('profil/denda/' . $user->name) ? 'active' : '' }}">
            <a href="{{ url('profil/denda/' . $user->name) }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-money'></i>
                <div data-i18n="Analytics">Denda</div>
            </a>
        </li>
    </ul>
</aside>
