<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function profil()
    {
        $dokterLayout = true;

        $dokter = Dokter::with([
            'user',
            'spesialisasi',
            'jadwalDokter'
        ])
            ->where(
                'id_user',
                Auth::user()->id_user
            )
            ->firstOrFail();

        $totalPasien = Reservasi::whereHas(
            'jadwal',
            function ($query) use ($dokter) {

                $query->where(
                    'id_dokter',
                    $dokter->id_dokter
                );
            }
        )->count();

        $pasienHariIni = Reservasi::whereHas(
            'jadwal',
            function ($query) use ($dokter) {

                $query->where(
                    'id_dokter',
                    $dokter->id_dokter
                );
            }
        )
            ->whereDate(
                'tanggal_reservasi',
                now()->toDateString()
            )
            ->count();

        return view(
            'dokter.profil.tampilan',
            compact(
                'dokter',
                'totalPasien',
                'pasienHariIni',
                'dokterLayout'
            )
        );
    }

    public function editProfil()
    {
        $dokterLayout = true;

        $dokter = Dokter::with([
            'user',
            'spesialisasi'
        ])
            ->where(
                'id_user',
                Auth::user()->id_user
            )
            ->firstOrFail();

        return view(
            'dokter.profil.edit',
            compact(
                'dokter',
                'dokterLayout'
            )
        );
    }

    public function updateProfil(Request $request)
    {
        $dokter = Dokter::with('user')
            ->where(
                'id_user',
                Auth::user()->id_user
            )
            ->firstOrFail();

        $validated = $request->validate([

            'nama' => 'required|string|max:255',

            'email' => 'required|email|max:255',

            'no_hp' => 'nullable|string|max:20',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ]);

        if ($request->hasFile('foto')) {

            $foto = $request->file('foto')
                ->store('foto-profil', 'public');

            $dokter->user->foto = $foto;
        }

        $dokter->user->nama = $validated['nama'];

        $dokter->user->email = $validated['email'];

        $dokter->no_hp = $validated['no_hp'];

        $dokter->user->save();

        $dokter->save();

        return redirect()
            ->route('dokter.profil')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }
    public function beranda()
    {
        $dokterLayout = true;

        $dokter = Dokter::with([
            'user',
            'spesialisasi',
            'jadwalDokter'
        ])
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();

        $reservasiHariIni = Reservasi::with([
            'user',
            'jadwal'
        ])
            ->whereHas('jadwal', function ($query) use ($dokter) {

                $query->where(
                    'id_dokter',
                    $dokter->id_dokter
                );
            })
            ->whereDate(
                'tanggal_reservasi',
                now()->toDateString()
            )
            ->whereIn('status', [
                'menunggu',
                'proses'
            ])
            ->orderBy('tanggal_reservasi')
            ->orderBy('estimasi_jam')
            ->get();

        $menunggu = $reservasiHariIni
            ->where('status', 'menunggu')
            ->count();

        $selesai = Reservasi::whereHas(
            'jadwal',
            function ($query) use ($dokter) {

                $query->where(
                    'id_dokter',
                    $dokter->id_dokter
                );
            }
        )
            ->whereDate(
                'tanggal_reservasi',
                now()->toDateString()
            )
            ->where('status', 'selesai')
            ->count();

        $jadwalList = $dokter->jadwalDokter;

        return view(
            'dokter.berandaDokter',
            compact(
                'dokter',
                'reservasiHariIni',
                'menunggu',
                'selesai',
                'jadwalList',
                'dokterLayout'
            )
        );
    }

    public function pasien()
    {
        $dokterLayout = true;

        $dokter = Dokter::where(
            'id_user',
            Auth::user()->id_user
        )->firstOrFail();

        $pasienList = Reservasi::with([
            'user',
            'jadwal'
        ])
            ->whereHas('jadwal', function ($query) use ($dokter) {

                $query->where(
                    'id_dokter',
                    $dokter->id_dokter
                );
            })
            ->latest()
            ->get();

        return view(
            'dokter.daftarPasien',
            compact(
                'pasienList',
                'dokterLayout'
            )
        );
    }

    public function detailPasien($id)
    {
        $dokterLayout = true;

        $pasien = Reservasi::with([
            'user',
            'jadwal.dokter.spesialisasi'
        ])
            ->findOrFail($id);

        return view(
            'dokter.detailPasien',
            compact(
                'pasien',
                'dokterLayout'
            )
        );
    }

    public function riwayat()
    {
        $dokterLayout = true;

        $dokter = Dokter::where(
            'id_user',
            Auth::user()->id_user
        )->firstOrFail();

        $riwayatList = Reservasi::with([
            'user',
            'jadwal'
        ])
            ->whereHas('jadwal', function ($query) use ($dokter) {

                $query->where(
                    'id_dokter',
                    $dokter->id_dokter
                );
            })
            ->whereIn('status', [
                'selesai',
                'dibatalkan'
            ])
            ->latest()
            ->get();

        return view(
            'dokter.riwayatPasien',
            compact(
                'riwayatList',
                'dokterLayout'
            )
        );
    }
}
