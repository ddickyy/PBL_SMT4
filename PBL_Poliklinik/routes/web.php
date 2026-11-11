<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\RoleSelectionController;
use App\Http\Controllers\MahasiswaRegisterController;
use App\Http\Controllers\DosenRegisterController;
use App\Http\Controllers\TendikRegisterController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasswordResetController;

Route::get('/', function () {
    return redirect()->route('login');
});


// AUTHENTICATION ROUTES
Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [AuthController::class, 'showLoginForm']
    )->name('login');

    Route::post(
        '/login',
        [AuthController::class, 'login']
    )->name('login.process');

    Route::get(
        '/forgot-password',
        [PasswordResetController::class, 'request']
    )->name('password.request');

    Route::post(
        '/forgot-password',
        [PasswordResetController::class, 'email']
    )->name('password.email');

    Route::get(
        '/reset-password/{token}',
        [PasswordResetController::class, 'reset']
    )->name('password.reset');

    Route::post(
        '/reset-password',
        [PasswordResetController::class, 'update']
    )->name('password.update');

    Route::prefix('daftar')
        ->name('daftar.')
        ->group(function () {
            Route::get(
                '/role',
                [RoleSelectionController::class, 'index']
            )->name('role');

            Route::prefix('mahasiswa')
                ->name('mhs.')
                ->group(function () {
                    Route::get(
                        '/',
                        [MahasiswaRegisterController::class, 'create']
                    )->name('create');

                    Route::post(
                        '/',
                        [MahasiswaRegisterController::class, 'store']
                    )->name('store');
                });

            Route::prefix('dosen')
                ->name('dosen.')
                ->group(function () {
                    Route::get(
                        '/',
                        [DosenRegisterController::class, 'create']
                    )->name('create');

                    Route::post(
                        '/',
                        [DosenRegisterController::class, 'store']
                    )->name('store');
                });

            Route::prefix('tendik')
                ->name('tendik.')
                ->group(function () {
                    Route::get(
                        '/',
                        [TendikRegisterController::class, 'create']
                    )->name('create');

                    Route::post(
                        '/',
                        [TendikRegisterController::class, 'store']
                    )->name('store');
                });
        });
});

// PATIENT ROUTES
Route::middleware('auth')
    ->prefix('pasien')
    ->name('pasien.')
    ->group(function () {

        Route::get(
            '/beranda',
            [BerandaController::class, 'index']
        )->name('beranda');


        Route::prefix('reservasi')
            ->name('reservasi.')
            ->group(function () {
                // PAGE RESERVASI

                Route::get(
                    '/',
                    [ReservasiController::class, 'index']
                )->name('index');

                Route::post(
                    '/',
                    [ReservasiController::class, 'store']
                )->name('store');

                Route::get(
                    '/{id}',
                    [ReservasiController::class, 'show']
                )->name('show');

                Route::put(
                    '/{id}/cancel',
                    [ReservasiController::class, 'cancel']
                )->name('cancel');
            });

        Route::get(
            '/bukti-reservasi',
            [ReservasiController::class, 'bukti']
        )->name('bukti');

        Route::get(
            '/riwayat',
            [ReservasiController::class, 'riwayat']
        )->name('riwayat');

        Route::get(
            '/jadwal',
            [JadwalController::class, 'index']
        )->name('jadwal');

        Route::get(
            '/dokter',
            [DokterController::class, 'index']
        )->name('dokter.index');

        Route::get(
            '/penilaian/{reservasi}',
            [PenilaianController::class, 'create']
        )->name('penilaian.create');

        Route::post(
            '/penilaian',
            [PenilaianController::class, 'store']
        )->name('penilaian.store');

        Route::put(
            '/penilaian/{id}',
            [PenilaianController::class, 'update']
        )->name('penilaian.update');

        Route::prefix('profil')
            ->name('profil.')
            ->group(function () {
                Route::get(
                    '/',
                    [ProfilController::class, 'show']
                )->name('show');

                Route::get(
                    '/edit',
                    [ProfilController::class, 'edit']
                )->name('edit');

                Route::put(
                    '/',
                    [ProfilController::class, 'update']
                )->name('update');
            });
    });

// DOCTOR ROUTES
Route::middleware('auth')
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {

        Route::get(
            '/beranda',
            [DokterController::class, 'beranda']
        )->name('beranda');

        Route::get(
            '/pasien',
            [DokterController::class, 'pasien']
        )->name('pasien');

        Route::get(
            '/pasien/{id}',
            [DokterController::class, 'detailPasien']
        )->name('pasien.detail');

        Route::put(
            '/pasien/{id}/status',
            [DokterController::class, 'updateStatus']
        )->name('pasien.updateStatus');

        Route::post(
            '/pasien/{id}/rekam-medis',
            [DokterController::class, 'updateOrCreateRekamMedis']
        )->name('pasien.rekamMedis');

        Route::get(
            '/riwayat',
            [DokterController::class, 'riwayat']
        )->name('riwayat');


        Route::get(
            '/profil',
            [DokterController::class, 'profil']
        )->name('profil');

        Route::get(
            '/profil/edit',
            [DokterController::class, 'editProfil']
        )->name('profil.edit');
        Route::put(
            '/profil/update',
            [DokterController::class, 'updateProfil']
        )->name('profil.update');
    });

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');
