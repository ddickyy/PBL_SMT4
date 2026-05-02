<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaRegisterController extends Controller
{
    public function create()
    {
        $prodi = \App\Models\Prodi::all();

        return view('register.mahasiswa', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nim' => 'required|unique:mahasiswa,nim',
            'no_hp' => 'required',
            'id_prodi' => 'required|exists:prodi,id_prodi'
        ]);

        DB::beginTransaction();

        try {
            $role = Role::where('nama_role', 'mahasiswa')->first();

            $user = User::create([
                'id_role' => $role->id_role,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            Mahasiswa::create([
                'id_user' => $user->id_user,
                'id_prodi' => $request->id_prodi,
                'nim' => $request->nim,
                'no_hp' => $request->no_hp
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Gagal daftar: ' . $e->getMessage());
        }
    }
}