<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $bukuDipinjam = Transaksi::where('status', 'dipinjam')->count();
        $pengembalianAktif = Transaksi::where('status', 'dipinjam')
            ->with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();
        $pengembalianTerbaru = Transaksi::where('status', 'dikembalikan')
            ->with(['anggota', 'buku'])
            ->latest('tanggal_kembali')
            ->take(5)
            ->get();

        return view('home', compact(
            'totalBuku',
            'totalAnggota',
            'bukuDipinjam',
            'pengembalianAktif',
            'pengembalianTerbaru'
        ));
    })->middleware('admin')->name('dashboard');

    /*
    | Semua area di bawah ini hanya untuk admin. Anggota yang mencoba
    | mengaksesnya akan diarahkan ke dashboard miliknya (middleware AdminOnly).
    */
    Route::middleware('admin')->group(function () {
        Route::resource('buku', BukuController::class);
        Route::resource('anggota', AnggotaController::class);
        Route::resource('transaksi', TransaksiController::class);

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/print', [ReportController::class, 'print'])->name('print');
        });

        /* ================= PENGATURAN ================= */
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan/info', [PengaturanController::class, 'updateInfo'])->name('pengaturan.info');
        Route::post('/pengaturan/sirkulasi', [PengaturanController::class, 'updateSirkulasi'])->name('pengaturan.sirkulasi');
        Route::post('/pengaturan/akun', [PengaturanController::class, 'updateAkun'])->name('pengaturan.akun');

        /*
        | "history" wajib didaftar sebelum "/{id}" dan parameter {id} dibatasi
        | angka, supaya URL /pengembalian/history tidak tertangkap route {id}.
        */
        Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
            Route::get('/', [PengembalianController::class, 'index'])->name('index');
            Route::get('/history', [PengembalianController::class, 'history'])->name('history');
            Route::get('/{id}/create', [PengembalianController::class, 'create'])->name('create')->whereNumber('id');
            Route::post('/{id}', [PengembalianController::class, 'store'])->name('store')->whereNumber('id');
            Route::get('/{id}', [PengembalianController::class, 'show'])->name('show')->whereNumber('id');
        });
    });

    /* ================= DASHBOARD USER ================= */
    Route::prefix('user')
        ->name('user.')
        ->middleware('anggota')
        ->group(function () {
            // Halaman utama dashboard user
            Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

            // Katalog & pencarian buku
            Route::get('/katalog', [UserController::class, 'katalog'])->name('katalog');

            // Detail buku
            Route::get('/buku/{id}', [UserController::class, 'detailBuku'])->name('buku.show');

            // Peminjaman
            Route::get('/peminjaman', [UserController::class, 'peminjaman'])->name('peminjaman.index');
            Route::post('/peminjaman', [UserController::class, 'peminjamanStore'])->name('peminjaman.store');

            // Pengembalian
            Route::get('/pengembalian', [UserController::class, 'pengembalian'])->name('pengembalian.index');
            Route::post('/pengembalian/{id}', [UserController::class, 'kembalikan'])->name('pengembalian.store');

            // History peminjaman
            Route::get('/history', [UserController::class, 'history'])->name('history');

            // Profil
            Route::get('/profil', [UserController::class, 'profil'])->name('profil');
            Route::put('/profil', [UserController::class, 'profilUpdate'])->name('profil.update');
        });
});