@include('user.partials.head', ['title' => 'Peminjaman Saya'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <!-- JUDUL HALAMAN -->
        <div class="mb-4">
            <h4 class="page-title mb-1">Peminjaman Saya</h4>
            <p class="text-muted-2 mb-0">
                Daftar buku yang sedang Anda pinjam.
            </p>
        </div>

        @if ($sedangDipinjam->isEmpty())

            <div class="card-section text-center py-5 px-3">
                <i class="bi bi-journal-x" style="font-size:40px;color:#b9bad3;"></i>
                <p class="text-muted-2 mt-2 mb-3">
                    Belum ada buku yang sedang dipinjam.
                </p>
                <a href="{{ route('user.katalog') }}" class="btn btn-primary btn-sm px-3">
                    Lihat Katalog Buku
                </a>
            </div>

        @else

            <div class="row g-3">
                @foreach ($sedangDipinjam as $t)
                    <div class="col-lg-6 col-12">
                        @include('user.partials.pinjaman_item', ['t' => $t])
                    </div>
                @endforeach
            </div>

        @endif

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
