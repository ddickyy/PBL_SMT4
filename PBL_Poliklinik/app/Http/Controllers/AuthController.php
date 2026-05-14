<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->id_role) {

                // Dokter
                case 3:
                    return redirect()->route('dokter.beranda');

                    // Pasien
                case 4:
                    return redirect()->route('pasien.beranda');

                    // Admin & Superadmin tidak boleh login di sini
                case 1:
                case 2:

                    Auth::logout();

                    return redirect()->route('login')
                        ->withErrors([
                            'email' => 'Silakan login melalui panel admin.'
                        ]);

                default:

                    Auth::logout();

                    return back()->withErrors([
                        'email' => 'Role tidak dikenali.'
                    ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ]);
    }
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
