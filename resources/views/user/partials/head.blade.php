<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }} - Perpustakaan Sekolah</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #f5f6fc;
            font-family: Arial, Helvetica, sans-serif;
            color: #292b42;
            line-height: 1.6;
        }

        /* =========================
           LAYOUT
        ========================= */
        .container-user {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding-left: 16px;
            padding-right: 16px;
        }

        /* =========================
           NAVBAR USER
        ========================= */
        .navbar-user {
            background: #ffffff;
            border-bottom: 1px solid #ececf5;
        }

        .navbar-user .brand-sec {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            font-size: 19px;
            font-weight: bold;

            color: #33364d;
        }

        .navbar-user .brand-sec i {
            color: #6574ee;
            font-size: 24px;
        }

        .navbar-user .nav-link {
            padding: .45rem .85rem;
            border-radius: 8px;

            color: #77798b;
            font-size: 14px;
        }

        .navbar-user .nav-link:hover,
        .navbar-user .nav-link.active {
            background: #eef0ff;
            color: #5d6be8;
        }

        .navbar-toggler { border-color: #d8d9ea; }

        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 6px 13px;
            border-radius: 999px;

            background: #f1f2fb;
            color: #33364d;
            font-size: 14px;
        }

        .user-chip i {
            color: #6574ee;
            font-size: 17px;
        }

        /* =========================
           KOMPONEN DASBOR
        ========================= */
        .stat-card {
            display: flex;
            align-items: center;
            gap: 16px;

            height: 100%;
            padding: 22px;

            background: #ffffff;
            border: 1px solid #efeff8;
            border-radius: 15px;
        }

        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 54px;
            height: 54px;
            border-radius: 12px;
            flex-shrink: 0;

            background: #eef0ff;
            color: #6574ee;
            font-size: 23px;
        }

        .stat-number {
            font-size: 26px;
            font-weight: bold;
            line-height: 1.1;
        }

        .stat-text {
            margin-top: 2px;

            color: #8a8ba3;
            font-size: 13px;
        }

        .card-section {
            background: #ffffff;
            border: 1px solid #efeff8;
            border-radius: 15px;
        }

        .section-title { font-size: 18px; font-weight: bold; }

        .page-title { font-size: 24px; font-weight: bold; }

        .text-muted-2 { color: #8a8ba3 !important; }

        /* =========================
           COVER BUKU
        ========================= */
        .book-cover {
            display: block;
            width: 100%;
            aspect-ratio: 3 / 4;
            object-fit: cover;
            border-radius: 10px;
            background: #eef0ff;
        }

        .book-cover-fallback {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            aspect-ratio: 3 / 4;
            border-radius: 10px;

            background: #eef0ff;
            color: #6574ee;
            font-size: 44px;
        }

        .cover-sm,
        .cover-fallback-sm {
            width: 56px;
            height: 76px;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .cover-sm { object-fit: cover; background: #eef0ff; }

        .cover-fallback-sm {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef0ff;
            color: #6574ee;
            font-size: 26px;
        }

        /* =========================
           BADGE SOFT
        ========================= */
        .badge-soft {
            padding: .42em .78em;
            border-radius: 50rem;
            font-size: 12.5px;
            font-weight: normal;
        }

        .badge-soft-success { background: #e6f7ec; color: #1f7a46; }
        .badge-soft-danger  { background: #fdeaea; color: #b02a37; }
        .badge-soft-info    { background: #eef0ff; color: #4552d9; }
        .badge-soft-warn    { background: #fff6e0; color: #a37200; }
        .badge-soft-muted   { background: #f1f2fb; color: #77798b; }

        /* TOMBOL UTAMA MENGIKUTI TEMA ADMIN */
        .btn-primary { background: #6574ee; border: none; color: #fff; }
        .btn-primary:hover,
        .btn-primary:focus { background: #5665df; border: none; color: #fff; }
        .btn-primary:disabled { background: #b9c0f5; border: none; color: #fff; }

        .search-input {
            min-height: 48px;
            border-color: #e3e3f0;
            border-radius: 10px;
        }

        .search-input:focus {
            border-color: #6574ee;
            box-shadow: 0 0 0 3px rgba(101, 116, 238, .12);
        }

        /* =========================
           FOOTER
        ========================= */
        footer.user-footer {
            margin-top: auto;
            padding: 26px 0 18px;

            background: #ffffff;
            border-top: 1px solid #ececf5;
            color: #77798b;
            font-size: 13.5px;
        }

        @media (max-width: 991.98px) {
            .navbar-collapse { padding-top: 12px; }
            .navbar-nav { gap: 2px; }
        }
    </style>

