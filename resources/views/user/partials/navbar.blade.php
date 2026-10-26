<nav class="navbar navbar-expand-lg navbar-user sticky-top">

    <div class="container-user">

        <a class="navbar-brand p-0 brand-sec" href="{{ route('user.dashboard') }}">
            <i class="bi bi-book-half"></i>
            Perpustakaan Sekolah
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuUserNav"
            aria-controls="menuUserNav"
            aria-expanded="false"
            aria-label="Buka menu navigasi">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menuUserNav">

            <ul class="navbar-nav ms-lg-4 mb-2 mb-lg-0 mt-2 mt-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                        href="{{ route('user.dashboard') }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.katalog') || request()->routeIs('user.buku.show') ? 'active' : '' }}"
                        href="{{ route('user.katalog') }}">
                        Katalog Buku
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.peminjaman.index') ? 'active' : '' }}"
                        href="{{ route('user.peminjaman.index') }}">
                        Peminjaman Saya
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.pengembalian.index') ? 'active' : '' }}"
                        href="{{ route('user.pengembalian.index') }}">
                        Pengembalian
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.history') ? 'active' : '' }}"
                        href="{{ route('user.history') }}">
                        History
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.profil') ? 'active' : '' }}"
                        href="{{ route('user.profil') }}">
                        Profil
                    </a>
                </li>

            </ul>

            <div class="ms-lg-auto d-flex align-items-center flex-wrap gap-2 pb-2 pb-lg-0">

                <span class="user-chip" title="{{ auth()->user()->email }}">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

</nav>
