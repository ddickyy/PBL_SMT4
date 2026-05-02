<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenRegisterController extends Controller
{
    public function create()
    {
        return view('register.dosen');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'required|unique:dosen,nip',
            'no_hp' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $role = Role::where('nama_role', 'dosen')->first();

            $user = User::create([
                'id_role' => $role->id_role,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            Dosen::create([
                'id_user' => $user->id_user,
                'nip' => $request->nip,
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