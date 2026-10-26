<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    /**
     * Halaman pengaturan aplikasi.
     */
    public function index()
    {
        $pengaturan = [
            'nama_perpustakaan'  => Setting::get('nama_perpustakaan', 'Perpustakaan'),
            'alamat'             => Setting::get('alamat', ''),
            'telepon'            => Setting::get('telepon', ''),
            'email_perpustakaan' => Setting::get('email_perpustakaan', ''),
            'lama_pinjam_hari'   => Setting::get('lama_pinjam_hari', 7),
            'denda_per_hari'     => Setting::get('denda_per_hari', 1000),
            'maks_pinjam'        => Setting::get('maks_pinjam', 3),
        ];

        return view('Pengaturan.index', compact('pengaturan'));
    }

    /**
     * Simpan informasi perpustakaan.
     */
    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'nama_perpustakaan'  => 'required|string|max:255',
            'alamat'             => 'nullable|string|max:500',
            'telepon'            => 'nullable|string|max:25',
            'email_perpustakaan' => 'nullable|email|max:255',
        ]);

        foreach ($data as $kunci => $nilai) {
            Setting::set($kunci, $nilai);
        }

        return back()->with('success', 'Informasi perpustakaan berhasil disimpan.');
    }

    /**
     * Simpan aturan sirkulasi (durasi pinjam, denda, batas pinjam).
     */
    public function updateSirkulasi(Request $request)
    {
        $data = $request->validate([
            'lama_pinjam_hari' => 'required|integer|min:1|max:90',
            'denda_per_hari'   => 'required|integer|min:0|max:100000',
            'maks_pinjam'      => 'required|integer|min:1|max:10',
        ]);

        foreach ($data as $kunci => $nilai) {
            Setting::set($kunci, (string) $nilai);
        }

        return back()->with('success', 'Aturan sirkulasi berhasil disimpan.');
    }

    /**
     * Perbarui profil akun admin yang sedang login.
     */
    public function updateAkun(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = $data['password']; // otomatis di-hash lewat cast model User
        }

        $user->save();

        return back()->with('success', 'Profil akun berhasil diperbarui.');
    }
}