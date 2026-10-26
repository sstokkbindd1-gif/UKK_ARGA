<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun admin bawaan supaya aplikasi selalu bisa dimasuki setelah
        // instalasi baru. firstOrCreate mencegah duplikasi bila akun sudah ada.
        User::firstOrCreate(
            ['email' => 'admin@perpustakaan.test'],
            [
                'name'     => 'Administrator',
                'password' => 'password', // minimal 8 karakter; ganti setelah login lewat menu Pengaturan
                'role'     => 'admin',
                'status'   => 'aktif',
            ]
        );
    }
}
