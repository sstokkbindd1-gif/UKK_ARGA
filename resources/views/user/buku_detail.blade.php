@include('user.partials.head', ['title' => 'Detail Buku'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <a href="{{ route('user.katalog') }}" class="small text-decoration-none text-muted-2 d-inline-block mb-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
        </a>

        @php
            $stokTersedia = max(0, (int) ($buku->jumlah_stok ?? 0)) - (int) ($buku->pinjam_aktif_count ?? 0);
        @endphp

        <div class="card-section overflow-hidden">

            <div class="row g-0">

                <!-- COVER -->
                <div class="col-md-4 col-lg-3 p-4 text-center">

                    @if (!empty($buku->cover))
                        <img
                            src="{{ asset('storage/' . $buku->cover) }}"
                            alt="Cover {{ $buku->judul_buku }}"
                            class="book-cover"
                            style="max-width:260px;margin:0 auto;">
                    @else
                        <div class="book-cover-fallback" style="max-width:260px;margin:0 auto;">
                            <i class="bi bi-book"></i>
                        </div>
                    @endif

                </div>

                <!-- INFORMASI -->
                <div class="col-md-8 col-lg-9 p-4 border-start" style="border-color:#f0f0f8 !important;">

                    <h4 class="fw-bold mb-1">{{ $buku->judul_buku }}</h4>

                    @if (!empty($buku->kategori))
                        <span class="badge badge-soft badge-soft-info mb-3">{{ $buku->kategori }}</span>
                    @endif

                    <dl class="row small mb-4">

                        <dt class="col-sm-3 fw-normal text-muted-2">Penulis</dt>
                        <dd class="col-sm-9 mb-2">{{ $buku->pengarang }}</dd>

                        <dt class="col-sm-3 fw-normal text-muted-2">Penerbit</dt>
                        <dd class="col-sm-9 mb-2">{{ $buku->penerbit ?? '-' }}</dd>

                        <dt class="col-sm-3 fw-normal text-muted-2">Tahun Terbit</dt>
                        <dd class="col-sm-9 mb-2">{{ $buku->tahun_terbit ?? '-' }}</dd>

                        <dt class="col-sm-3 fw-normal text-muted-2">Stok</dt>
                        <dd class="col-sm-9 mb-2">{{ max(0, (int) ($buku->jumlah_stok ?? 0)) }} buku</dd>

                        <dt class="col-sm-3 fw-normal text-muted-2">Status</dt>
                        <dd class="col-sm-9 mb-0">
                            @if ($sedangDipinjamOlehSaya)
                                <span class="badge badge-soft badge-soft-warn">Sedang Anda Pinjam</span>
                            @elseif ($stokTersedia > 0)
                                <span class="badge badge-soft badge-soft-success">Tersedia</span>
                            @else
                                <span class="badge badge-soft badge-soft-danger">Tidak Tersedia</span>
                            @endif
                        </dd>

                    </dl>

                    <div class="d-flex gap-2 flex-wrap">

                        <form method="POST" action="{{ route('user.peminjaman.store') }}" class="m-0">
                            @csrf
                            <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

                            @if ($sedangDipinjamOlehSaya)
                                <button type="button" class="btn btn-primary" disabled>
                                    Sedang Anda Pinjam
                                </button>
                                <a href="{{ route('user.pengembalian.index') }}"
                                    class="btn btn-outline-secondary">
                                    Halaman Pengembalian
                                </a>
                            @elseif ($stokTersedia > 0)
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-journal-arrow-up me-1"></i> Pinjam Buku
                                </button>
                            @else
                                <button type="button" class="btn btn-primary" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif

                        </form>

                    </div>

                    @if ($stokTersedia > 0 && !$sedangDipinjamOlehSaya)
                        <p class="text-muted-2 small mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Lama peminjaman {{ \App\Http\Controllers\UserController::LAMA_PINJAM_HARI }} hari.
                        </p>
                    @endif

                </div>

            </div>

        </div>

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
