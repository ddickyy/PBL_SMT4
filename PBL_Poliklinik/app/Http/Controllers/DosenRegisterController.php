<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
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
        $data = $request->validate([
            'nidn' => ['required', 'string', 'max:30', 'unique:dosen,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'telepon' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'id_role' => 4, // pasien
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'foto' => null,
            ]);

            Dosen::create([
                'id_user' => $user->id_user,
                'nip' => $data['nidn'],
                'no_hp' => $data['telepon'],
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran dosen berhasil. Silakan login.');
    }
}