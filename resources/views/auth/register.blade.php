<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #eef4ff 0%, #e6f3ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .auth-card {
            width: 100%;
            max-width: 430px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(29, 78, 216, 0.12);
            padding: 32px 28px;
        }

        .brand {
            font-size: 2rem;
            font-weight: 700;
            color: #1d4ed8;
            margin-bottom: 8px;
        }

        .subtext {
            color: #6b7280;
            margin-bottom: 24px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #dbe4f0;
        }

        .btn-primary {
            background: #4f46e5;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
        }

        .link-text {
            color: #1d4ed8;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand"><i class="bi bi-book-half"></i> Perpustakaan</div>
        <div class="subtext">Buat akun anggota untuk masuk ke sistem.</div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis') }}" required>
                @error('nis')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>

        <div class="mt-3 text-center">
            Sudah punya akun? <a href="{{ route('login') }}" class="link-text">Masuk</a>
        </div>
    </div>
</body>
</html>
