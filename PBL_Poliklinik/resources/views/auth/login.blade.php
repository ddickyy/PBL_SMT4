@php($hideNavbar = true)
@extends('layout.app')

@section('title', 'Login')

@section('content')
<div class="auth-wrapper">

    <div class="auth-card">

        <div class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Poliklinik Polinema" onerror="this.style.display='none'">
            <span class="logo-text">Poliklinik Polinema</span>
        </div>

        <div class="auth-header">
            <h1>Selamat Datang</h1>
            <p>Masuk untuk melanjutkan akses ke layanan kesehatan Anda.</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">ALAMAT EMAIL</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <input type="email" id="email" name="email" placeholder="nama@gmail.com" autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <div class="label-row">
                    <label for="password">KATA SANDI</label>
                    <a href="#" class="forgot-link">LUPA SANDI?</a>
                </div>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input type="password" id="password" name="password" placeholder="••••••••">
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <svg id="eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-check">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Ingat perangkat ini
                </label>
            </div>

            <a href="{{ route('beranda') }}" class="btn-primary">
                Masuk Sekarang →
            </a>

            <p class="auth-redirect">
                Belum memiliki akun? <a href="{{ route('daftar.role') }}">Daftar Sekarang</a>
            </p>

        </form>
    </div>

    <div class="auth-footer">
        © 2026 POLIKLINIK POLINEMA • SISTEM RESERVASI POLIKLINIK POLINEMA
    </div>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
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
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }


    .auth-card {
        background: white;
        border-radius: 24px;
        padding: 48px 52px;
        width: 100%;
        max-width: 680px;
        box-shadow: 0 20px 60px rgba(16, 43, 87, 0.1);
        position: relative;
        z-index: 1;
    }

    .auth-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 32px;
    }

    .auth-logo img {
        height: 36px;
    }

    .logo-text {
        font-size: 16px;
        font-weight: 700;
        color: #102b57;
    }

    .auth-header {
        margin-bottom: 32px;
    }

    .auth-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #102b57;
        margin: 0 0 8px;
    }

    .auth-header p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #64748b;
    }

    .label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .forgot-link {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s;
    }

    .forgot-link:hover {
        color: #102b57;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        width: 18px;
        height: 18px;
        color: #94a3b8;
        pointer-events: none;
    }

    .input-wrapper input {
        width: 100%;
        padding: 14px 44px;
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
        right: 14px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
    }

    .toggle-password svg {
        width: 18px;
        height: 18px;
        color: #94a3b8;
    }

    .form-check {
        margin-top: -4px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #475569;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-label input {
        display: none;
    }

    .checkmark {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 5px;
        display: inline-block;
        flex-shrink: 0;
        transition: 0.2s;
        position: relative;
    }

    .checkbox-label input:checked + .checkmark {
        background: #102b57;
        border-color: #102b57;
    } 

    .checkbox-label input:checked + .checkmark::after {
        content: "✓";
        color: white;
        font-size: 12px;
        font-weight: 800;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .btn-primary {
        background: #0A1F44;
        color: #ffffff;
        border: none;
        border-radius: 14px;
        padding: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        width: 100%;
        letter-spacing: 0.02em;
        transition: all 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        box-sizing: border-box;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(19, 54, 208, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .auth-redirect {
        text-align: center;
        font-size: 14px;
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
            padding: 32px 24px;
        }
    }
</style>
@endsection