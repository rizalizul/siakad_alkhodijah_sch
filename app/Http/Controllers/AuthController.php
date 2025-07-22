<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // return redirect()->intended('/dashboard');
            return redirect()->intended('/dashboard-superadmin');
        }

        return back()->withErrors(['login_error' => 'Email atau Kata Sandi salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
