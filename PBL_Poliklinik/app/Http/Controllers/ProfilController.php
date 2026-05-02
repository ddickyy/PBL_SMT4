<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        $user = User::with('mahasiswa.prodi.jurusan')->findOrFail(Auth::id());

        return view('patient.profil.show', compact('user'));
    }

    public function edit()
    {
        $user = User::with('mahasiswa')->findOrFail(Auth::id());
        $prodi = Prodi::all();

        return view('patient.profil.edit', compact('user', 'prodi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20',
            'id_prodi' => 'required|exists:prodi,id_prodi',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        if ($user->mahasiswa) {
            $user->mahasiswa->update([
                'no_hp' => $request->no_hp,
                'id_prodi' => $request->id_prodi,
            ]);
        }

        return redirect()->route('pasien.profil.show')
            ->with('success', 'Profil berhasil diperbarui');
    }
}