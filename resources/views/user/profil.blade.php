@include('user.partials.head', ['title' => 'Profil Saya'])

<body class="d-flex flex-column min-vh-100">

    @include('user.partials.navbar')

    <main class="container-user py-4 flex-grow-1">

        <!-- PESAN / NOTIFIKASI -->
        <div class="mb-3">
            @include('user.partials.alerts')
        </div>

        <!-- JUDUL HALAMAN -->
        <div class="mb-4">
            <h4 class="page-title mb-1">Profil Saya</h4>
            <p class="text-muted-2 mb-0">
                Informasi akun dan data keanggotaan Anda.
            </p>
        </div>

        <div class="row g-3">

            <!-- INFORMASI AKUN -->
            <div class="col-lg-5 col-12">

                <div class="card-section p-4 h-100">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div class="d-flex align-items-center justify-content-center rounded-circle"
                            style="width:64px;height:64px;background:#eef0ff;color:#6574ee;font-size:24px;font-weight:bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <div class="text-muted-2 small">{{ $user->email }}</div>
                        </div>

                    </div>

                    <dl class="row small mb-0">

                        <dt class="col-5 fw-normal text-muted-2">Nama Lengkap</dt>
                        <dd class="col-7">{{ $anggota?->nama_lengkap ?? $user->name }}</dd>

                        <dt class="col-5 fw-normal text-muted-2">Username / Email</dt>
                        <dd class="col-7">{{ $user->email }}</dd>

                        <dt class="col-5 fw-normal text-muted-2">Role</dt>
                        <dd class="col-7">
                            <span class="badge badge-soft badge-soft-info">
                                {{ $user->role === 'admin' ? 'Admin' : 'Anggota' }}
                            </span>
                        </dd>

                        <dt class="col-5 fw-normal text-muted-2">Status Akun</dt>
                        <dd class="col-7 mb-0">
                            <span class="badge badge-soft {{ $user->status === 'aktif' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                {{ ucfirst($user->status ?? 'nonaktif') }}
                            </span>
                        </dd>

                    </dl>

                </div>

            </div>

            <!-- DATA ANGGOTA + EDIT -->
            <div class="col-lg-7 col-12">

                <div class="card-section p-4 h-100">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Data Anggota</h6>

                        <button class="btn btn-outline-secondary btn-sm" type="button"
                            data-bs-toggle="collapse" data-bs-target="#formEditProfil"
                            aria-expanded="false" aria-controls="formEditProfil">
                            <i class="bi bi-pencil me-1"></i> Edit Profil
                        </button>
                    </div>

                    @if ($anggota)
                        <dl class="row small mb-0">

                            <dt class="col-5 fw-normal text-muted-2">NIS</dt>
                            <dd class="col-7">{{ $anggota->nis }}</dd>

                            <dt class="col-5 fw-normal text-muted-2">Kelas</dt>
                            <dd class="col-7">{{ $anggota->kelas ?? '-' }}</dd>

                            <dt class="col-5 fw-normal text-muted-2">Alamat</dt>
                            <dd class="col-7 mb-0">{{ $anggota->alamat ?? '-' }}</dd>

                        </dl>
                    @else
                        <div class="alert alert-light border small mb-0"
                            style="border-color:#ececf5 !important;background:#f8f8fd;">
                            <i class="bi bi-info-circle me-1" style="color:#6574ee;"></i>
                            Data keanggotaan belum tersedia. Silakan hubungi petugas perpustakaan.
                        </div>
                    @endif

                    @if ($anggota)
                        <!-- FORM EDIT PROFIL -->
                        <div class="collapse mt-4" id="formEditProfil">

                            <hr style="border-color:#efeff8;">

                            <form method="POST" action="{{ route('user.profil.update') }}">

                                @csrf
                                @method('PUT')

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold" for="name">Nama</label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            required>
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold" for="email">Email</label>
                                        <input type="email" id="email" name="email"
                                            value="{{ old('email', $user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            required>
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold" for="nis">NIS</label>
                                        <input type="text" id="nis" name="nis"
                                            value="{{ old('nis', $anggota->nis) }}"
                                            class="form-control @error('nis') is-invalid @enderror"
                                            required>
                                        @error('nis')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold" for="kelas">Kelas</label>
                                        <input type="text" id="kelas" name="kelas"
                                            value="{{ old('kelas', $anggota->kelas) }}"
                                            class="form-control @error('kelas') is-invalid @enderror">
                                        @error('kelas')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label small fw-bold" for="alamat">Alamat</label>
                                        <input type="text" id="alamat" name="alamat"
                                            value="{{ old('alamat', $anggota->alamat) }}"
                                            class="form-control @error('alamat') is-invalid @enderror">
                                        @error('alamat')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold" for="password">
                                            Password Baru <span class="text-muted-2 fw-normal">(opsional)</span>
                                        </label>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold" for="password_confirmation">
                                            Konfirmasi Password
                                        </label>
                                        <input type="password" id="password_confirmation"
                                            name="password_confirmation" class="form-control">
                                    </div>

                                    <div class="col-12 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            Simpan Perubahan
                                        </button>

                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-toggle="collapse" data-bs-target="#formEditProfil">
                                            Batal
                                        </button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    @endif

                </div>

            </div>

        </div>

    </main>

    @include('user.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>