<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pengembalian - Perpustakaan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background: #f5f6fc;
            font-family: Arial, Helvetica, sans-serif;
        }

        .main {
            max-width: 600px;
            margin: 50px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .status-dikembalikan {
            background: #d4edda;
            color: #155724;
            padding: 8px 12px;
            border-radius: 6px;
            display: inline-block;
        }

    </style>

</head>

<body>

<div class="main">

    <div class="mb-4">

        <h3 class="fw-bold">
            Detail Pengembalian #{{ $transaksi->id_transaksi }}
        </h3>

        <p class="text-muted">
            Informasi detail pengembalian buku.
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body p-4">

            <!-- DETAIL PEMINJAM -->
            <h6 class="mb-3 text-primary">
                <i class="bi bi-person"></i> Informasi Peminjam
            </h6>

            <div class="detail-row">
                <span class="detail-label">Nama Anggota</span>
                <span class="detail-value">{{ $transaksi->anggota->nama_lengkap ?? '-' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">NIS</span>
                <span class="detail-value">{{ $transaksi->anggota->nis ?? '-' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Kelas</span>
                <span class="detail-value">{{ $transaksi->anggota->kelas ?? '-' }}</span>
            </div>


            <!-- DETAIL BUKU -->
            <h6 class="mb-3 mt-4 text-primary">
                <i class="bi bi-book"></i> Informasi Buku
            </h6>

            <div class="detail-row">
                <span class="detail-label">Judul Buku</span>
                <span class="detail-value">{{ $transaksi->buku->judul_buku ?? '-' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Pengarang</span>
                <span class="detail-value">{{ $transaksi->buku->pengarang ?? '-' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Penerbit</span>
                <span class="detail-value">{{ $transaksi->buku->penerbit ?? '-' }}</span>
            </div>


            <!-- DETAIL TRANSAKSI -->
            <h6 class="mb-3 mt-4 text-primary">
                <i class="bi bi-calendar"></i> Informasi Transaksi
            </h6>

            <div class="detail-row">
                <span class="detail-label">Tanggal Pinjam</span>
                <span class="detail-value">{{ $transaksi->tanggal_pinjam }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Tanggal Kembali</span>
                <span class="detail-value">{{ $transaksi->tanggal_kembali ?? '-' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Lama Peminjaman</span>
                <span class="detail-value">
                    @php
                        $from = \Carbon\Carbon::parse($transaksi->tanggal_pinjam);
                        $to = \Carbon\Carbon::parse($transaksi->tanggal_kembali ?? now());
                        $days = $to->diffInDays($from);
                    @endphp
                    {{ $days }} hari
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span>
                    <span class="status-dikembalikan">
                        <i class="bi bi-check-circle"></i> {{ ucfirst($transaksi->status) }}
                    </span>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Denda</span>
                <span class="detail-value">Rp {{ number_format($transaksi->denda ?? 0, 0, ',', '.') }}</span>
            </div>


            <!-- BUTTON -->

            <div class="d-flex gap-2 mt-4">

                <a
                    href="{{ route('pengembalian.index') }}"
                    class="btn btn-light">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

                <a
                    href="{{ route('pengembalian.history') }}"
                    class="btn btn-secondary">

                    <i class="bi bi-list"></i>
                    Lihat Riwayat

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>
