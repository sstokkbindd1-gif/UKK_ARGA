<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Anggota</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f5f6fc;
        }

        .main {
            max-width: 750px;
            margin: 50px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .btn-primary {
            background: #6574ee;
            border: none;
        }

    </style>

</head>

<body>

<div class="main">

    <h3 class="fw-bold">
        Tambah Anggota
    </h3>

    <p class="text-muted">
        Tambahkan anggota baru.
    </p>


    <div class="card shadow-sm mt-4">

        <div class="card-body p-4">

            <form
                action="{{ route('anggota.store') }}"
                method="POST">

                @csrf


                <!-- EMAIL AKUN LOGIN -->

                <div class="mb-3">

                    <label class="form-label">
                        Email (untuk login)
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Masukkan email untuk akun login"
                        value="{{ old('email') }}"
                        required>

                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <!-- PASSWORD AKUN LOGIN -->

                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        required>

                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <!-- KONFIRMASI PASSWORD -->

                <div class="mb-3">

                    <label class="form-label">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password"
                        autocomplete="new-password"
                        required>

                </div>


                <!-- NIS -->

                <div class="mb-3">

                    <label class="form-label">
                        NIS
                    </label>

                    <input
                        type="text"
                        name="nis"
                        class="form-control"
                        placeholder="Masukkan NIS"
                        value="{{ old('nis') }}"
                        required>

                </div>


                <!-- NAMA -->

                <div class="mb-3">

                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        class="form-control"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('nama_lengkap') }}"
                        required>

                    <div class="text-muted small mt-1">
                        Nama ini juga dipakai sebagai nama akun login.
                    </div>

                    @error('nama_lengkap')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                </div>


                <!-- ALAMAT -->

                <div class="mb-3">

                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        class="form-control"
                        rows="3"
                        placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>

                </div>


                <!-- KELAS -->

                <div class="mb-3">

                    <label class="form-label">
                        Kelas
                    </label>

                    <input
                        type="text"
                        name="kelas"
                        class="form-control"
                        placeholder="Contoh: XII RPL 1"
                        value="{{ old('kelas') }}">

                </div>


                <div class="d-flex gap-2 mt-4">

                    <a
                        href="{{ route('anggota.index') }}"
                        class="btn btn-light">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan Anggota

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>