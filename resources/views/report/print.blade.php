<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111827;
            background: white;
            padding: 24px;
        }

        .header {
            border-bottom: 2px solid #1d4ed8;
            padding-bottom: 12px;
            margin-bottom: 22px;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #1d4ed8;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }

        .box {
            border: 1px solid #dbeafe;
            background: #f8fafc;
            border-radius: 12px;
            padding: 14px;
        }

        .box .label {
            font-size: 12px;
            color: #475569;
        }

        .box .value {
            font-size: 22px;
            font-weight: 700;
            margin-top: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 9px 10px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background: #eff6ff;
        }

        .badge {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 12px;
            background: #e0f2fe;
            color: #075985;
            font-size: 11px;
            font-weight: 600;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div class="title">{{ \App\Models\Setting::get('nama_perpustakaan', 'Perpustakaan') }}</div>
        <div class="subtitle">
            @if(\App\Models\Setting::get('alamat'))
                {{ \App\Models\Setting::get('alamat') }}
                @if(\App\Models\Setting::get('telepon'))
                    &bull; Telp: {{ \App\Models\Setting::get('telepon') }}
                @endif
                <br>
            @endif
            Laporan Perpustakaan &mdash; Dibuat pada {{ now()->translatedFormat('d F Y') }}
            @if($filter['dari'] || $filter['sampai'] || $filter['status'])
                <br>Periode: {{ $filter['dari'] ?: 'awal' }} s/d {{ $filter['sampai'] ?: 'sekarang' }}@if($filter['status']) &bull; Status: {{ ucfirst($filter['status']) }}@endif
            @endif
        </div>
    </div>

    <div class="summary-grid">
        <div class="box">
            <div class="label">Total Buku</div>
            <div class="value">{{ $totalBuku }}</div>
        </div>
        <div class="box">
            <div class="label">Total Anggota</div>
            <div class="value">{{ $totalAnggota }}</div>
        </div>
        <div class="box">
            <div class="label">Dipinjam</div>
            <div class="value">{{ $dipinjam }}</div>
        </div>
        <div class="box">
            <div class="label">Total Denda</div>
            <div class="value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="mb-3">
        <strong>Total Transaksi:</strong> {{ $totalTransaksi }} &nbsp; | &nbsp;
        <strong>Sudah Dikembalikan:</strong> {{ $dikembalikan }} &nbsp; | &nbsp;
        <strong>Terlambat:</strong> {{ $terlambat }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->anggota->nama_lengkap ?? '-' }}</td>
                    <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}</td>
                    <td><span class="badge">{{ ucfirst($item->status) }}</span></td>
                    <td>Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
