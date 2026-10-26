<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ isset($transaksi) ? 'Edit' : 'Tambah' }} Transaksi - Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body {
            background: #f5f6fc;
            font-family: Arial, Helvetica, sans-serif;
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

        .btn-primary:hover {
            background: #5665df;
        }

    </style>

</head>

<body>

<div class="main">

    <div class="mb-4">

        <h3 class="fw-bold">
            {{ isset($transaksi) ? 'Edit' : 'Tambah' }} Transaksi
        </h3>

        <p class="text-muted">
            {{ isset($transaksi) ? 'Ubah informasi transaksi.' : 'Tambahkan transaksi peminjaman baru.' }}
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body p-4">

            <form action="{{ isset($transaksi) ? route('transaksi.update', $transaksi->id_transaksi) : route('transaksi.store') }}" method="POST">

                @csrf

                @if(isset($transaksi))
                    @method('PUT')
                @endif


                <!-- ANGGOTA -->

                <div class="mb-3">

                    <label class="form-label">
                        Anggota <span class="text-danger">*</span>
                    </label>

                    <select name="id_anggota" class="form-select" required>

                        <option value="">-- pilih anggota --</option>

                        @foreach($anggota as $a)

                            <option value="{{ $a->id_anggota }}" {{ (isset($transaksi) && $transaksi->id_anggota==$a->id_anggota) ? 'selected' : '' }}>{{ $a->nama_lengkap }}</option>

                        @endforeach

                    </select>

                    @error('id_anggota')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <!-- BUKU -->

                <div class="mb-3">

                    <label class="form-label">
                        Buku <span class="text-danger">*</span>
                    </label>

                    <select name="id_buku" class="form-select" required>

                        <option value="">-- pilih buku --</option>

                        @foreach($buku as $b)

                            <option value="{{ $b->id_buku }}" {{ (isset($transaksi) && $transaksi->id_buku == $b->id_buku) ? 'selected' : '' }}>{{ $b->judul_buku }}</option>

                        @endforeach

                        @if($buku->isEmpty())
                            <option value="" disabled>Semua buku sedang dipinjam</option>
                        @endif

                    </select>

                    @error('id_buku')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <div class="row">

                    <!-- TANGGAL PINJAM -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tanggal Pinjam <span class="text-danger">*</span>
                        </label>

                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', $transaksi->tanggal_pinjam ?? $defaultPinjam ?? '') }}" required>

                        @error('tanggal_pinjam')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                    </div>


                    <!-- TANGGAL KEMBALI -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tanggal Kembali <span class="text-muted">(opsional)</span>
                        </label>

                        <input type="date" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', $transaksi->tanggal_kembali ?? $defaultKembali ?? '') }}">

                        @error('tanggal_kembali')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @if(!isset($transaksi))
                            <div class="text-muted small mt-1">
                                <i class="bi bi-info-circle"></i>
                                Jatuh tempo default {{ $lamaPinjam ?? 7 }} hari (diatur di menu Pengaturan).
                            </div>
                        @endif

                    </div>

                </div>


                <div class="row">

                    <!-- STATUS -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select name="status" class="form-select" required>

                            <option value="">-- pilih status --</option>

                            <option value="dipinjam" {{ (isset($transaksi) && $transaksi->status == 'dipinjam') || old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>

                            <option value="dikembalikan" {{ (isset($transaksi) && $transaksi->status == 'dikembalikan') || old('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>

                            <option value="terlambat" {{ (isset($transaksi) && $transaksi->status == 'terlambat') || old('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>

                        </select>

                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                    </div>


                    <!-- DENDA -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Denda (Rp) <span class="text-muted">(opsional)</span>
                        </label>

                        <input type="number" name="denda" class="form-control" placeholder="0" value="{{ old('denda', $transaksi->denda ?? 0) }}">

                        @error('denda')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                    </div>

                </div>


                <!-- BUTTON -->

                <div class="d-flex gap-2 mt-4">

                    <a href="{{ route('transaksi.index') }}" class="btn btn-light">

                        Batal

                    </a>

                    <button type="submit" class="btn btn-primary">

                        <i class="bi bi-save"></i>

                        {{ isset($transaksi) ? 'Perbarui' : 'Simpan' }} Transaksi

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>
