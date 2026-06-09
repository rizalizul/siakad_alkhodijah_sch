<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrtuAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('siswa_id')) {
            // Jika tidak ada sesi siswa, redirect ke halaman login orang tua
            return redirect()->route('ortu.login.form');
        }
        return $next($request);
    }
}