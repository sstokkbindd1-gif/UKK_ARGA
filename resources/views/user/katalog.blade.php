@include('user.partials.head', ['title' => 'Katalog Buku'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <!-- JUDUL HALAMAN -->
        <div class="mb-4">
            <h4 class="page-title mb-1">Katalog Buku</h4>
            <p class="text-muted-2 mb-0">
                Jelajahi koleksi perpustakaan sekolah.
            </p>
        </div>

        <!-- SEARCH BAR -->
        <div class="card-section p-3 p-md-4 mb-4">

            <form method="GET" action="{{ route('user.katalog') }}" role="search" class="d-flex gap-2 flex-wrap">
                <input
                    type="text"
                    name="q"
                    value="{{ $kataKunci }}"
                    class="form-control search-input flex-grow-1"
                    placeholder="Cari judul buku, penulis, atau kategori..."
                    style="min-width:240px;">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-search me-1"></i> Cari
                </button>

                @if ($kataKunci !== '')
                    <a href="{{ route('user.katalog') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i> Reset
                    </a>
                @endif
            </form>

        </div>

        <!-- HASIL -->
        @if ($buku->isEmpty())

            <div class="card-section text-center py-5 px-3">
                @if ($kataKunci !== '')
                    <i class="bi bi-search" style="font-size:40px;color:#b9bad3;"></i>
                    <p class="text-muted-2 mt-2 mb-0">
                        Tidak ada buku yang sesuai dengan pencarian.
                    </p>
                @else
                    <i class="bi bi-collection" style="font-size:40px;color:#b9bad3;"></i>
                    <p class="text-muted-2 mt-2 mb-0">Belum ada buku di katalog.</p>
                @endif
            </div>

        @else

            <p class="text-muted-2 small mb-3">
                Menampilkan {{ $buku->firstItem() }} - {{ $buku->lastItem() }}
                dari {{ $buku->total() }} buku

                @if ($kataKunci !== '')
                    untuk kata kunci <span class="fw-bold text-dark">"{{ $kataKunci }}"</span>
                @endif
            </p>

            <div class="row g-3">
                @foreach ($buku as $bukuItem)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        @include('user.partials.buku_card', ['buku' => $bukuItem])
                    </div>
                @endforeach
            </div>

            @if ($buku->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $buku->links() }}
                </div>
            @endif

        @endif

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
