<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f5f6fc; font-family: Arial, Helvetica, sans-serif; color: #292b42; }

        /* ===== SIDEBAR ===== */
        .sidebar { width: 230px; height: 100vh; background: #fff; position: fixed; left: 0; top: 0; padding: 25px 18px; border-right: 1px solid #eee; }
        .logo { font-size: 20px; font-weight: bold; color: #33364d; margin-bottom: 40px; padding-left: 10px; }
        .logo i { color: #6573f5; margin-right: 8px; }
        .menu-title { font-size: 11px; color: #aaa; margin: 20px 10px 10px; text-transform: uppercase; font-weight: bold; }
        .sidebar a { display: flex; align-items: center; text-decoration: none; color: #77798b; padding: 12px 13px; border-radius: 10px; margin-bottom: 5px; font-size: 14px; }
        .sidebar a i { font-size: 17px; width: 28px; }
        .sidebar a:hover, .sidebar a.active { background: #eef0ff; color: #5d6be8; }

        /* ===== MAIN ===== */
        .main { margin-left: 230px; padding: 30px; }
        .card { border: none; border-radius: 15px; }
        .page-title { font-size: 24px; font-weight: bold; }
        .page-subtitle { color: #999; font-size: 13px; }
        .btn-primary { background: #6574ee; border: none; }
        .btn-primary:hover { background: #5665df; }
        .table { vertical-align: middle; }

        /* ===== STAT CARDS ===== */
        .stat-card { background: #fff; border: 1px solid #eee; border-radius: 15px; padding: 20px; height: 100%; }
        .stat-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px; }
        .icon-blue  { background: #eef0ff; color: #6574ee; }
        .icon-green { background: #e8f8ef; color: #2e9b65; }
        .icon-amber { background: #fff5e5; color: #d97706; }
        .icon-red   { background: #fdeaea; color: #dc3545; }
        .stat-number { font-size: 24px; font-weight: bold; margin-bottom: 2px; }
        .stat-text { color: #999; font-size: 13px; }

        /* ===== BADGES ===== */
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
        .status-dipinjam { background: #fff7ed; color: #c2410c; }
        .status-dikembalikan { background: #ecfdf5; color: #047857; }
        .status-terlambat { background: #fef2f2; color: #b91c1c; }

        .filter-chip { background: #eef0ff; color: #5d6be8; border-radius: 20px; padding: 5px 12px; font-size: 12px; font-weight: 600; display: inline-block; margin-right: 6px; }

        @media (max-width: 991px) { .sidebar { display: none; } .main { margin-left: 0; } }
    </style>
</head>
<body>

<!-- ========================= SIDEBAR ========================= -->
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

    <a href="{{ route('pengembalian.index') }}">
        <i class="bi bi-journal-check"></i>
        <span>Pengembalian</span>
    </a>

    <div class="menu-title">Lainnya</div>

    <a href="{{ route('laporan.index') }}" class="active">
        <i class="bi bi-bar-chart"></i>
        <span>Laporan</span>
    </a>

    <a href="{{ route('pengaturan.index') }}">
        <i class="bi bi-gear"></i>
        <span>Pengaturan</span>
    </a>
</div>

<!-- ========================= MAIN CONTENT ========================= -->
<div class="main">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="page-title">Laporan</div>
            <div class="page-subtitle">Ringkasan &amp; rekap data perpustakaan</div>
        </div>

        <a href="{{ route('laporan.print', array_filter($filter)) }}"
           target="_blank"
           class="btn btn-primary">

            <i class="bi bi-printer"></i>
            Cetak Laporan

        </a>
    </div>

    <!-- FILTER -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-funnel"></i> Filter Laporan</h6>

            <form method="GET" action="{{ route('laporan.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ $filter['dari'] }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ $filter['sampai'] }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ $filter['status'] === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ $filter['status'] === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="terlambat" {{ $filter['status'] === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i> Terapkan
                        </button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            @if($filter['dari'] || $filter['sampai'] || $filter['status'])
                <div class="mt-3">
                    @if($filter['dari'] || $filter['sampai'])
                        <span class="filter-chip">
                            <i class="bi bi-calendar3"></i>
                            Periode: {{ $filter['dari'] ?: 'awal' }} &ndash; {{ $filter['sampai'] ?: 'sekarang' }}
                        </span>
                    @endif

                    @if($filter['status'])
                        <span class="filter-chip">
                            <i class="bi bi-flag"></i>
                            Status: {{ ucfirst($filter['status']) }}
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- RINGKASAN -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-blue"><i class="bi bi-book"></i></div>
                <div class="stat-number">{{ $totalBuku }}</div>
                <div class="stat-text">Total Buku</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-blue"><i class="bi bi-people"></i></div>
                <div class="stat-number">{{ $totalAnggota }}</div>
                <div class="stat-text">Total Anggota</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-green"><i class="bi bi-journal-arrow-up"></i></div>
                <div class="stat-number">{{ $totalTransaksi }}</div>
                <div class="stat-text">Total Transaksi (terfilter)</div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-amber"><i class="bi bi-cash-coin"></i></div>
                <div class="stat-number">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                <div class="stat-text">Total Denda (terfilter)</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-amber"><i class="bi bi-arrow-up-right"></i></div>
                <div class="stat-number">{{ $dipinjam }}</div>
                <div class="stat-text">Sedang Dipinjam</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-green"><i class="bi bi-journal-check"></i></div>
                <div class="stat-number">{{ $dikembalikan }}</div>
                <div class="stat-text">Sudah Dikembalikan</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-red"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="stat-number">{{ $terlambat }}</div>
                <div class="stat-text">Terlambat</div>
            </div>
        </div>
    </div>

    <!-- TABEL TRANSAKSI -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Transaksi</h6>
                <span class="text-muted small">{{ $transaksi->count() }} dari {{ $transaksi->total() }} data</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
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
                    @forelse($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration + $transaksi->firstItem() - 1 }}</td>

                            <td>
                                <div class="fw-semibold">{{ $item->anggota->nama_lengkap ?? '-' }}</div>
                                <div class="text-muted small">NIS: {{ $item->anggota->nis ?? '-' }}</div>
                            </td>

                            <td>{{ $item->buku->judul_buku ?? '-' }}</td>

                            <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') : '-' }}</td>

                            <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y') : '-' }}</td>

                            <td>
                                @php
                                    $statusClass = match ($item->status) {
                                        'dipinjam' => 'status-dipinjam',
                                        'dikembalikan' => 'status-dikembalikan',
                                        default => 'status-terlambat',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($item->status) }}</span>
                            </td>

                            <td>
                                {{ $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox" style="font-size: 36px;"></i>
                                <p class="mt-2 mb-0">Tidak ada transaksi untuk filter yang dipilih.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>

</div>
</body>
</html>