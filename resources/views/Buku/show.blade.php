<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detail Buku</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background: #f5f6fc;
        }

        .main {
            max-width: 800px;
            margin: 50px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .btn-primary {
            background: #6574ee;
            border: none;
        }

        .cover-box {
            width: 200px;
            height: 260px;
            border-radius: 10px;
            background: #eef0ff;
            color: #6574ee;
        }

        .cover-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

    </style>

</head>

<body>

<div class="main">

    <h3 class="fw-bold">
        Detail Buku
    </h3>

    <p class="text-muted">
        Informasi lengkap data buku.
    </p>


    <div class="card shadow-sm mt-4">

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- COVER -->

                <div class="col-md-4 text-center">

                    <div class="cover-box d-inline-flex align-items-center justify-content-center">

                        @if($buku->cover && file_exists(storage_path('app/public/' . $buku->cover)))

                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover {{ $buku->judul_buku }}">

                        @else

                            <i class="bi bi-book" style="font-size: 60px;"></i>

                        @endif

                    </div>

                </div>


                <!-- INFORMASI -->

                <div class="col-md-8">

                    <table class="table table-borderless align-middle mb-0">

                        <tr>
                            <th class="text-muted" style="width: 140px;">Judul Buku</th>
                            <td>{{ $buku->judul_buku }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Pengarang</th>
                            <td>{{ $buku->pengarang }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Penerbit</th>
                            <td>{{ $buku->penerbit ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Tahun Terbit</th>
                            <td>{{ $buku->tahun_terbit ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Kategori</th>
                            <td>{{ $buku->kategori ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th class="text-muted">Jumlah Stok</th>
                            <td>
                                <span class="badge bg-primary">{{ $buku->jumlah_stok ?? 0 }} buku</span>
                            </td>
                        </tr>

                    </table>

                </div>

            </div>


            <!-- TOMBOL -->

            <div class="d-flex gap-2 mt-4">

                <a
                    href="{{ route('buku.index') }}"
                    class="btn btn-light">

                    Kembali

                </a>

                <a
                    href="{{ route('buku.edit', $buku->id_buku) }}"
                    class="btn btn-primary">

                    <i class="bi bi-pencil me-1"></i>
                    Edit Buku

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>