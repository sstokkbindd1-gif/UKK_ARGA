<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Buku - Perpustakaan</title>

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

        .book-icon {
            width: 42px;
            height: 48px;
            background: #eef0ff;
            color: #6574ee;
            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;
        }

        .book-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-stock {
            background: #e8f8ef;
            color: #2e9b65;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        .badge-category {
            background: #eef0ff;
            color: #6574ee;
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

    <a href="{{ route('buku.index') }}" class="active">
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

    <a href="{{ route('pengembalian.index') }}">
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
                Data Buku
            </div>

            <div class="page-subtitle">
                Kelola koleksi buku perpustakaan
            </div>

        </div>


        <a href="{{ route('buku.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>

            Tambah Buku

        </a>

    </div>


    <!-- ALERT -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="bi bi-check-circle"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- CARD -->

    <div class="card shadow-sm">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between mb-3">

                <h6 class="fw-bold">
                    Daftar Buku
                </h6>

                <span class="text-muted small">
                    Total: {{ $buku->count() }} buku
                </span>

            </div>


            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Buku</th>

                            <th>Pengarang</th>

                            <th>Penerbit</th>

                            <th>Tahun</th>

                            <th>Kategori</th>

                            <th>Stok</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($buku as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <!-- JUDUL + COVER -->

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="book-icon me-3">

                                        @if($item->cover)

                                            <img
                                                src="{{ asset('storage/' . $item->cover) }}"
                                                alt="Cover">

                                        @else

                                            <i class="bi bi-book"></i>

                                        @endif

                                    </div>


                                    <div>

                                        <div class="fw-semibold">

                                            {{ $item->judul_buku }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            <!-- PENGARANG -->

                            <td>

                                {{ $item->pengarang }}

                            </td>


                            <!-- PENERBIT -->

                            <td>

                                {{ $item->penerbit ?? '-' }}

                            </td>


                            <!-- TAHUN -->

                            <td>

                                {{ $item->tahun_terbit ?? '-' }}

                            </td>


                            <!-- KATEGORI -->

                            <td>

                                @if($item->kategori)

                                    <span class="badge-category">

                                        {{ $item->kategori }}

                                    </span>

                                @else

                                    -

                                @endif

                            </td>


                            <!-- STOK -->

                            <td>

                                <span class="badge-stock">

                                    {{ $item->jumlah_stok ?? 0 }} buku

                                </span>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <!-- LIHAT -->

                                <a
                                    href="{{ route('buku.show', $item->id_buku) }}"
                                    class="btn btn-info btn-sm btn-action"
                                    title="Lihat Detail">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <!-- EDIT -->

                                <a
                                    href="{{ route('buku.edit', $item->id_buku) }}"
                                    class="btn btn-warning btn-sm btn-action">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <!-- HAPUS -->

                                <form
                                    action="{{ route('buku.destroy', $item->id_buku) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?')">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm btn-action">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5">

                                <i
                                    class="bi bi-book"
                                    style="font-size:40px;color:#aaa;">
                                </i>

                                <p class="text-muted mt-2">

                                    Belum ada data buku.

                                </p>

                                <a
                                    href="{{ route('buku.create') }}"
                                    class="btn btn-primary">

                                    Tambah Buku

                                </a>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


</div>

</body>

</html>