<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ubah kolom jumlah_stok dari VARCHAR menjadi integer agar perhitungan
     * stok aman. Migration ini hanya berjalan saat "php artisan migrate"
     * dijalankan; data yang sudah ada diubah menjadi 0 bila bukan angka.
     */
    public function up(): void
    {
        // Bersihkan nilai non-angka supaya konversi tipe tidak gagal.
        DB::statement("UPDATE buku SET jumlah_stok = '0' WHERE jumlah_stok IS NULL OR jumlah_stok = '' OR jumlah_stok NOT REGEXP '^[0-9]+$'");

        DB::statement('ALTER TABLE buku MODIFY jumlah_stok INT UNSIGNED NOT NULL DEFAULT 0');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE buku MODIFY jumlah_stok VARCHAR(255) NULL');
    }
};