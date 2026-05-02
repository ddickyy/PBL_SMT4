<?php

use App\Http\Controllers\DokterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\RoleSelectionController;
use App\Http\Controllers\MahasiswaRegisterController;
use App\Http\Controllers\DosenRegisterController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TendikRegisterController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // daftar
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

// Beranda Pasien
Route::middleware(['auth'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
});

// daftar dokter untuk pasien
Route::middleware(['auth'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
});

// Penilian dokter oleh pasien
Route::middleware(['auth'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/penilaian/{reservasi}', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
});

// Profil
Route::middleware(['auth'])->prefix('pasien')->name('pasien.')->group(function () {

    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');

    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');

    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});