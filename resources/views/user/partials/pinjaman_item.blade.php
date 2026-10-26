@php
    $jatuhTempo = \App\Http\Controllers\UserController::tanggalJatuhTempo($t);
    $terlambat  = \Carbon\Carbon::today()->gt($jatuhTempo);
@endphp

<div class="card-section p-3 h-100">

    <div class="d-flex gap-3">

        <!-- COVER -->
        @if (!empty($t->buku?->cover))
            <img
                src="{{ asset('storage/' . $t->buku->cover) }}"
                alt="Cover {{ $t->buku?->judul_buku }}"
                class="cover-sm">
        @else
            <div class="cover-fallback-sm">
                <i class="bi bi-book"></i>
            </div>
        @endif

        <div class="flex-grow-1 min-width-0" style="min-width:0;">

            <h6 class="fw-bold mb-1 text-truncate">{{ $t->buku?->judul_buku ?? 'Buku tidak ditemukan' }}</h6>

            <p class="text-muted-2 small mb-2">
                <i class="bi bi-person me-1"></i>{{ $t->buku?->pengarang ?? '-' }}
            </p>

            <div class="small mb-2">

                <span class="text-muted-2 d-block">
                    <i class="bi bi-calendar-plus me-1"></i>
                    Tanggal Pinjam: {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->translatedFormat('d M Y') }}
                </span>

                <span class="{{ $terlambat ? 'text-danger fw-bold' : 'text-muted-2' }} d-block">
                    <i class="bi bi-alarm me-1"></i>
                    Jatuh Tempo: {{ $jatuhTempo->translatedFormat('d M Y') }}
                    @if ($terlambat)
                        &mdash; terlambat {{ \Carbon\Carbon::today()->diffInDays($jatuhTempo) }} hari
                    @endif
                </span>

            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-auto">

                @if ($t->status === 'terlambat' || $terlambat)
                    <span class="badge badge-soft badge-soft-danger">Terlambat</span>
                @else
                    <span class="badge badge-soft badge-soft-info">Dipinjam</span>
                @endif

                <a href="{{ route('user.buku.show', $t->id_buku) }}" class="btn btn-outline-secondary btn-sm">
                    Detail
                </a>

                <form method="POST" action="{{ route('user.pengembalian.store', $t->id_transaksi) }}" class="m-0"
                    onsubmit="return confirm('Kembalikan buku ini sekarang?');">

                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">
                        Ajukan Pengembalian
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
