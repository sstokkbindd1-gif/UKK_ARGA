<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,anggota'],
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('role', $credentials['role'])
            ->where('status', 'aktif')
            ->first();

        $passwordValid = false;
        if ($user) {
            $storedPassword = $user->getRawOriginal('password');

            try {
                $passwordValid = Hash::check($credentials['password'], $storedPassword);
            } catch (\RuntimeException $exception) {
                if (hash_equals((string) $storedPassword, $credentials['password'])) {
                    DB::table('users')->where('id', $user->id)->update([
                        'password' => Hash::make($credentials['password']),
                        'updated_at' => now(),
                    ]);
                    $passwordValid = true;
                }
            }
        }

        if ($passwordValid) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Redirect sesuai role masing-masing akun.
            if ($user->role === 'admin') {
                return redirect()->intended('/');
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email, password, atau jenis akun tidak sesuai.',
        ])->onlyInput(['email', 'role']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nis' => ['required', 'string', 'max:255', 'unique:anggota,nis'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kelas' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'anggota',
                'status' => 'aktif',
            ]);

            Anggota::create([
                'id_user' => $user->id,
                'nis' => $data['nis'],
                'nama_lengkap' => $data['name'],
                'alamat' => $data['alamat'] ?? null,
                'kelas' => $data['kelas'] ?? null,
            ]);

            return $user;
        });

        return redirect()->route('login')->with('success', 'Akun anggota berhasil dibuat. Silakan masuk melalui akses User / Anggota.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
