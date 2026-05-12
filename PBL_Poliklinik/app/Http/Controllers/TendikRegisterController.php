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
        return view('register.tendik');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => ['required', 'string', 'max:30', 'unique:tendik,nip'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'jabatan' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed'],
            'telepon' => ['required', 'string', 'max:20'],
        ]);

        $jabatan = JabatanTendik::where('nama_jabatan', $data['jabatan'])->first();

        if (!$jabatan) {
            return back()
                ->withErrors(['jabatan' => 'Jabatan tidak ditemukan.'])
                ->withInput();
        }

        DB::transaction(function () use ($data, $jabatan) {
            $user = User::create([
                'id_role' => 4, // pasien
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'foto' => null,
            ]);

            Tendik::create([
                'id_user' => $user->id_user,
                'id_jabatan' => $jabatan->id_jabatan,
                'nip' => $data['nip'],
                'no_hp' => $data['telepon'],
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran tendik berhasil. Silakan login.');
    }
}