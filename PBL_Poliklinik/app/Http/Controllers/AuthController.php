<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // PAGE LOGIN
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        // VALIDASI
        $credentials = $request->validate([
            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required'
            ],

        ]);
        // REMEMBER ME
        $remember =
            $request->has('remember');

        // LOGIN
        if (
            Auth::attempt(
                $credentials,
                $remember
            )
        ) {
            // REGENERATE SESSION
            $request->session()->regenerate();
            // USER LOGIN
            $user = Auth::user();
            switch ($user->id_role) {
                case 1:
                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([

                            'email' =>
                            'Silakan login melalui panel admin.'

                        ]);
                case 2:
                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([

                            'email' =>
                            'Silakan login melalui panel admin.'

                        ]);
                case 3:
                    return redirect()
                        ->route('dokter.beranda');

                case 4:

                    return redirect()
                        ->route('pasien.beranda');

                    // Role tidak dikenali
                default:

                    Auth::logout();

                    return redirect()
                        ->route('login')
                        ->withErrors([

                            'email' =>
                            'Role user tidak dikenali.'

                        ]);
            }
        }

        // LOGIN GAGAL
        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([

                'email' =>
                'Email atau password salah.'

            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }
}