<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proses Pengembalian - Perpustakaan</title>

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

        .info-section {
            background: #eef0ff;
            border-left: 4px solid #6574ee;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-section h6 {
            color: #6574ee;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .info-row strong {
            color: #333;
        }

        .info-row span {
            color: #666;
        }

    </style>

</head>

<body>

<div class="main">

    <div class="mb-4">

        <h3 class="fw-bold">
            Proses Pengembalian Buku
        </h3>

        <p class="text-muted">
            Catat tanggal pengembalian dan denda (jika ada).
        </p>

    </div>


    <div class="card shadow-sm">

        <div class="card-body p-4">

            <!-- INFO SECTION -->

            <div class="info-section">

                <h6>Informasi Peminjaman</h6>

                <div class="info-row">
                    <strong>Anggota:</strong>
                    <span>{{ $transaksi->anggota->nama_lengkap ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <strong>NIS:</strong>
                    <span>{{ $transaksi->anggota->nis ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <strong>Buku:</strong>
                    <span>{{ $transaksi->buku->judul_buku ?? '-' }}</span>
                </div>

                <div class="info-row">
                    <strong>Tanggal Pinjam:</strong>
                    <span>{{ $transaksi->tanggal_pinjam }}</span>
                </div>

                <div class="info-row">
                    <strong>Lama Peminjaman:</strong>
                    <span>
                        @php
                            $from = \Carbon\Carbon::parse($transaksi->tanggal_pinjam);
                            $to = \Carbon\Carbon::now();
                            $days = $to->diffInDays($from);
                        @endphp
                        {{ $days }} hari
                    </span>
                </div>

                <div class="info-row">
                    <strong>Jatuh Tempo:</strong>
                    <span>{{ $jatuhTempo->translatedFormat('d M Y') }} ({{ $lamaPinjam }} hari)</span>
                </div>

                <div class="info-row">
                    <strong>Keterlambatan:</strong>
                    <span class="{{ $hariTerlambat > 0 ? 'text-danger fw-bold' : '' }}">
                        @if($hariTerlambat > 0)
                            {{ $hariTerlambat }} hari terlambat
                        @else
                            Tidak terlambat
                        @endif
                    </span>
                </div>

            </div>


            <!-- FORM PENGEMBALIAN -->

            <form
                action="{{ route('pengembalian.store', $transaksi->id_transaksi) }}"
                method="POST">

                @csrf


                <!-- TANGGAL KEMBALI -->

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal Kembali <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal_kembali"
                        class="form-control"
                        value="{{ date('Y-m-d') }}"
                        min="{{ $transaksi->tanggal_pinjam }}"
                        required>

                    @error('tanggal_kembali')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <!-- DENDA -->

                <div class="mb-3">

                    <label class="form-label">
                        Denda (Rp) <span class="text-muted">(opsional)</span>
                    </label>

                    <input
                        type="number"
                        name="denda"
                        step="1000"
                        min="0"
                        class="form-control"
                        placeholder="Kosongkan untuk otomatis"
                        value="{{ old('denda') }}">

                    <small class="text-muted">
                        @if($hariTerlambat > 0)
                            Denda otomatis: {{ $hariTerlambat }} hari &times; Rp {{ number_format($dendaPerHari, 0, ',', '.') }} =
                            <strong>Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</strong>.
                            Kosongkan untuk memakai nilai otomatis.
                        @else
                            Kosongkan jika tidak ada denda. Isi manual untuk denda kerusakan.
                        @endif
                    </small>

                    @error('denda')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <!-- BUTTON -->

                <div class="d-flex gap-2 mt-4">

                    <a
                        href="{{ route('pengembalian.index') }}"
                        class="btn btn-light">

                        Batal

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>

                        Catat Pengembalian

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>

</body>

</html>
