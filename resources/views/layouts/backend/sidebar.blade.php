<style>

</style>

<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">BOOKSAW</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">Ps</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ url('admin/dashboard') }}" class="nav-link"><i class="bi bi-fire"></i><span>Dashboard</span></a>
        </li>
        <li class="menu-header">Tables</li>
        <li class="nav-item {{ request()->is('admin/denda') ? 'active' : '' }}">
            <a href="{{ url('admin/denda') }}" class="nav-link"><i class="bi bi-cash"></i><span>Denda</span></a>
        </li>
        <li class="nav-item {{ request()->is('admin/history-pembayaran') ? 'active' : '' }}">
            <a href="{{ url('admin/history-pembayaran') }}" class="nav-link"><i
                    class="bi bi-credit-card"></i><span>History
                    Pembayaran</span></a>
        </li>
        <li class="dropdown {{ request()->is('admin/user', 'admin/siswa') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-people-fill"></i>
                <span>Akun</span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('admin/user') }}" class="nav-link">Staff</a></li>
                <li><a href="{{ url('admin/siswa') }}" class="nav-link">Siswa</a></li>
            </ul>
        </li>
        <li
            class="dropdown {{ request()->is('admin/kategori', 'admin/penulis', 'admin/penerbit', 'admin/buku', 'admin/kelas', 'admin/artikel') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="bi bi-table"></i>
                <span>Tables</span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('admin/kelas') }}" class="nav-link">Kelas</a></li>
                <li><a href="{{ url('admin/kategori') }}" class="nav-link">Kategori</a></li>
                <li><a href="{{ url('admin/penulis') }}" class="nav-link">Penulis</a></li>
                <li><a href="{{ url('admin/penerbit') }}" class="nav-link">Penerbit</a></li>
                <li><a href="{{ url('admin/buku') }}" class="nav-link">Buku</a></li>
                <li><a href="{{ url('admin/artikel') }}" class="nav-link">Artikel</a></li>
            </ul>
        </li>
        <li class="nav-item {{ request()->is('admin/pengajuan') ? 'active' : '' }}">
            <a href="{{ url('admin/pengajuan') }}" class="nav-link position-relative">
                <i class="bi bi-envelope-arrow-down-fill"></i>
                <span>Pengajuan</span>
                @if ($notifPengajuanSidebar > 0)
                    <span class="notif-badge">{{ $notifPengajuanSidebar }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item {{ request()->is('admin/buku-dipinjam') ? 'active' : '' }}">
            <a href="{{ url('admin/buku-dipinjam') }}" class="nav-link"><i
                    class="bi bi-journal-bookmark-fill"></i><span>Buku Yang Dipinjam</span></a>
        </li>
        <li class="nav-item {{ request()->is('admin/history-peminjaman') ? 'active' : '' }}">
            <a href="{{ url('admin/history-peminjaman') }}" class="nav-link"><i
                    class="bi bi-hourglass-split"></i><span>History</span></a>
        </li>
        <li class="nav-item {{ request()->is('admin/data-ulasan') ? 'active' : '' }}">
            <a href="{{ url('admin/data-ulasan') }}" class="nav-link"><i class="bi bi-chat-dots"></i>
                <span>Ulasan</span></a>
        </li>
    </ul>
</aside>
