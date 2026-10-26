@include('user.partials.head', ['title' => 'Pengembalian'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <!-- JUDUL HALAMAN -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h4 class="page-title mb-1">Pengembalian</h4>
                <p class="text-muted-2 mb-0">
                    Buku yang harus Anda kembalikan.
                </p>
            </div>

            <a href="{{ route('user.history') }}" class="small text-decoration-none text-muted-2">
                Lihat history peminjaman <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <!-- KETENTUAN -->
        <div class="alert alert-light d-flex align-items-start gap-2 border py-2 px-3 small"
            style="border-color:#ececf5 !important; background:#f8f8fd;">

            <i class="bi bi-info-circle mt-1" style="color:#6574ee;"></i>

            <div class="text-muted-2">
                Lama peminjaman
                <span class="fw-bold text-dark">{{ \App\Http\Controllers\UserController::LAMA_PINJAM_HARI }} hari</span>
                dari tanggal pinjam. Keterlambatan didenda
                <span class="fw-bold text-dark">Rp{{ number_format(\App\Http\Controllers\UserController::DENDA_PER_HARI) }}/hari</span>.
            </div>

        </div>

        @if ($harusDikembalikan->isEmpty())

            <div class="card-section text-center py-5 px-3">
                <i class="bi bi-check2-all" style="font-size:40px;color:#9adbb0;"></i>
                <p class="text-muted-2 mt-2 mb-3">
                    Tidak ada buku yang perlu dikembalikan. Semua sudah selesai.
                </p>
                <a href="{{ route('user.katalog') }}" class="btn btn-outline-secondary btn-sm px-3">
                    Pinjam Buku Lagi
                </a>
            </div>

        @else

            <div class="card-section overflow-hidden">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="small text-muted-2" style="background:#f8f8fd;">
                            <tr>
                                <th class="ps-4 py-3 fw-normal">No</th>
                                <th class="py-3 fw-normal">Buku</th>
                                <th class="py-3 fw-normal">Tanggal Pinjam</th>
                                <th class="py-3 fw-normal">Batas Pengembalian</th>
                                <th class="py-3 fw-normal">Status</th>
                                <th class="pe-4 py-3 fw-normal text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($harusDikembalikan as $t)
                                @php
                                    $jatuhTempo = \App\Http\Controllers\UserController::tanggalJatuhTempo($t);
                                    $terlambat  = \Carbon\Carbon::today()->gt($jatuhTempo);
                                @endphp

                                <tr>
                                    <td class="ps-4 text-muted-2">{{ $loop->iteration }}</td>

                                    <td class="py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            @if (!empty($t->buku?->cover))
                                                <img src="{{ asset('storage/' . $t->buku->cover) }}"
                                                    alt="" class="rounded"
                                                    style="width:36px;height:48px;object-fit:cover;background:#eef0ff;">
                                            @else
                                                <div class="rounded d-flex align-items-center justify-content-center"
                                                    style="width:36px;height:48px;background:#eef0ff;color:#6574ee;font-size:16px;">
                                                    <i class="bi bi-book"></i>
                                                </div>
                                            @endif

                                            <div class="ms-1" style="min-width:140px;">
                                                <div class="fw-bold small">{{ $t->buku?->judul_buku ?? '-' }}</div>
                                                <div class="text-muted-2" style="font-size:12px;">{{ $t->buku?->pengarang }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-muted-2">{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->translatedFormat('d M Y') }}</td>

                                    <td>
                                        <span class="{{ $terlambat ? 'text-danger fw-bold' : '' }}">
                                            {{ $jatuhTempo->translatedFormat('d M Y') }}
                                        </span>

                                        @if ($terlambat)
                                            <div class="text-danger" style="font-size:12px;">
                                                Terlambat {{ \Carbon\Carbon::today()->diffInDays($jatuhTempo) }} hari
                                                (estimasi denda Rp{{ number_format(\Carbon\Carbon::today()->diffInDays($jatuhTempo) * \App\Http\Controllers\UserController::DENDA_PER_HARI) }})
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($t->status === 'terlambat' || $terlambat)
                                            <span class="badge badge-soft badge-soft-danger">Terlambat</span>
                                        @else
                                            <span class="badge badge-soft badge-soft-info">Dipinjam</span>
                                        @endif
                                    </td>

                                    <td class="pe-4 text-end">
                                        <form method="POST" action="{{ route('user.pengembalian.store', $t->id_transaksi) }}"
                                            onsubmit="return confirm('Kembalikan buku ini sekarang?');">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Kembalikan Sekarang
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>