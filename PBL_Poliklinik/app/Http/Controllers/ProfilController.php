<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservasi;
use App\Models\RekamMedis;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // SHOW PROFILE
    public function show(Request $request)
    {
        $user = User::with([

            'mahasiswa.prodi',

            'dosen',

            'tendik.jabatan',

        ])->findOrFail(Auth::id());

        $aktivitasReservasi = Reservasi::with([

            'jadwal.dokter.user',

            'jadwal.dokter.spesialisasi'

        ])
        ->where(
            'id_user',
            Auth::id()
        )
        ->orderByRaw("
            CASE
                WHEN status IN ('menunggu', 'dikonfirmasi')
                THEN 0
                ELSE 1
            END
        ")
        ->latest('tanggal_reservasi')
        ->latest('created_at')
        ->paginate(4, ['*'], 'page_aktivitas')
        ->withQueryString();

        $rekamMedis = RekamMedis::with([
            'dokter.user',
            'dokter.spesialisasi',
            'reservasi'
        ])
        ->whereHas('reservasi', function ($query) {
            $query->where('id_user', Auth::id());
        })
        ->latest('tanggal_periksa')
        ->paginate(3, ['*'], 'page_rekam')
        ->withQueryString();

        return view(
            'pasien.profil.show',
            compact(
                'user',
                'rekamMedis',
                'aktivitasReservasi'
            )
        );
    }

    // EDIT PROFILE
    public function edit()
    {
        $user = User::with([

            'mahasiswa.prodi',

            'dosen',

            'tendik.jabatan',

        ])->findOrFail(Auth::id());

        return view(
            'pasien.profil.edit',
            compact('user')
        );
    }

    // UPDATE PROFILE
    public function update(Request $request)
    {
        $user = User::with([

            'mahasiswa',

            'dosen',

            'tendik',

        ])->findOrFail(Auth::id());

        $validated = $request->validate([

            'nama' =>
                'required|string|max:255',

            'email' =>
                'required|email|max:255|unique:users,email,' .
                $user->id_user .
                ',id_user',

            'no_hp' =>
                'nullable|string|max:20',

            'foto' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'password' =>
                'nullable|min:5|confirmed',

        ]);

        $user->nama = $validated['nama'];

        $user->email = $validated['email'];

        if ($request->hasFile('foto'))
        {
            $path = $request->file('foto')
                ->store(
                    'foto-profil',
                    'public'
                );

            $user->foto = $path;
        }

        if ($request->filled('password'))
        {
            $user->password =
                bcrypt($request->password);
        }

        $user->save();

        if ($user->mahasiswa)
        {
            $user->mahasiswa->update([

                'no_hp' =>
                    $validated['no_hp'],

            ]);
        }

        if ($user->dosen)
        {
            $user->dosen->update([

                'no_hp' =>
                    $validated['no_hp'],

            ]);
        }

        if ($user->tendik)
        {
            $user->tendik->update([

                'no_hp' =>
                    $validated['no_hp'],

            ]);
        }

        return redirect()
            ->route('pasien.profil.show')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }
}