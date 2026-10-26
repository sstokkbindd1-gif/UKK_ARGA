<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-3">Detail Transaksi #{{ $transaksi->id_transaksi }}</h1>

        <table class="table table-bordered">
            <tr><th>Anggota</th><td>{{ $transaksi->anggota->nama_lengkap ?? '-' }}</td></tr>
            <tr><th>Buku</th><td>{{ $transaksi->buku->judul_buku ?? '-' }}</td></tr>
            <tr><th>Tanggal Pinjam</th><td>{{ $transaksi->tanggal_pinjam }}</td></tr>
            <tr><th>Tanggal Kembali</th><td>{{ $transaksi->tanggal_kembali ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ $transaksi->status }}</td></tr>
            <tr><th>Denda</th><td>{{ number_format($transaksi->denda,2) }}</td></tr>
        </table>

        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
