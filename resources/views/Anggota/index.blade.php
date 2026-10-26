<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Anggota</title>

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

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            color: #999;
            font-size: 14px;
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

        .icon-user {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #eef0ff;
            color: #6574ee;
        }

        .kelas {
            background: #eef0ff;
            color: #6574ee;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
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

    <a href="{{ route('anggota.index') }}" class="active">
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

            <div class="title">
                Data Anggota
            </div>

            <div class="subtitle">
                Kelola data anggota perpustakaan
            </div>

        </div>

        <a
            href="{{ route('anggota.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>

            Tambah Anggota

        </a>

    </div>


    <!-- ALERT -->

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    <!-- TABLE -->

    <div class="card shadow-sm">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between mb-3">

                <h5 class="fw-bold">
                    Daftar Anggota
                </h5>

                <span class="text-muted">

                    Total:
                    {{ $anggota->count() }}
                    anggota

                </span>

            </div>


            <div class="table-responsive">

                <table class="table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama Lengkap</th>

                            <th>NIS</th>

                            <th>Alamat</th>

                            <th>Kelas</th>

                            <th>User</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($anggota as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="icon-user me-3">

                                        <i class="bi bi-person"></i>

                                    </div>

                                    <strong>
                                        {{ $item->nama_lengkap }}
                                    </strong>

                                </div>

                            </td>

                            <td>
                                {{ $item->nis }}
                            </td>

                            <td>
                                {{ $item->alamat ?? '-' }}
                            </td>

                            <td>

                                @if($item->kelas)

                                    <span class="kelas">
                                        {{ $item->kelas }}
                                    </span>

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @if($item->user)

                                    {{ $item->user->name }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                <!-- LIHAT -->

                                <a
                                    href="{{ route('anggota.show', $item->id_anggota) }}"
                                    class="btn btn-info btn-sm"
                                    title="Lihat Detail">

                                    <i class="bi bi-eye"></i>

                                </a>


                                <!-- EDIT -->

                                <a
                                    href="{{ route('anggota.edit', $item->id_anggota) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <!-- HAPUS -->

                                <form
                                    action="{{ route('anggota.destroy', $item->id_anggota) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5">

                                <i
                                    class="bi bi-people"
                                    style="font-size:40px;color:#aaa;">
                                </i>

                                <p class="text-muted mt-2">
                                    Belum ada data anggota.
                                </p>

                                <a
                                    href="{{ route('anggota.create') }}"
                                    class="btn btn-primary">

                                    Tambah Anggota

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