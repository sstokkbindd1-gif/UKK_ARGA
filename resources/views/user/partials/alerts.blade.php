@if (session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 py-2 mb-0 alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-0 alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-2 py-2 mb-0 alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle-fill mt-1"></i>
        <div>{{ implode(' ', $errors->all()) }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif
