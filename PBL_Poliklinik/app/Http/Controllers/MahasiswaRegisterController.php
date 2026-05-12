<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Role;
use App\Models\Prodi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaRegisterController extends Controller
{
    public function create()
    {
        $prodi = Prodi::all();

        return view('register.mahasiswa', compact('prodi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nim' => 'required|string|max:30|unique:mahasiswa,nim',
            'no_hp' => 'required|string|max:20',
            'id_prodi' => 'required|exists:prodi,id_prodi',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::where('nama_role', 'pasien')->firstOrFail();

            $user = User::create([
                'id_role' => $role->id_role,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Mahasiswa::create([
                'id_user' => $user->id_user,
                'id_prodi' => $validated['id_prodi'],
                'nim' => $validated['nim'],
                'no_hp' => $validated['no_hp'],
            ]);

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi mahasiswa berhasil. Silakan login.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Registrasi gagal: ' . $e->getMessage()
                ]);
        }
    }
}