<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class PengaturanLaporanTest extends TestCase
{
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Gunakan user admin tetap agar test idempotent (tanpa menghapus data lain).
        $this->admin = User::firstOrCreate(
            ['email' => 'test-admin@example.test'],
            [
                'name'     => 'Admin Test',
                'password' => 'password-rahasia',
                'role'     => 'admin',
                'status'   => 'aktif',
            ]
        );
    }

    protected function tearDown(): void
    {
        // Kembalikan aturan sirkulasi ke nilai default agar tidak mengubah data aplikasi.
        Setting::set('lama_pinjam_hari', '7');
        Setting::set('denda_per_hari', '1000');
        Setting::set('maks_pinjam', '3');

        parent::tearDown();
    }

    public function test_halaman_pengaturan_dan_laporan_bisa_diakses_admin(): void
    {
        $this->actingAs($this->admin);

        $this->get('/pengaturan')->assertOk();
        $this->get('/laporan')->assertOk();
        $this->get('/laporan/print')->assertOk();
    }

    public function test_laporan_bisa_difilter_periode_dan_status(): void
    {
        $this->actingAs($this->admin);

        $this->get('/laporan', [
            'dari'   => '2026-01-01',
            'sampai' => '2026-12-31',
            'status' => 'dipinjam',
        ])->assertOk();
    }

    public function test_aturan_sirkulasi_tersimpan_dan_dipakai(): void
    {
        $this->actingAs($this->admin);

        $this->post('/pengaturan/sirkulasi', [
            'lama_pinjam_hari' => 10,
            'denda_per_hari'   => 2000,
            'maks_pinjam'      => 5,
        ])->assertRedirect();

        $this->assertSame('10', Setting::get('lama_pinjam_hari'));
        $this->assertSame('2000', Setting::get('denda_per_hari'));
        $this->assertSame('5', Setting::get('maks_pinjam'));
    }

    public function test_informasi_perpustakaan_tersimpan(): void
    {
        $this->actingAs($this->admin);

        $this->post('/pengaturan/info', [
            'nama_perpustakaan'  => 'Perpustakaan Argaa',
            'alamat'             => 'Jl. Pendidikan No. 1',
            'telepon'            => '0761-123456',
            'email_perpustakaan' => 'info@perpus.test',
        ])->assertRedirect();

        $this->assertSame('Perpustakaan Argaa', Setting::get('nama_perpustakaan'));
        $this->assertSame('Jl. Pendidikan No. 1', Setting::get('alamat'));
    }

    public function test_validasi_aturan_sirkulasi_menolak_input_tidak_wajar(): void
    {
        $this->actingAs($this->admin);

        $this->from('/pengaturan')
            ->post('/pengaturan/sirkulasi', [
                'lama_pinjam_hari' => 0,   // harus minimal 1
                'denda_per_hari'   => -5,  // tidak boleh negatif
                'maks_pinjam'      => 99,  // maksimal 10
            ])
            ->assertSessionHasErrors(['lama_pinjam_hari', 'denda_per_hari', 'maks_pinjam']);
    }
}