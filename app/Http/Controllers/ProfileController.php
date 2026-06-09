<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna yang sedang login.
     */
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Jika user adalah seorang guru, ambil juga data dari tabel guru
        $guru = $user->guru; 

        return view('admin.profile.show', compact('user', 'guru'));
    }

    /**
     * Memperbarui detail profil (nama, email, data guru).
     */
    public function updateDetails(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            // Validasi untuk data guru (jika ada)
            'nip' => 'nullable|string|max:255|unique:guru,nip,' . $user->guru?->id,
            'gelar' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        // Update tabel user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update tabel guru jika ada
        if ($user->guru) {
            $user->guru->update([
                'nip' => $request->nip,
                'gelar' => $request->gelar,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);
        }

        return back()->with('success_details', 'Detail profil berhasil diperbarui.');
    }

    /**
     * Memperbarui password pengguna.
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Password berhasil diubah.');
    }
}