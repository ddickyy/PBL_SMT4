@extends('layout.app')

@section('title', 'Edit Profil')

@section('content')

@php
    $user = auth()->user();
@endphp

<section class="profile-edit-page">
    <div class="page-container">
        <div class="hero-section">
            <div class="profile-card">
                <div class="page-header">
                    <h1>Edit Profil Anda</h1>
                    <p>
                        Perbarui informasi pribadi Anda untuk
                        kelancaran layanan kesehatan.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('pasien.profil.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        {{-- FOTO --}}
                        <div class="form-group full-width">
                            <label>FOTO PROFIL</label>
                            <div class="photo-upload">
                                <div class="photo-preview">
                                    @if($user->foto)
                                        <img src="{{ asset('storage/' . $user->foto) }}"
                                             alt="Foto Profil">
                                    @else
                                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                                    @endif
                                </div>

                                <input type="file"
                                       name="foto"
                                       accept="image/*">
                            </div>
                        </div>

                        {{-- NAMA --}}
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <div class="input-icon">
                                <i class="fa-regular fa-user"></i>
                                <input type="text"
                                       name="nama"
                                       value="{{ old('nama', $user->nama) }}"
                                       placeholder="Nama lengkap">
                            </div>

                            @error('nama')
                                <small class="error-text">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-icon">
                                <i class="fa-regular fa-envelope"></i>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="Email aktif">
                            </div>

                            @error('email')
                                <small class="error-text">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        {{-- MAHASISWA --}}
                        @if($user->mahasiswa)
                            <div class="form-group">
                                <label>NIM</label>
                                <div class="input-icon">
                                    <i class="fa-regular fa-id-badge"></i>
                                    <input type="text"
                                           value="{{ $user->mahasiswa->nim }}"
                                           readonly
                                           class="readonly-input">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Program Studi</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <input type="text"
                                           value="{{ optional($user->mahasiswa->prodi)->nama_prodi }}"
                                           readonly
                                           class="readonly-input">
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label>Nomor Telepon</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text"
                                           name="no_hp"
                                           value="{{ old('no_hp', $user->mahasiswa->no_hp) }}"
                                           placeholder="Nomor telepon aktif">
                                </div>

                                @error('no_hp')
                                    <small class="error-text">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        @endif

                        {{-- DOSEN --}}
                        @if($user->dosen)
                            <div class="form-group">
                                <label>NIDN / NIP</label>
                                <div class="input-icon">
                                    <i class="fa-regular fa-id-badge"></i>
                                    <input type="text"
                                           value="{{ $user->dosen->nip }}"
                                           readonly
                                           class="readonly-input">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text"
                                           name="no_hp"
                                           value="{{ old('no_hp', $user->dosen->no_hp) }}"
                                           placeholder="Nomor telepon aktif">
                                </div>
                            </div>
                        @endif

                        {{-- TENDIK --}}
                        @if($user->tendik)
                            <div class="form-group">
                                <label>NIP</label>
                                <div class="input-icon">
                                    <i class="fa-regular fa-id-badge"></i>
                                    <input type="text"
                                           value="{{ $user->tendik->nip }}"
                                           readonly
                                           class="readonly-input">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Jabatan</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <input type="text"
                                           value="{{ optional($user->tendik->jabatan)->nama_jabatan }}"
                                           readonly
                                           class="readonly-input">
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label>Nomor Telepon</label>
                                <div class="input-icon">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text"
                                           name="no_hp"
                                           value="{{ old('no_hp', $user->tendik->no_hp) }}"
                                           placeholder="Nomor telepon aktif">
                                </div>
                            </div>
                        @endif

                        {{-- PASSWORD --}}
                        <div class="form-group full-width password-section">
                            <div class="password-header">
                                <h3>Ubah Password</h3>
                                <p>
                                    Kosongkan jika tidak ingin mengubah password.
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password"
                                       name="password"
                                       placeholder="Masukkan password baru">
                            </div>

                            @error('password')
                                <small class="error-text">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <div class="input-icon">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password"
                                       name="password_confirmation"
                                       placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="save-row">
                        <button type="submit"
                                class="btn-save">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<style>

    .profile-edit-page {
        padding: 28px 24px 64px;
        background: #f5f7fb;
        min-height: 100vh;
    }

    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .hero-section {
        padding-top: 100px;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 34px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
    }

    .page-header {
        margin-bottom: 28px;
    }

    .page-header h1 {
        margin: 0 0 8px;
        font-size: 36px;
        line-height: 1.1;
        color: #102b57;
        font-weight: 900;
    }

    .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 15px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 18px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px 24px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 10px;
        font-size: 12px;
        font-weight: 800;
        color: #102b57;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .input-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon i {
        position: absolute;
        left: 16px;
        color: #4b5563;
        font-size: 16px;
        pointer-events: none;
    }

    .input-icon input {
        width: 100%;
        border: none;
        outline: none;
        background: #f4f4f6;
        border-radius: 14px;
        padding: 16px 18px 16px 48px;
        font-size: 15px;
        color: #2d3137;
        transition: .25s ease;
    }

    .input-icon input:focus {
        background: #eef4ff;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
    }

    .readonly-input {
        background: #eceff3 !important;
        color: #64748b !important;
        cursor: not-allowed;
    }

    .error-text {
        margin-top: 8px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 600;
    }

    .photo-upload {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .photo-preview {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #102b57;
        color: white;
        font-size: 28px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .save-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-save {
        border: none;
        background: #facc15;
        color: #102b57;
        padding: 16px 28px;
        border-radius: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 10px 24px rgba(250, 204, 21, 0.18);
        transition: .25s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-save:hover {
        background: #eab308;
        transform: translateY(-2px);
    }

    .password-section {
        margin-top: 10px;
    }

    .password-header {
        padding-top: 10px;
        border-top: 1px solid #e5e7eb;
    }

    .password-header h3 {
        margin: 0 0 6px;
        font-size: 22px;
        font-weight: 800;
        color: #102b57;
    }

    .password-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    @media (max-width: 1024px) {

        .form-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 768px) {

        .profile-edit-page {
            padding: 18px 14px 50px;
        }

        .page-container {
            padding: 0;
        }

        .profile-card {
            padding: 22px;
        }

        .page-header h1 {
            font-size: 28px;
        }

        .save-row {
            justify-content: stretch;
        }

        .btn-save {
            width: 100%;
            justify-content: center;
        }

        .photo-upload {
            flex-direction: column;
            align-items: flex-start;
        }

    }

</style>

@endsection