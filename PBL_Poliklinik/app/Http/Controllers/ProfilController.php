<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // SHOW PROFILE
    public function show()
    {
        $user = User::with([
            'mahasiswa.prodi',
            'dosen',
            'tendik.jabatan',
        ])->findOrFail(Auth::id());

        return view('pasien.profil.show', compact('user'));
    }

    // EDIT PROFILE
    public function edit()
    {
        $user = User::with([
            'mahasiswa.prodi',
            'dosen',
            'tendik.jabatan',
        ])->findOrFail(Auth::id());

        return view('pasien.profil.edit', compact('user'));
    }

    // UPDATE PROFILE
    public function update(Request $request)
    {
        $user = User::with([
            'mahasiswa',
            'dosen',
            'tendik',
        ])->findOrFail(Auth::id());

        // VALIDASI
        $validated = $request->validate([
            'nama' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',

            'no_hp' => 'nullable|string|max:20',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'password' => 'nullable|min:8|confirmed',
        ]);

        // UPDATE USER
        $user->nama = $validated['nama'];

        $user->email = $validated['email'];

        // FOTO PROFIL
        if ($request->hasFile('foto')) {

            $path = $request->file('foto')
                ->store('foto-profil', 'public');

            $user->foto = $path;
        }

        // UPDATE PASSWORD
        if ($request->filled('password')) {

            $user->password = bcrypt($request->password);
        }

        $user->save();

        // UPDATE MAHASISWA
        if ($user->mahasiswa) {

            $user->mahasiswa->update([
                'no_hp' => $validated['no_hp'],
            ]);
        }

        // UPDATE DOSEN
        if ($user->dosen) {

            $user->dosen->update([
                'no_hp' => $validated['no_hp'],
            ]);
        }

        // UPDATE TENDIK
        if ($user->tendik) {

            $user->tendik->update([
                'no_hp' => $validated['no_hp'],
            ]);
        }

        return redirect()
            ->route('pasien.profil.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}