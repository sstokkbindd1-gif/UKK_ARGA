<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Perpustakaan</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f7f8fc;
            font-family: Arial, Helvetica, sans-serif;
            color: #444;
        }


        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;

            width: 230px;
            height: 100vh;

            background: white;

            padding: 30px 16px;

            border-right: 1px solid #eee;
        }


        .logo {
            font-size: 20px;
            font-weight: bold;

            color: #6574ee;

            margin-bottom: 40px;

            padding-left: 15px;
        }


        .menu-title {
            font-size: 12px;

            color: #999;

            margin-bottom: 12px;

            padding-left: 12px;
        }


        .menu {
            list-style: none;

            padding: 0;
            margin: 0;
        }


        .menu li {
            margin-bottom: 8px;
        }


        .menu a {
            display: flex;

            align-items: center;

            gap: 14px;

            padding: 14px 12px;

            text-decoration: none;

            color: #777;

            font-size: 14px;

            border-radius: 10px;

            transition: .2s;
        }


        .menu a i {
            font-size: 17px;
        }


        .menu a:hover {
            background: #f1f2ff;

            color: #6574ee;
        }


        .menu a.active {
            background: #eef0ff;

            color: #6574ee;
        }


        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 230px;

            min-height: 100vh;

            padding: 30px;
        }


        /* =========================
           TOPBAR
        ========================= */

        .topbar {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 30px;
        }


        .welcome h3 {
            font-size: 24px;

            font-weight: bold;

            margin: 0;
        }


        .welcome p {
            color: #999;

            font-size: 14px;

            margin-top: 7px;
        }


        .profile {
            display: flex;

            align-items: center;

            gap: 10px;
        }


        .profile-icon {
            width: 40px;
            height: 40px;

            border-radius: 50%;

            background: #eef0ff;

            color: #6574ee;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        /* =========================
           WELCOME CARD
        ========================= */

        .welcome-card {
            background: #6876ee;

            color: white;

            border-radius: 16px;

            padding: 28px;

            margin-bottom: 25px;
        }


        .welcome-card h4 {
            font-weight: bold;

            margin-bottom: 8px;
        }


        .welcome-card p {
            margin: 0;

            opacity: .85;

            font-size: 14px;
        }


        /* =========================
           STAT CARD
        ========================= */

        .stat-card {
            background: white;

            border-radius: 15px;

            padding: 22px;

            border: 1px solid #eee;

            height: 100%;
        }


        .stat-icon {
            width: 45px;
            height: 45px;

            border-radius: 12px;

            background: #eef0ff;

            color: #6574ee;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            margin-bottom: 15px;
        }


        .stat-number {
            font-size: 25px;

            font-weight: bold;

            margin-bottom: 3px;
        }


        .stat-text {
            color: #999;

            font-size: 13px;
        }


        /* =========================
           MENU CARD
        ========================= */

        .menu-card {
            background: white;

            border-radius: 15px;

            padding: 20px;

            border: 1px solid #eee;

            height: 100%;

            text-decoration: none;

            color: #444;

            display: block;

            transition: .2s;
        }


        .menu-card:hover {
            transform: translateY(-3px);

            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);

            color: #6574ee;
        }


        .menu-card-icon {
            width: 45px;
            height: 45px;

            border-radius: 12px;

            background: #eef0ff;

            color: #6574ee;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;

            margin-bottom: 15px;
        }


        .menu-card h6 {
            font-weight: bold;

            margin-bottom: 5px;
        }


        .menu-card p {
            color: #999;


            .return-panel {
                background: white;
                border-radius: 15px;
                border: 1px solid #eee;
                padding: 22px;
                margin-bottom: 28px;
            }

            .return-panel-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 16px; }
            .return-panel-header h5 { margin: 0; font-weight: bold; }
            .return-panel-header p { margin: 4px 0 0; color: #999; font-size: 13px; }
            .return-list { display: grid; gap: 10px; }
            .return-item { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px; border: 1px solid #f0f0f4; border-radius: 10px; }
            .return-item strong { display: block; font-size: 14px; }
            .return-item small { color: #999; }
            .return-action { flex-shrink: 0; border-radius: 8px; background: #eef0ff; color: #6574ee; font-size: 12px; font-weight: 600; text-decoration: none; padding: 9px 12px; }
            .return-action:hover { background: #6574ee; color: white; }
            .empty-return { padding: 20px; border: 1px dashed #ddd; border-radius: 10px; color: #999; text-align: center; font-size: 13px; }
            font-size: 13px;

            margin: 0;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 70px;

                padding: 20px 8px;
            }

            .logo {
                font-size: 0;

                text-align: center;

                padding: 0;
            }

            .logo i {
                font-size: 22px;
            }

            .menu-title {
                display: none;
            }

            .menu a {
                justify-content: center;
            }

            .menu a span {
                display: none;
            }

            .main {
                margin-left: 70px;

                padding: 20px;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<div class="sidebar">

    <div class="logo">

        <i class="bi bi-book"></i>

        Perpustakaan
    </div>


    <div class="menu-title">
        MENU
    </div>


    <ul class="menu">


        <!-- DASHBOARD -->

        <li>

            <a
                href="{{ url('/') }}"
                class="active">

                <i class="bi bi-grid"></i>

                <span>
                    Dashboard
                </span>

            </a>

        </li>


        <!-- BUKU -->

        <li>

            <a href="{{ route('buku.index') }}">

                <i class="bi bi-book"></i>

                <span>
                    Data Buku
                </span>

            </a>

        </li>


        <!-- ANGGOTA -->

        <li>

            <a href="{{ route('anggota.index') }}">

                <i class="bi bi-people"></i>

                <span>
                    Anggota
                </span>

            </a>

        </li>


        <!-- PEMINJAMAN -->

        <li>

            <a href="{{ route('transaksi.index') }}">

                <i class="bi bi-journal-arrow-up"></i>

                <span>
                    Peminjaman
                </span>

            </a>

        </li>


        <!-- PENGEMBALIAN -->

        <li>

            <a href="{{ route('pengembalian.index') }}">

                <i class="bi bi-journal-check"></i>

                <span>
                    Pengembalian
                </span>

            </a>

        </li>

        <!-- LAPORAN -->

        <li>

            <a href="{{ route('laporan.index') }}">

                <i class="bi bi-bar-chart"></i>

                <span>
                    Laporan
                </span>

            </a>

        </li>


    </ul>

</div>



<!-- =====================================================
     MAIN CONTENT
===================================================== -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <div class="welcome">

            <h3>
                Dashboard
            </h3>

            <p>
                Selamat datang di sistem perpustakaan.
            </p>

        </div>


        <div class="profile">

            <div class="profile-icon">

                <i class="bi bi-person"></i>

            </div>

            <div>

                <strong>
            <!-- PENGEMBALIAN -->

            <div class="return-panel">

                <div class="return-panel-header">

                    <div>
                        <h5>Pengembalian Buku</h5>
                        <p>Proses peminjaman aktif atau lihat pengembalian terbaru.</p>
                    </div>

                    <a href="{{ route('pengembalian.index') }}" class="return-action">Lihat semua</a>

                </div>

                <div class="return-list">
                    @forelse($pengembalianAktif as $item)
                        <div class="return-item">
                            <div>
                                <strong>{{ $item->buku->judul_buku ?? 'Buku tidak tersedia' }}</strong>
                                <small>{{ $item->anggota->nama_lengkap ?? 'Anggota tidak tersedia' }} &middot; Dipinjam {{ $item->tanggal_pinjam }}</small>
                            </div>
                            <a href="{{ route('pengembalian.create', $item->id_transaksi) }}" class="return-action">Kembalikan</a>
                        </div>
                    @empty
                        @forelse($pengembalianTerbaru as $item)
                            <div class="return-item">
                                <div>
                                    <strong>{{ $item->buku->judul_buku ?? 'Buku tidak tersedia' }}</strong>
                                    <small>{{ $item->anggota->nama_lengkap ?? 'Anggota tidak tersedia' }} &middot; Dikembalikan {{ $item->tanggal_kembali }}</small>
                                </div>
                                <a href="{{ route('pengembalian.show', $item->id_transaksi) }}" class="return-action">Detail</a>
                            </div>
                        @empty
                            <div class="empty-return">Belum ada data pengembalian.</div>
                        @endforelse
                    @endforelse
                </div>

            </div>


                    {{ Auth::user()->name ?? 'Admin' }}
                </strong>

                <br>

                <small class="text-muted">
                    {{ Auth::user()->role ?? 'Perpustakaan' }}
                </small>

            </div>

            <form action="{{ route('logout') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
            </form>

        </div>

    </div>



    <!-- WELCOME -->

    <div class="welcome-card">

        <h4>
            Selamat Datang 👋
        </h4>

        <p>
            Kelola data buku, anggota, dan peminjaman
            melalui dashboard perpustakaan.
        </p>

    </div>



    <!-- STATISTIK -->

    <div class="row g-4 mb-4">


        <!-- BUKU -->

        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon">

                    <i class="bi bi-book"></i>

                </div>

                <div class="stat-number">
                    {{ $totalBuku }}
                </div>

                <div class="stat-text">
                    Total Buku
                </div>

            </div>

        </div>


        <!-- ANGGOTA -->

        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon">

                    <i class="bi bi-people"></i>

                </div>

                <div class="stat-number">
                    {{ $totalAnggota }}
                </div>

                <div class="stat-text">
                    Total Anggota
                </div>

            </div>

        </div>


        <!-- PEMINJAMAN -->

        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon">

                    <i class="bi bi-journal-arrow-up"></i>

                </div>

                <div class="stat-number">
                    {{ $bukuDipinjam }}
                </div>

                <div class="stat-text">
                    Buku Dipinjam
                </div>

            </div>

        </div>


    </div>



    <!-- MENU UTAMA -->

    <div class="mb-3">

        <h5 class="fw-bold">
            Menu Utama
        </h5>

        <p class="text-muted small">
            Pilih menu yang ingin kamu kelola.
        </p>

    </div>


    <div class="row g-4">


        <!-- DATA BUKU -->

        <div class="col-md-6">

            <a
                href="{{ route('buku.index') }}"
                class="menu-card">

                <div class="menu-card-icon">

                    <i class="bi bi-book"></i>

                </div>

                <h6>
                    Data Buku
                </h6>

                <p>
                    Kelola data dan koleksi buku perpustakaan.
                </p>

            </a>

        </div>


        <!-- ANGGOTA -->

        <div class="col-md-6">

            <a
                href="{{ route('anggota.index') }}"
                class="menu-card">

                <div class="menu-card-icon">

                    <i class="bi bi-people"></i>

                </div>

                <h6>
                    Anggota
                </h6>

                <p>
                    Kelola data anggota perpustakaan.
                </p>

            </a>

        </div>


        <!-- PEMINJAMAN -->

        <div class="col-md-6">

            <a
                href="#"
                class="menu-card">

                <div class="menu-card-icon">

                    <i class="bi bi-journal-arrow-up"></i>

                </div>

                <h6>
                    Peminjaman
                </h6>

                <p>
                    Kelola proses peminjaman buku.
                </p>

            </a>

        </div>


        <!-- PENGEMBALIAN -->

        <div class="col-md-6">

            <a
                href="#"
                class="menu-card">

                <div class="menu-card-icon">

                    <i class="bi bi-journal-check"></i>

                </div>

                <h6>
                    Pengembalian
                </h6>

                <p>
                    Kelola proses pengembalian buku.
                </p>

            </a>

        </div>


    </div>


</div>


</body>

</html>