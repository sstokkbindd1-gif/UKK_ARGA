<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --violet: #8b5cf6;
            --violet-2: #a855f7;
            --pink: #d946ef;
            --line: rgba(255, 255, 255, .16);
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 32px 16px;
            background: #120b26;
            color: #fff;
            font-family: 'Sora', system-ui, -apple-system, 'Segoe UI', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ===== Latar aurora ===== */
        .bg {
            position: fixed; inset: 0; z-index: -3;
            background: linear-gradient(160deg, #150d2e 0%, #1d1148 45%, #31126e 100%);
        }

        .orb {
            position: fixed; z-index: -2;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .5;
            animation: drift 16s ease-in-out infinite;
        }

        .orb-1 { width: 520px; height: 520px; background: #7c3aed; top: -140px; left: -120px; }
        .orb-2 { width: 440px; height: 440px; background: #4338ca; bottom: -160px; right: -100px; animation-delay: -6s; }
        .orb-3 { width: 320px; height: 320px; background: #c026d3; top: 42%; left: 58%; opacity: .32; animation-delay: -11s; }

        .dots {
            position: fixed; inset: 0; z-index: -1;
            background-image: radial-gradient(rgba(255, 255, 255, .13) 1px, transparent 1.5px);
            background-size: 30px 30px;
            -webkit-mask-image: radial-gradient(circle at 50% 45%, #000 0%, transparent 78%);
            mask-image: radial-gradient(circle at 50% 45%, #000 0%, transparent 78%);
        }

        /* ===== Ikon melayang ===== */
        .ficon {
            position: fixed; z-index: -1;
            width: 52px; height: 52px;
            display: grid; place-items: center;
            border-radius: 16px;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .14);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            color: #c4b5fd;
            font-size: 22px;
            animation: bob 7s ease-in-out infinite;
        }

        .ficon-1 { top: 16%; left: 12%; }
        .ficon-2 { top: 68%; left: 8%; animation-delay: -2.4s; color: #f0abfc; }
        .ficon-3 { top: 22%; right: 10%; animation-delay: -3.8s; color: #a5b4fc; }
        .ficon-4 { top: 74%; right: 14%; animation-delay: -5.2s; }

        @keyframes drift { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(40px, -30px) scale(1.08); } }
        @keyframes bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-16px); } }
        @keyframes rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }

        @media (max-width: 767px) {
            .ficon, .orb-3 { display: none; }
        }

        /* ===== Kartu kaca ===== */
        .card-login {
            width: min(460px, 100%);
            padding: 38px 34px 30px;
            border-radius: 26px;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .14);
            backdrop-filter: blur(22px);
            -webkit-backdrop-filter: blur(22px);
            box-shadow: 0 34px 90px rgba(5, 2, 20, .55), inset 0 1px 0 rgba(255, 255, 255, .12);
            animation: rise .6s ease both;
        }

        .brand { display: flex; align-items: center; gap: 12px; }

        .brand-badge {
            width: 46px; height: 46px;
            display: grid; place-items: center;
            border-radius: 15px;
            color: #fff; font-size: 23px;
            background: linear-gradient(135deg, #8b5cf6, #d946ef);
            box-shadow: 0 12px 28px rgba(139, 92, 246, .45);
        }

        .brand-name { font-size: 17px; font-weight: 800; }

        .brand-name small {
            display: block;
            font-size: 10px; font-weight: 600;
            letter-spacing: .22em; text-transform: uppercase;
            color: rgba(255, 255, 255, .55);
            margin-top: 3px;
        }

        h1 {
            margin: 30px 0 8px;
            font-size: clamp(26px, 3vw, 32px);
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -.02em;
        }

        h1 span {
            background: linear-gradient(90deg, #c4b5fd, #f0abfc);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .intro { margin: 0 0 26px; font-size: 13.5px; line-height: 1.65; color: rgba(255, 255, 255, .62); }

        /* ===== Input ===== */
        .field-label {
            display: block; margin-bottom: 8px;
            font-size: 12px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: rgba(255, 255, 255, .66);
        }

        .input-wrap { position: relative; }

        .input-wrap > i {
            position: absolute; top: 50%; left: 16px;
            transform: translateY(-50%);
            font-size: 16px; color: rgba(255, 255, 255, .4);
            pointer-events: none;
            transition: color .2s ease;
        }

        .input-wrap:focus-within > i { color: #c4b5fd; }

        .form-control {
            min-height: 50px;
            padding: 12px 16px 12px 46px;
            border: 1.5px solid var(--line);
            border-radius: 14px;
            background: rgba(255, 255, 255, .06);
            color: #fff;
            font-family: inherit;
            font-size: 14.5px;
            box-shadow: none;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }

        .form-control::placeholder { color: rgba(255, 255, 255, .35); }

        .form-control:focus {
            border-color: #a78bfa;
            background: rgba(255, 255, 255, .1);
            box-shadow: 0 0 0 4px rgba(139, 92, 246, .22);
            color: #fff;
        }

        .form-control:-webkit-autofill { -webkit-text-fill-color: #fff; -webkit-box-shadow: 0 0 0 1000px #2a2050 inset; transition: background-color 9999s ease-out; }

        .form-control.is-invalid { border-color: #fb7185; background-image: none; }

        .password-wrap .form-control { padding-right: 50px; }

        .password-toggle {
            position: absolute; top: 50%; right: 8px;
            transform: translateY(-50%);
            width: 36px; height: 36px;
            display: grid; place-items: center;
            border: 0; border-radius: 10px;
            background: transparent;
            color: rgba(255, 255, 255, .45);
            transition: color .2s ease, background .2s ease;
        }

        .password-toggle:hover { color: #fff; background: rgba(255, 255, 255, .1); }

        .field-error {
            display: flex; align-items: center; gap: 6px;
            margin-top: 7px;
            font-size: 12.5px; font-weight: 600;
            color: #fda4af;
        }

        .capslock-hint {
            display: none;
            align-items: center; gap: 6px;
            margin-top: 7px;
            font-size: 12.5px; font-weight: 600;
            color: #fcd34d;
        }

        .capslock-hint.show { display: flex; }

        /* ===== Role switch ===== */
        .role-switch {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            padding: 6px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .06);
            border: 1.5px solid var(--line);
        }

        .role-switch input { display: none; }

        .role-option {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 42px; margin: 0;
            border-radius: 10px;
            font-size: 13.5px; font-weight: 700;
            color: rgba(255, 255, 255, .6);
            cursor: pointer;
            transition: all .2s ease;
        }

        .role-option:hover { color: #fff; }

        .role-switch input:checked + .role-option {
            background: linear-gradient(135deg, #8b5cf6, #a855f7);
            color: #fff;
            box-shadow: 0 8px 20px rgba(139, 92, 246, .4);
        }

        /* ===== Opsi & tombol ===== */
        .form-options { margin: 16px 0 22px; }

        .remember {
            display: flex; align-items: center; gap: 9px;
            margin: 0;
            font-size: 13.5px; font-weight: 600;
            color: rgba(255, 255, 255, .66);
            cursor: pointer;
        }

        .remember input { width: 18px; height: 18px; margin: 0; accent-color: #8b5cf6; cursor: pointer; }

        .btn-login {
            display: inline-flex; align-items: center; justify-content: center; gap: 10px;
            min-height: 54px;
            border: 0; border-radius: 14px;
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 55%, #d946ef 100%);
            color: #fff;
            font-family: inherit;
            font-size: 15px; font-weight: 800;
            letter-spacing: .01em;
            box-shadow: 0 16px 36px rgba(139, 92, 246, .42);
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .btn-login i { transition: transform .18s ease; }

        .btn-login:hover {
            color: #fff;
            transform: translateY(-2px);
            filter: brightness(1.07);
            box-shadow: 0 20px 44px rgba(168, 85, 247, .5);
        }

        .btn-login:hover i { transform: translateX(3px); }
        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: .75; box-shadow: none; }

        /* ===== Alert & footer ===== */
        .alert-glass {
            display: flex; align-items: flex-start; gap: 10px;
            margin: 0 0 20px; padding: 12px 16px;
            border-radius: 13px;
            border: 1px solid transparent;
            font-size: 13.5px; font-weight: 600; line-height: 1.5;
        }

        .alert-glass i { margin-top: 1px; }
        .alert-glass.alert-success { background: rgba(16, 185, 129, .14); border-color: rgba(52, 211, 153, .35); color: #6ee7b7; }
        .alert-glass.alert-danger { background: rgba(244, 63, 94, .14); border-color: rgba(251, 113, 133, .35); color: #fda4af; }

        .register-hint { margin: 24px 0 0; text-align: center; font-size: 13.5px; color: rgba(255, 255, 255, .6); }
        .register-link { color: #d8b4fe; font-weight: 800; text-decoration: none; }
        .register-link:hover { color: #f0abfc; text-decoration: underline; }

        .page-footer { margin: 22px 0 0; font-size: 12px; color: rgba(255, 255, 255, .35); text-align: center; }
    </style>
</head>
<body>
<div class="bg"></div>
<div class="dots"></div>
<span class="orb orb-1"></span>
<span class="orb orb-2"></span>
<span class="orb orb-3"></span>

<div class="ficon ficon-1"><i class="bi bi-book"></i></div>
<div class="ficon ficon-2"><i class="bi bi-journal-bookmark"></i></div>
<div class="ficon ficon-3"><i class="bi bi-mortarboard"></i></div>
<div class="ficon ficon-4"><i class="bi bi-bookmark-star"></i></div>

<main class="card-login">
    <div class="brand">
        <div class="brand-badge"><i class="bi bi-book-half"></i></div>
        <div class="brand-name">Perpustakaan<small>Sistem Informasi</small></div>
    </div>

    <h1>Selamat datang<br><span>kembali.</span></h1>
    <p class="intro">Masuk untuk melanjutkan pengelolaan perpustakaan Anda.</p>

    @if (session('success'))
        <div class="alert-glass alert-success" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-glass alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="mb-3">
            <label for="email" class="field-label">Email</label>
            <div class="input-wrap">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" value="{{ old('email') }}" autocomplete="email" required autofocus>
            </div>
            @error('email')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="field-label">Password</label>
            <div class="input-wrap password-wrap">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" autocomplete="current-password" required>
                <button type="button" class="password-toggle" id="passwordToggle" aria-label="Tampilkan password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="capslock-hint" id="capslockHint"><i class="bi bi-exclamation-triangle"></i>Caps Lock aktif</div>
            @error('password')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <span class="field-label">Masuk sebagai</span>
            <div class="role-switch" role="radiogroup" aria-label="Masuk sebagai">
                <input type="radio" name="role" id="roleAnggota" value="anggota" {{ old('role', 'anggota') === 'anggota' ? 'checked' : '' }}>
                <label class="role-option" for="roleAnggota"><i class="bi bi-person"></i> Anggota</label>
                <input type="radio" name="role" id="roleAdmin" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                <label class="role-option" for="roleAdmin"><i class="bi bi-shield-lock"></i> Admin</label>
            </div>
            @error('role')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-options">
            <label class="remember" for="remember">
                <input type="checkbox" name="remember" id="remember">
                <span>Ingat saya</span>
            </label>
        </div>

        <button type="submit" class="btn btn-login w-100" id="loginBtn">
            <span>Masuk ke akun</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </form>

    <p class="register-hint">Belum punya akun? <a href="{{ route('register') }}" class="register-link">Daftar sekarang</a></p>
</main>

<p class="page-footer">&copy; {{ date('Y') }} Perpustakaan &mdash; Sistem Informasi Perpustakaan</p>

<script>
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.getElementById('passwordToggle');

    passwordToggle.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        passwordToggle.innerHTML = `<i class="bi bi-eye${isPassword ? '-slash' : ''}"></i>`;
        passwordToggle.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
    });

    const capslockHint = document.getElementById('capslockHint');
    passwordInput.addEventListener('keyup', (e) => {
        if (e.getModifierState) {
            capslockHint.classList.toggle('show', e.getModifierState('CapsLock'));
        }
    });
    passwordInput.addEventListener('blur', () => capslockHint.classList.remove('show'));

    document.getElementById('loginForm').addEventListener('submit', () => {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>Memproses&hellip;</span>';
    });
</script>
</body>
</html>