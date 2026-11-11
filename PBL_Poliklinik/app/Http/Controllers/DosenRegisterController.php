<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenRegisterController extends Controller
{
    public function create()
    {
        $jurusan = Jurusan::all();
        return view('register.dosen', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nidn' => ['required', 'string', 'max:30', 'unique:dosen,nidn'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:5', 'confirmed'],
            'no_hp' => ['required', 'string', 'max:20'],
            'id_jurusan' => ['required', 'exists:jurusan,id_jurusan'],
        ]);

        DB::beginTransaction();

        try {
            $role = Role::where('nama_role', 'pasien')->firstOrFail();

            $user = User::create([
                'id_role' => $role->id_role,
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            Dosen::create([
                'id_user' => $user->id_user,
                'id_jurusan' => $data['id_jurusan'],
                'nidn' => $data['nidn'],
                'no_hp' => $data['no_hp'],
            ]);

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi dosen berhasil. Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Registrasi gagal: ' . $e->getMessage(),
                ]);
        }
    }
}