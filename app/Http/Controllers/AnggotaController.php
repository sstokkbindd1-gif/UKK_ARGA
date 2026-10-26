<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    /**
     * Menampilkan semua anggota
     */
    public function index()
    {
        $anggota = Anggota::with('user')
            ->latest()
            ->get();

        return view('anggota.index', compact('anggota'));
    }


    /**
     * Form tambah anggota
     */
    public function create()
    {
        return view('anggota.create');
    }


    /**
     * Menyimpan anggota
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|unique:anggota,nis',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:255',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        DB::transaction(function () use ($request) {
            // Buat akun login untuk anggota baru (role anggota, status aktif).
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => $request->password, // otomatis di-hash lewat cast model User
                'role' => 'anggota',
                'status' => 'aktif',
            ]);

            Anggota::create([
                'id_user' => $user->id,
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'kelas' => $request->kelas,
            ]);
        });

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota beserta akun login berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail anggota
     */
    public function show(string $id)
    {
        $anggota = Anggota::with('user')
            ->findOrFail($id);

        return view('anggota.show', compact('anggota'));
    }


    /**
     * Form edit anggota
     */
    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $users = User::all();

        return view('anggota.edit', compact('anggota', 'users'));
    }


    /**
     * Update anggota
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'id_user' => 'required|exists:users,id',

            'nis' => [
                'required',
                Rule::unique('anggota', 'nis')
                    ->ignore($anggota->id_anggota, 'id_anggota'),
            ],

            'nama_lengkap' => 'required',
            'alamat' => 'nullable',
            'kelas' => 'nullable',
        ], [
            'id_user.required' => 'User wajib dipilih.',
            'id_user.exists' => 'User tidak ditemukan.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        $anggota->update([
            'id_user' => $request->id_user,
            'nis' => $request->nis,
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'kelas' => $request->kelas,
        ]);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }


    /**
     * Hapus anggota
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}