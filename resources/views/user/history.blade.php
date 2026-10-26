@include('user.partials.head', ['title' => 'History Peminjaman'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <!-- JUDUL HALAMAN -->
        <div class="mb-4">
            <h4 class="page-title mb-1">History Peminjaman</h4>
            <p class="text-muted-2 mb-0">
                Semua riwayat peminjaman buku Anda.
            </p>
        </div>

        <div class="card-section overflow-hidden">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="small text-muted-2" style="background:#f8f8fd;">
                        <tr>
                            <th class="ps-4 py-3 fw-normal">No</th>
                            <th class="py-3 fw-normal">Judul Buku</th>
                            <th class="py-3 fw-normal">Tanggal Pinjam</th>
                            <th class="py-3 fw-normal">Tanggal Kembali</th>
                            <th class="py-3 fw-normal">Status</th>
                            <th class="pe-4 py-3 fw-normal text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($riwayat as $t)

                            <tr>
                                <td class="ps-4 text-muted-2">
                                    {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}
                                </td>

                                <td class="fw-bold small">{{ $t->buku?->judul_buku ?? '-' }}</td>

                                <td class="text-muted-2">
                                    {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->translatedFormat('d M Y') }}
                                </td>

                                <td class="text-muted-2">
                                    {{ $t->tanggal_kembali
                                        ? \Carbon\Carbon::parse($t->tanggal_kembali)->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @if ($t->status === 'dikembalikan')
                                        <span class="badge badge-soft badge-soft-success">Dikembalikan</span>
                                    @elseif ($t->status === 'terlambat')
                                        <span class="badge badge-soft badge-soft-danger">Terlambat</span>
                                    @else
                                        <span class="badge badge-soft badge-soft-info">Dipinjam</span>
                                    @endif

                                    @if ((float) $t->denda > 0)
                                        <div class="text-danger" style="font-size:12px;">
                                            Denda Rp{{ number_format($t->denda) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="pe-4 text-end">
                                    @if ($t->buku)
                                        <a href="{{ route('user.buku.show', $t->id_buku) }}"
                                            class="btn btn-outline-secondary btn-sm">
                                            Detail
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-archive" style="font-size:40px;color:#b9bad3;"></i>
                                    <p class="text-muted-2 mt-2 mb-0">
                                        Belum ada riwayat peminjaman.
                                    </p>
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

        @if ($riwayat->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $riwayat->links() }}
            </div>
        @endif

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
