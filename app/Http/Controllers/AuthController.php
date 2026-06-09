<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        // Jika pengguna sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    /**
     * Memproses data login dari form.
     */
    public function login(Request $request)
    {
        // Validasi input dari form login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba untuk melakukan otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika berhasil, redirect ke halaman dashboard
            return redirect()->intended('dashboard');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama atau halaman login
        return redirect('/');
    }
}