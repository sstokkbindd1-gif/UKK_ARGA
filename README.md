# 📚 UKK_ARGA — Sistem Informasi Perpustakaan Digital

**Aplikasi Perpustakaan Digital** merupakan aplikasi berbasis web yang dikembangkan untuk membantu pengelolaan perpustakaan secara lebih efektif, terstruktur, dan efisien.

Proyek ini dibuat sebagai bagian dari kegiatan **Uji Kompetensi Keahlian (UKK) PPLG** dengan tujuan menerapkan kemampuan pengembangan aplikasi web menggunakan Laravel dan pengelolaan database MySQL.

---

## 🌐 Demo Website

🔗 1. Link website:perpusarga.site.je
2. Link erd :https://drive.google.com/file/d/1jbTLiEFQRLkhAE3qTZijiv7_OctKdGT_/view?usp=drive_link
3. Link github repository :
4. Link io

## 📖 Tentang Aplikasi

UKK_ARGA adalah sistem informasi perpustakaan yang dirancang untuk mempermudah petugas dalam mengelola aktivitas perpustakaan, mulai dari pengelolaan koleksi buku, data anggota, transaksi peminjaman, hingga pengembalian buku.

Aplikasi ini memiliki tampilan yang sederhana, modern, dan mudah digunakan sehingga dapat membantu proses administrasi perpustakaan menjadi lebih praktis.

## ✨ Fitur Utama

### 1. Dashboard
- Menampilkan ringkasan informasi perpustakaan.
- Menampilkan jumlah buku.
- Menampilkan jumlah anggota.
- Menampilkan informasi transaksi perpustakaan.

### 2. Manajemen Data Buku
- Menambahkan data buku.
- Melihat daftar buku.
- Mengubah informasi buku.
- Menghapus data buku.
- Mengelola stok dan kategori buku.
- Menambahkan foto cover buku.

### 3. Manajemen Data Anggota
- Menambahkan anggota baru.
- Melihat data anggota.
- Mengubah data anggota.
- Menghapus data anggota.

### 4. Peminjaman Buku
- Mengelola transaksi peminjaman.
- Mencatat data peminjam.
- Mencatat tanggal peminjaman.
- Mengelola status peminjaman.

### 5. Pengembalian Buku
- Mencatat pengembalian buku.
- Memantau tanggal pengembalian.
- Mengelola status pengembalian.

### 6. Riwayat Peminjaman
- Melihat riwayat transaksi.
- Memantau aktivitas peminjaman anggota.

### 7. Laporan
- Menyediakan informasi transaksi perpustakaan.
- Membantu petugas memantau aktivitas perpustakaan.

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP | Bahasa pemrograman backend |
| Laravel | Framework pengembangan aplikasi |
| MySQL | Sistem manajemen database |
| HTML5 | Struktur halaman web |
| CSS3 | Mengatur tampilan website |
| Bootstrap 5 | Framework desain antarmuka |
| JavaScript | Interaksi pada halaman web |
| Git & GitHub | Pengelolaan dan penyimpanan kode |

---

## 🗄️ Database dan Perancangan Sistem

Perancangan database dan alur sistem dibuat untuk memberikan gambaran mengenai hubungan antar-data serta proses kerja aplikasi.

### 1. Entity Relationship Diagram (ERD)

ERD digunakan untuk menggambarkan hubungan antar-entitas dalam database aplikasi perpustakaan.

📌 **Dokumentasi ERD:**

`docs/ERD.png`

![Entity Relationship Diagram](docs/ERD.png)

### 2. Flowchart Sistem

Flowchart digunakan untuk menggambarkan alur proses kerja aplikasi, mulai dari login, pengelolaan data buku, transaksi peminjaman, hingga pengembalian buku.

📌 **Dokumentasi Flowchart:**

`docs/Flowchart.png`

![Flowchart Sistem](docs/Flowchart.png)

---

## 📂 Struktur Proyek

Struktur umum aplikasi Laravel:

```text
UKK_ARGA/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
│
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
│
├── docs/
│   ├── ERD.png
│   └── Flowchart.png
│
├── public/
│   ├── css/
│   ├── js/
│   └── storage/
│
├── resources/
│   └── views/
│
├── routes/
│   └── web.php
│
├── storage/
├── .env.example
├── artisan
├── composer.json
└── README.md
```

---

## ⚙️ Instalasi dan Menjalankan Project

Jika ingin menjalankan aplikasi Laravel secara lokal, ikuti langkah berikut.

### 1. Clone Repository

```bash
git clone https://github.com/sstokkbindd1-gif/UKK_ARGA.git
```

### 2. Masuk ke Folder Project

```bash
cd UKK_ARGA
```

### 3. Install Dependency

```bash
composer install
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

Untuk Windows, file `.env.example` juga dapat disalin secara manual menjadi `.env`.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Sesuaikan konfigurasi database pada file `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

Jika project menyediakan seeder, jalankan:

```bash
php artisan db:seed
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses:

```text
http://127.0.0.1:8000
```

---

## 🎯 Tujuan Pengembangan

Pengembangan aplikasi ini memiliki beberapa tujuan:

1. Mempermudah pengelolaan data buku dan anggota perpustakaan.
2. Membantu pencatatan transaksi peminjaman dan pengembalian.
3. Mengurangi kesalahan dalam pencatatan data.
4. Meningkatkan efisiensi administrasi perpustakaan.
5. Menerapkan ilmu pemrograman web yang telah dipelajari selama pendidikan PPLG.

---

## 👨‍💻 Pengembang

**Nama Project:** UKK_ARGA  
**Kategori:** Sistem Informasi Perpustakaan  
**Jenis Project:** Web Application  
**Bidang Keahlian:** Pengembangan Perangkat Lunak dan Gim (PPLG)  
**Framework:** Laravel  
**Database:** MySQL  

---

## 📌 Status Project

Project ini dikembangkan sebagai bagian dari Uji Kompetensi Keahlian (UKK) PPLG.

**© 2026 UKK_ARGA — Aplikasi Perpustakaan Digital.**
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
