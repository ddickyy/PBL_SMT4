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

Route::get('/', function () {
    return redirect()->route('login');
});

// Guest
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Daftar
    Route::prefix('daftar')->name('daftar.')->group(function () {

        Route::get('/role', [RoleSelectionController::class, 'index'])->name('role');

        Route::prefix('mahasiswa')->group(function () {
            Route::get('/', [MahasiswaRegisterController::class, 'create'])->name('mhs');
            Route::post('/', [MahasiswaRegisterController::class, 'store'])->name('mhs.store');
        });

        Route::prefix('dosen')->group(function () {
            Route::get('/', [DosenRegisterController::class, 'create'])->name('dosen');
            Route::post('/', [DosenRegisterController::class, 'store'])->name('dosen.store');
        });

        Route::prefix('tendik')->group(function () {
            Route::get('/', [TendikRegisterController::class, 'create'])->name('tendik');
            Route::post('/', [TendikRegisterController::class, 'store'])->name('tendik.store');
        });
    });
});

// Pasien
Route::middleware(['auth'])->prefix('pasien')->name('pasien.')->group(function () {

    // Beranda
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Reservasi
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi'); // <-- FIX ;
    Route::get('/riwayat', [ReservasiController::class, 'riwayat'])->name('riwayat');

    // Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');

    // Dokter
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');

    // Penilaian
    Route::get('/penilaian/{reservasi}', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

    // Profil
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Coba
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');