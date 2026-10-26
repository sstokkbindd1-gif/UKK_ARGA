<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengembalian Buku - Perpustakaan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f6fc;
            font-family: Arial, Helvetica, sans-serif;
            color: #292b42;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #ffffff;
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 18px;
            border-right: 1px solid #eeeeee;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #33364d;
            margin-bottom: 40px;
            padding-left: 10px;
        }

        .logo i {
            color: #6573f5;
            margin-right: 8px;
        }

        .menu-title {
            font-size: 11px;
            color: #aaa;
            margin: 20px 10px 10px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #77798b;
            padding: 12px 13px;
            border-radius: 10px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .sidebar a i {
            font-size: 17px;
            width: 28px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #eef0ff;
            color: #5d6be8;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            margin-left: 230px;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
        }

        .page-subtitle {
            color: #999;
            font-size: 13px;
        }

        .btn-primary {
            background: #6574ee;
            border: none;
        }

        .btn-primary:hover {
            background: #5665df;
        }

        .table {
            vertical-align: middle;
        }

        .badge-status {
            background: #fff3cd;
            color: #856404;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        .btn-action {
            width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;
        }

        /* Nav Tabs Styling */
        .nav-tabs .nav-link {
            color: #77798b;
            border: none;
            border-bottom: 3px solid transparent;
        }

        .nav-tabs .nav-link.active {
            background: transparent;
            color: #6574ee;
            border-bottom: 3px solid #6574ee;
        }

        .nav-tabs .nav-link:hover {
            color: #5d6be8;
            border-color: transparent;
        }

    </style>

</head>

<body>

<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar">

    <div class="logo">
        <i class="bi bi-book-half"></i>
        <span>Perpustakaan</span>
    </div>

    <div class="menu-title">Menu</div>

    <a href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('buku.index') }}">
        <i class="bi bi-book"></i>
        <span>Data Buku</span>
    </a>

    <a href="{{ route('anggota.index') }}">
        <i class="bi bi-people"></i>
        <span>Anggota</span>
    </a>

    <a href="{{ route('transaksi.index') }}">
        <i class="bi bi-journal-arrow-up"></i>
        <span>Transaksi</span>
    </a>

    <a href="{{ route('pengembalian.index') }}" class="active">
        <i class="bi bi-journal-check"></i>
        <span>Pengembalian</span>
    </a>

    <div class="menu-title">Lainnya</div>

    <a href="{{ route('laporan.index') }}">
        <i class="bi bi-bar-chart"></i>
        <span>Laporan</span>
    </a>

    <a href="{{ route('pengaturan.index') }}">
        <i class="bi bi-gear"></i>
        <span>Pengaturan</span>
    </a>

</div>

<!-- =========================
     MAIN CONTENT
========================= -->

<div class="main">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <div class="page-title">
                Pengembalian Buku
            </div>

            <div class="page-subtitle">
                Proses pengembalian buku yang dipinjam
            </div>

        </div>

    </div>


    <!-- ALERT -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            <i class="bi bi-exclamation-circle"></i>

            {{ session('error') }}

        </div>

    @endif


    <!-- NAV TABS -->
    <ul class="nav nav-tabs mb-4" id="peminjamantabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif" type="button" role="tab">
                <i class="bi bi-hourglass-split"></i> Peminjaman Aktif
                <span class="badge bg-warning ms-2">{{ $pengembalian->total() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab">
                <i class="bi bi-clock-history"></i> Riwayat Peminjaman
            </button>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content" id="peminjamantabContent">

        <!-- TAB PEMINJAMAN AKTIF -->
        <div class="tab-pane fade show active" id="aktif" role="tabpanel" tabindex="0">

            <!-- CARD -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-3">

                        <h6 class="fw-bold">
                            Daftar Peminjaman Aktif
                        </h6>

                        <span class="text-muted small">
                            Total: {{ $pengembalian->count() }} peminjaman
                        </span>

                    </div>


                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>Anggota</th>

                                    <th>Buku</th>

                                    <th>Tanggal Pinjam</th>

                                    <th>Status</th>

                                    <th>Aksi</th>

                                </tr>

                            </thead>


                            <tbody>

                            @forelse($pengembalian as $item)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- ANGGOTA -->

                                    <td>

                                        <div class="fw-semibold">

                                            {{ $item->anggota->nama_lengkap ?? '-' }}

                                        </div>

                                        <small class="text-muted">{{ $item->anggota->nis ?? '-' }}</small>

                                    </td>

                                    <!-- BUKU -->

                                    <td>

                                        <div class="fw-semibold">

                                            {{ $item->buku->judul_buku ?? '-' }}

                                        </div>

                                    </td>

                                    <!-- TANGGAL PINJAM -->

                                    <td>

                                        {{ $item->tanggal_pinjam }}

                                    </td>

                                    <!-- STATUS -->

                                    <td>

                                        <span class="badge-status">

                                            {{ $item->status }}

                                        </span>

                                    </td>

                                    <!-- AKSI -->

                                    <td>

                                        <!-- KEMBALIKAN -->

                                        <a
                                            href="{{ route('pengembalian.create', $item->id_transaksi) }}"
                                            class="btn btn-success btn-sm btn-action"
                                            title="Proses Pengembalian">

                                            <i class="bi bi-check"></i>

                                        </a>

                                        <!-- LIHAT -->

                                        <a
                                            href="{{ route('pengembalian.show', $item->id_transaksi) }}"
                                            class="btn btn-info btn-sm btn-action"
                                            title="Lihat Detail">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Tidak ada peminjaman aktif
                                    </td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- PAGINATION -->
            <div class="mt-3">
                {{ $pengembalian->links() }}
            </div>

        </div>

        <!-- TAB RIWAYAT PEMINJAMAN -->
        <div class="tab-pane fade" id="riwayat" role="tabpanel" tabindex="0">

            <!-- CARD -->
            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between mb-3">

                        <h6 class="fw-bold">
                            Riwayat Semua Peminjaman
                        </h6>

                        <span class="text-muted small">
                            Total: {{ $riwayat->count() }} transaksi
                        </span>

                    </div>


                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>No</th>

                                    <th>Anggota</th>

                                    <th>Buku</th>

                                    <th>Tanggal Pinjam</th>

                                    <th>Tanggal Kembali</th>

                                    <th>Status</th>

                                    <th>Denda</th>

                                </tr>

                            </thead>


                            <tbody>

                            @forelse($riwayat as $item)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- ANGGOTA -->

                                    <td>

                                        <div class="fw-semibold">

                                            {{ $item->anggota->nama_lengkap ?? '-' }}

                                        </div>

                                        <small class="text-muted">{{ $item->anggota->nis ?? '-' }}</small>

                                    </td>

                                    <!-- BUKU -->

                                    <td>

                                        <div class="fw-semibold">

                                            {{ $item->buku->judul_buku ?? '-' }}

                                        </div>

                                    </td>

                                    <!-- TANGGAL PINJAM -->

                                    <td>

                                        {{ $item->tanggal_pinjam }}

                                    </td>

                                    <!-- TANGGAL KEMBALI -->

                                    <td>

                                        {{ $item->tanggal_kembali ?? '-' }}

                                    </td>

                                    <!-- STATUS -->

                                    <td>

                                        @if($item->status == 'dipinjam')
                                            <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                        @elseif($item->status == 'dikembalikan')
                                            <span class="badge bg-success">{{ $item->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $item->status }}</span>
                                        @endif

                                    </td>

                                    <!-- DENDA -->

                                    <td>

                                        <strong>Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</strong>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada data peminjaman
                                    </td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- PAGINATION -->
            <div class="mt-3">
                {!! $riwayat->appends(request()->query())->render() !!}
            </div>

        </div>

    </div>

</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
