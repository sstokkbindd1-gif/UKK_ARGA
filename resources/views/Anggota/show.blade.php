<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detail Anggota</title>

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

    </style>

</head>

<body>

<div class="main">

    <h3 class="fw-bold">
        Detail Anggota
    </h3>

    <p class="text-muted">
        Informasi lengkap data anggota perpustakaan.
    </p>


    <div class="card shadow-sm mt-4">

        <div class="card-body p-4">

            <table class="table table-borderless align-middle mb-0">

                <tr>
                    <th class="text-muted" style="width: 160px;">Nama Lengkap</th>
                    <td>{{ $anggota->nama_lengkap }}</td>
                </tr>

                <tr>
                    <th class="text-muted">NIS</th>
                    <td>{{ $anggota->nis }}</td>
                </tr>

                <tr>
                    <th class="text-muted">Alamat</th>
                    <td>{{ $anggota->alamat ?? '-' }}</td>
                </tr>

                <tr>
                    <th class="text-muted">Kelas</th>
                    <td>{{ $anggota->kelas ?? '-' }}</td>
                </tr>

                <tr>
                    <th class="text-muted">Akun</th>
                    <td>
                        @if($anggota->user)
                            {{ $anggota->user->name }}
                            <span class="text-muted small">({{ $anggota->user->email }})</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="text-muted">Terdaftar</th>
                    <td>{{ $anggota->created_at?->translatedFormat('d M Y') ?? '-' }}</td>
                </tr>

            </table>


            <!-- TOMBOL -->

            <div class="d-flex gap-2 mt-4">

                <a
                    href="{{ route('anggota.index') }}"
                    class="btn btn-light">

                    Kembali

                </a>

                <a
                    href="{{ route('anggota.edit', $anggota->id_anggota) }}"
                    class="btn btn-primary">

                    <i class="bi bi-pencil me-1"></i>
                    Edit Anggota

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>