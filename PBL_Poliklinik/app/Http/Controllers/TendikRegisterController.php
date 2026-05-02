<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tendik;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TendikRegisterController extends Controller
{
    public function create()
    {
        $jabatan = \App\Models\JabatanTendik::all();

        return view('register.tendik', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'required|unique:tendik,nip',
            'no_hp' => 'required',
            'id_jabatan' => 'required|exists:jabatan_tendik,id_jabatan'
        ]);

        DB::beginTransaction();

        try {
            $role = Role::where('nama_role', 'tendik')->first();

            $user = User::create([
                'id_role' => $role->id_role,
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            Tendik::create([
                'id_user' => $user->id_user,
                'id_jabatan' => $request->id_jabatan,
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