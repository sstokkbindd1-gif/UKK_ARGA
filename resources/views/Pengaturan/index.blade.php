<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Perpustakaan</title>
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
        .main { margin-left: 230px; padding: 30px; max-width: 900px; }
        .card { border: none; border-radius: 15px; }
        .page-title { font-size: 24px; font-weight: bold; }
        .page-subtitle { color: #999; font-size: 13px; }
        .btn-primary { background: #6574ee; border: none; }
        .btn-primary:hover { background: #5665df; }

        .setting-icon { width: 42px; height: 42px; border-radius: 12px; background: #eef0ff; color: #6574ee; display: flex; align-items: center; justify-content: center; font-size: 19px; }
        .form-label { font-weight: 600; font-size: 13.5px; }
        .hint { font-size: 12px; color: #999; margin-top: 4px; }

        @media (max-width: 991px) { .sidebar { display: none; } .main { margin-left: 0; padding: 20px; } }
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

    <a href="{{ route('laporan.index') }}">
        <i class="bi bi-bar-chart"></i>
        <span>Laporan</span>
    </a>

    <a href="{{ route('pengaturan.index') }}" class="active">
        <i class="bi bi-gear"></i>
        <span>Pengaturan</span>
    </a>
</div>

<!-- ========================= MAIN CONTENT ========================= -->
<div class="main">

    <!-- HEADER -->
    <div class="mb-4">
        <div class="page-title">Pengaturan</div>
        <div class="page-subtitle">Kelola profil akun, informasi perpustakaan, dan aturan sirkulasi</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- PROFIL AKUN -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="setting-icon"><i class="bi bi-person-gear"></i></div>
                <div>
                    <h6 class="fw-bold mb-0">Profil Akun</h6>
                    <small class="text-muted">Akun admin yang sedang login</small>
                </div>
            </div>

            <form method="POST" action="{{ route('pengaturan.akun') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Biarkan kosong jika tidak diubah">
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" placeholder="Ulangi password baru">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Profil
                </button>
            </form>
        </div>
    </div>

    <!-- INFORMASI PERPUSTAKAAN -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="setting-icon"><i class="bi bi-building"></i></div>
                <div>
                    <h6 class="fw-bold mb-0">Informasi Perpustakaan</h6>
                    <small class="text-muted">Tampil pada halaman cetak laporan</small>
                </div>
            </div>

            <form method="POST" action="{{ route('pengaturan.info') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Perpustakaan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_perpustakaan" class="form-control" value="{{ old('nama_perpustakaan', $pengaturan['nama_perpustakaan']) }}" required>
                    @error('nama_perpustakaan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap perpustakaan">{{ old('alamat', $pengaturan['alamat']) }}</textarea>
                    @error('alamat')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $pengaturan['telepon']) }}" placeholder="Contoh: (0761) 123-456">
                        @error('telepon')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Perpustakaan</label>
                        <input type="email" name="email_perpustakaan" class="form-control" value="{{ old('email_perpustakaan', $pengaturan['email_perpustakaan']) }}" placeholder="contoh@perpus.sch.id">
                        @error('email_perpustakaan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Informasi
                </button>
            </form>
        </div>
    </div>

    <!-- ATURAN SIRKULASI -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="setting-icon"><i class="bi bi-sliders"></i></div>
                <div>
                    <h6 class="fw-bold mb-0">Aturan Sirkulasi</h6>
                    <small class="text-muted">Dipakai otomatis pada transaksi peminjaman &amp; pengembalian</small>
                </div>
            </div>

            <form method="POST" action="{{ route('pengaturan.sirkulasi') }}">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Lama Peminjaman (hari) <span class="text-danger">*</span></label>
                        <input type="number" name="lama_pinjam_hari" class="form-control" min="1" max="90" value="{{ old('lama_pinjam_hari', $pengaturan['lama_pinjam_hari']) }}" required>
                        <div class="hint">Menjadi jatuh tempo otomatis saat membuat transaksi peminjaman.</div>
                        @error('lama_pinjam_hari')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Denda per Hari (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="denda_per_hari" class="form-control" min="0" max="100000" step="500" value="{{ old('denda_per_hari', $pengaturan['denda_per_hari']) }}" required>
                        <div class="hint">Dihitung otomatis saat proses pengembalian jika denda dikosongkan.</div>
                        @error('denda_per_hari')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Maks. Buku Dipinjam <span class="text-danger">*</span></label>
                        <input type="number" name="maks_pinjam" class="form-control" min="1" max="10" value="{{ old('maks_pinjam', $pengaturan['maks_pinjam']) }}" required>
                        <div class="hint">Anggota tidak dapat meminjam melebihi batas ini.</div>
                        @error('maks_pinjam')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Aturan
                </button>
            </form>
        </div>
    </div>

</div>
</body>
</html>