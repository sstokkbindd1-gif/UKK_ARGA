@php
    // jumlah_stok sudah mencerminkan stok tersedia (berkurang saat dipinjam,
    // bertambah saat dikembalikan), jadi tidak perlu dikurangi pinjaman lagi.
    $stokTersedia = max(0, (int) ($buku->jumlah_stok ?? 0));
@endphp

<div class="card-section h-100 d-flex flex-column overflow-hidden">

    <!-- COVER -->
    @if (!empty($buku->cover))
        <img
            src="{{ asset('storage/' . $buku->cover) }}"
            alt="Cover {{ $buku->judul_buku }}"
            class="book-cover rounded-0 rounded-top"
            style="border-radius: 15px 15px 0 0;">
    @else
        <div class="book-cover-fallback" style="border-radius: 15px 15px 0 0;">
            <i class="bi bi-book"></i>
        </div>
    @endif

    <div class="p-3 d-flex flex-column flex-grow-1">

        <!-- JUDUL & PENULIS -->
        <h6 class="fw-bold mb-1" style="line-height:1.35;">{{ $buku->judul_buku }}</h6>

        <p class="text-muted-2 small mb-2">
            <i class="bi bi-person me-1"></i>{{ $buku->pengarang }}
        </p>

        @if (!empty($buku->kategori))
            <div class="mb-3">
                <span class="badge badge-soft badge-soft-info">{{ $buku->kategori }}</span>
            </div>
        @else
            <div class="mb-3">&nbsp;</div>
        @endif

        <!-- STOK & STATUS -->
        <div class="d-flex justify-content-between align-items-center small mb-3">

            <span class="text-muted-2">
                <i class="bi bi-box-seam me-1"></i>Stok: {{ max(0, (int) ($buku->jumlah_stok ?? 0)) }}
            </span>

            @if ($stokTersedia > 0)
                <span class="badge badge-soft badge-soft-success">Tersedia</span>
            @else
                <span class="badge badge-soft badge-soft-danger">Stok Habis</span>
            @endif

        </div>

        <!-- AKSI -->
        <div class="d-flex gap-2 mt-auto flex-wrap">

            <a href="{{ route('user.buku.show', $buku->id_buku) }}"
                class="btn btn-outline-secondary btn-sm flex-grow-1">
                Detail Buku
            </a>

            <form method="POST" action="{{ route('user.peminjaman.store') }}" class="flex-grow-1 m-0"
                onsubmit="return confirm('Pinjam buku ini sekarang?');">

                @csrf
                <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

                @if ($stokTersedia > 0)
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        Pinjam Buku
                    </button>
                @else
                    <button type="submit" class="btn btn-primary btn-sm w-100" disabled>
                        Stok Habis
                    </button>
                @endif

            </form>

        </div>

    </div>

</div>
