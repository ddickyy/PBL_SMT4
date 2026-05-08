@php($hideNavbar = true)
@extends('layout.app')

@section('title', 'Daftar - Mahasiswa')

@section('content')
<div class="auth-wrapper">

    <div class="auth-card">

        <div class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Poliklinik Polinema" onerror="this.style.display='none'">
            <span class="logo-text">Poliklinik Polinema</span>
        </div>

        <div class="auth-header">
            <h1>Buat Akun Mahasiswa</h1>
            <p>Bergabung dengan layanan kesehatan kampus terintegrasi secara digital.</p>
        </div>

        <form action="#" method="POST" class="auth-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>NIM</label>
                    <div class="input-wrapper">
                        <input type="text" name="nim" placeholder="2441xxxx">
                    </div>
                </div>
                <div class="form-group">
                    <label>NAMA LENGKAP</label>
                    <div class="input-wrapper">
                        <input type="text" name="nama" placeholder="budiman">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>EMAIL</label>
                <div class="input-wrapper">
                    <input type="email" name="email" placeholder="budi@gmail.com">
                </div>
            </div>

            <div class="form-group">
                <label>PROGRAM STUDI</label>
                <div class="input-wrapper">
                    <input type="text" name="program_studi" placeholder="Contoh: Teknik Informatika">
                </div>
            </div>

            <div class="form-group">
                <label>PASSWORD</label>
                <div class="input-wrapper">
                    <input type="password" name="password" placeholder="••••••••">
                    <button type="button" class="toggle-password" onclick="togglePass('password')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>KONFIRMASI PASSWORD</label>
                <div class="input-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••">
                    <button type="button" class="toggle-password" onclick="togglePass('password_confirmation')">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>NOMOR TELEPON</label>
                <div class="input-wrapper">
                    <input type="tel" name="telepon" placeholder="08xxxxxxxx">
                </div>
            </div>

            <button type="submit" class="btn-primary">DAFTAR</button>

            <p class="auth-redirect">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
            </p>

        </form>
    </div>

    <div class="auth-footer">
        © 2026 POLIKLINIK POLINEMA • SISTEM RESERVASI POLIKLINIK POLINEMA
    </div>

</div>

<script>
    function togglePass(id) {
        const input = document.getElementById(id) || document.querySelector(`[name="${id}"]`);
        if (input) input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

<style>
    main {
        padding: 0;
        background: transparent;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #eef1f7;
        position: relative;
        overflow: hidden;
        padding: 40px 16px;
    }

    .auth-card {
        background: white;
        border-radius: 24px;
        padding: 48px 52px;
        width: 100%;
        max-width: 660px;
        box-shadow: 0 20px 60px rgba(16, 43, 87, 0.1);
        position: relative;
        z-index: 1;
    }

    .auth-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 28px;
    }

    .auth-logo img {
        height: 34px;
    }

    .logo-text {
        font-size: 15px;
        font-weight: 700;
        color: #102b57;
    }

    .auth-header {
        margin-bottom: 28px;
    }

    .auth-header h1 {
        font-size: 24px;
        font-weight: 800;
        color: #102b57;
        margin: 0 0 6px;
    }

    .auth-header p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #64748b;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper input {
        width: 100%;
        padding: 13px 16px;
        border: none;
        border-radius: 12px;
        background: #f1f5f9;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: background 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .input-wrapper input:focus {
        background: #e8edf5;
        box-shadow: 0 0 0 3px rgba(16, 43, 87, 0.1);
    }

    .input-wrapper input::placeholder {
        color: #b0bcc8;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .toggle-password svg {
        width: 17px;
        height: 17px;
        color: #94a3b8;
    }

    .btn-primary {
        background: #f6c40b;
        color: #102b57;
        border: none;
        border-radius: 14px;
        padding: 16px;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        width: 100%;
        letter-spacing: 0.06em;
        transition: all 0.2s;
        box-shadow: 0 8px 24px rgba(246, 196, 11, 0.3);
        margin-top: 4px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(246, 196, 11, 0.4);
    }

    .auth-redirect {
        text-align: center;
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .auth-redirect a {
        color: #102b57;
        font-weight: 700;
        text-decoration: none;
    }

    .auth-redirect a:hover {
        text-decoration: underline;
    }

    .auth-footer {
        margin-top: 24px;
        font-size: 12px;
        color: #94a3b8;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 560px) {
        .auth-card {
            padding: 32px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection