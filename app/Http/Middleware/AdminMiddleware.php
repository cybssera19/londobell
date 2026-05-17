<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login, dan apakah rolenya 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lolos! Silakan masuk ke halaman admin
        }

        // 2. Jika bukan admin, tendang balik ke halaman katalog user dengan pesan peringatan
        return redirect()->route('user.catalog')->with('error', 'Akses ditolak! Anda bukan Admin.');
    }
}
