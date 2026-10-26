@include('user.partials.head', ['title' => 'Dashboard'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <!-- SAPAAN -->
        <div class="mb-4">
            <h4 class="page-title mb-1">
                Halo, {{ auth()->user()->anggota?->nama_lengkap ?? auth()->user()->name }} 👋
            </h4>
            <p class="text-muted-2 mb-0">
                Selamat datang kembali di Perpustakaan Sekolah.
            </p>
        </div>

        <!-- KARTU STATISTIK -->
        <div class="row g-3 mb-4">

            <!-- Buku Sedang Dipinjam -->
            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-journal-arrow-up"></i></div>
                    <div>
                        <div class="stat-number">{{ $statistik['sedang_dipinjam'] }}</div>
                        <div class="stat-text">Buku Sedang Dipinjam</div>
                    </div>
                </div>
            </div>

            <!-- Menunggu Pengembalian -->
            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-number">{{ $statistik['menunggu_pengembalian'] }}</div>
                        <div class="stat-text">Menunggu Pengembalian</div>
                    </div>
                </div>
            </div>

            <!-- Total Peminjaman -->
            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
                    <div>
                        <div class="stat-number">{{ $statistik['total_peminjaman'] }}</div>
                        <div class="stat-text">Total Peminjaman</div>
                    </div>
                </div>
            </div>

            <!-- Total Dikembalikan -->
            <div class="col-xl-3 col-md-6 col-12">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <div class="stat-number">{{ $statistik['total_dikembalikan'] }}</div>
                        <div class="stat-text">Total Dikembalikan</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- SEDANG DIPINJAM -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="section-title mb-0">Sedang Dipinjam</h5>

            <a href="{{ route('user.peminjaman.index') }}" class="small text-decoration-none text-muted-2">
                Lihat semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if ($sedangDipinjam->isEmpty())

            <div class="card-section text-center py-5 px-3 mb-4">
                <i class="bi bi-journal-x" style="font-size:40px;color:#b9bad3;"></i>
                <p class="text-muted-2 mt-2 mb-3">
                    Belum ada buku yang sedang dipinjam.
                </p>
                <a href="{{ route('user.katalog') }}" class="btn btn-primary btn-sm px-3">
                    Lihat Katalog Buku
                </a>




        
            </div>

        @else

            <div class="row g-3 mb-4">
                @foreach ($sedangDipinjam as $t)
                    <div class="col-lg-6 col-12">
                        @include('user.partials.pinjaman_item', ['t' => $t])
                    </div>
                @endforeach
            </div>

        @endif

        <!-- PENCARIAN BUKU -->
        <div class="card-section p-3 p-md-4 mb-4">

            <h5 class="section-title mb-1">Cari &amp; dapatkan</h5>

            <p class="text-muted-2 small mb-3">
                Cari berdasarkan judul, penulis, atau kategori.
            </p>

            <form method="GET" action="{{ route('user.katalog') }}" role="search" class="d-flex gap-2 flex-wrap">
                <input
                    type="text"
                    name="q"
                    value=""
                    class="form-control search-input flex-grow-1"
                    placeholder="Cari judul buku, penulis, atau kategori..."
                    style="min-width:240px;"
                    required>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
            </form>

        </div>

        <!-- BUKU TERBARU / REKOMENDASI -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="section-title mb-0">Buku Terbaru</h5>

            <a href="{{ route('user.katalog') }}" class="small text-decoration-none text-muted-2">
                Katalog lengkap <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if ($bukuTerbaru->isEmpty())

            <div class="card-section text-center py-5 px-3">
                <i class="bi bi-collection" style="font-size:40px;color:#b9bad3;"></i>
                <p class="text-muted-2 mt-2 mb-0">Belum ada buku di katalog.</p>
            </div>

        @else

            <div class="row g-3">
                @foreach ($bukuTerbaru as $buku)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        @include('user.partials.buku_card', ['buku' => $buku])
                    </div>
                @endforeach
            </div>

        @endif

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
