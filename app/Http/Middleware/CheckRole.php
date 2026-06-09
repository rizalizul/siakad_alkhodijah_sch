<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek apakah role pengguna ada di dalam daftar role yang diizinkan
        $user = Auth::user();
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak diizinkan, kembalikan halaman 403 (Forbidden)
        abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
    }
}