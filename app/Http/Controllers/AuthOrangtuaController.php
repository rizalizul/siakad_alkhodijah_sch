<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class AuthOrangtuaController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_orangtua');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if ($siswa && $siswa->guardian) {
            Auth::guard('guardian')->login($siswa->guardian);
            return redirect()->intended('/dashboard-orangtua');
        }

        return back()->withErrors(['login_error' => 'NISN atau Tanggal Lahir salah']);
    }
}
