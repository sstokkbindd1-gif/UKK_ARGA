<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Dashboard hanya dapat diakses oleh admin.',
            ]);
        }

        // Pengguna biasa (anggota) diarahkan ke dashboard miliknya,
        // supaya tidak terjadi redirect berulang menuju halaman login.
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
