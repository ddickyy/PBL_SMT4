<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tendik;
use App\Models\JabatanTendik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TendikRegisterController extends Controller
{
    public function create()
    {
        $jabatans = JabatanTendik::orderBy('nama_jabatan')->get();
        return view('register.tendik', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['required', 'string', 'max:30', 'unique:tendik,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'jabatan' => ['required', 'exists:jabatan_tendik,id_jabatan'],
            'password' => ['required', 'min:5', 'confirmed'],
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'id_role' => 4, // pasien
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'foto' => null,
            ]);

            Tendik::create([
                'id_user' => $user->id_user,
                'id_jabatan' => $data['jabatan'],
                'nip' => $data['nip'],
                'no_hp' => $data['no_hp'],
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran tendik berhasil. Silakan login.');
    }
}