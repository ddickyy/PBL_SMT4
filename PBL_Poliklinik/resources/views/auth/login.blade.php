@php($hideNavbar = true)

@extends('layout.app')

@section('title', 'Login')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-cover">
            <div class="auth-cover-overlay">
                <div class="cover-content">
                    <img src="{{ asset('images/logo.png') }}" alt="Poliklinik Polinema" class="cover-logo" onerror="this.style.display='none'">
                    <h2>Sistem Informasi<br>Poliklinik Polinema</h2>
                    <p>Layanan kesehatan terpadu dan profesional untuk seluruh Civitas Akademika Politeknik Negeri Malang.</p>
                </div>
            </div>
        </div>

        <div class="auth-content">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>

            <div class="auth-card">

                <div class="auth-logo mobile-only">
                    <img src="{{ asset('images/logo.png') }}" alt="Poliklinik Polinema" onerror="this.style.display='none'">
                    <span class="logo-text">Poliklinik Polinema</span>
                </div>

                <div class="auth-header">
                    <h1 id="dynamic-greeting">Selamat Datang</h1>
                    <p>Masuk untuk melanjutkan akses ke layanan kesehatan Anda.</p>
                </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="auth-form" id="login-form">
                @csrf

                <div class="form-group">
                    <label for="email">ALAMAT EMAIL</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com"
                            autocomplete="email" required class="@error('email') input-error @enderror">
                    </div>

                    @error('email')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password">KATA SANDI</label>
                        <a href="{{ route('password.request') }}" class="forgot-link">LUPA SANDI?</a>
                    </div>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input type="password" id="password" name="password" placeholder="••••••••" required minlength="5"
                            class="@error('password') input-error @enderror">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg id="eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <small class="text-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-check">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Ingat perangkat ini
                    </label>
                </div>

                <button type="submit" class="btn-primary" id="submit-btn">
                    <span id="btn-text">Masuk Sekarang →</span>
                    <svg id="btn-spinner" class="spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none; width: 20px; height: 20px; animation: spin 1s linear infinite;">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" style="opacity: 0.25;"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" style="opacity: 0.75;"></path>
                    </svg>
                </button>

                <p class="auth-redirect">
                    Belum memiliki akun? <a href="{{ route('daftar.role') }}">Daftar Sekarang</a>
                </p>
            </form>
        </div>

            <div class="auth-footer">
                © 2026 POLIKLINIK POLINEMA • SISTEM RESERVASI POLIKLINIK POLINEMA
            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Dynamic Greeting
            const greetingElement = document.getElementById('dynamic-greeting');
            const hour = new Date().getHours();
            let greeting = 'Selamat Datang';

            if (hour >= 5 && hour < 12) {
                greeting = 'Selamat Pagi';
            } else if (hour >= 12 && hour < 15) {
                greeting = 'Selamat Siang';
            } else if (hour >= 15 && hour < 18) {
                greeting = 'Selamat Sore';
            } else {
                greeting = 'Selamat Malam';
            }

            if(greetingElement) {
                greetingElement.innerText = greeting;
            }

            // Loading Spinner on Submit
            const loginForm = document.getElementById('login-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');

            if(loginForm) {
                loginForm.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('loading-state');
                    btnText.style.display = 'none';
                    spinner.style.display = 'inline-block';
                });
            }
        });
    </script>

    <style>
        main {
            padding: 0 !important;
            background: transparent;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .auth-cover {
            flex: 1.2;
            background: url('{{ asset("images/poliklinik.jpg") }}') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-cover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10, 31, 68, 0.85) 0%, rgba(16, 43, 87, 0.75) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .cover-content {
            text-align: left;
            color: white;
            max-width: 500px;
            animation: cardReveal 1s ease;
        }

        .cover-logo {
            height: 70px;
            margin-bottom: 24px;
            background: white;
            padding: 10px;
            border-radius: 16px;
        }

        .cover-content h2 {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.3;
            margin: 0 0 16px 0;
            color: #ffffff;
        }

        .cover-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #e2e8f0;
            margin: 0;
        }

        .auth-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #eef4ff 0%, #f8fbff 50%, #edf2ff 100%);
            padding: 40px 20px;
            overflow: hidden;
            min-height: 100vh;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 24px;
            padding: 48px 52px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(16, 43, 87, 0.08), inset 0 0 0 1px rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 1;
            animation: cardReveal .8s ease;
            transition: .4s ease;
        }

        @keyframes cardReveal {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 30px 80px rgba(16, 43, 87, .15);

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

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 18px;
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
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within .input-icon {
            color: #102b57;
            transform: scale(1.15);
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 44px;
            border: 2px solid transparent;
            border-radius: 12px;
            background: rgba(241, 245, 249, 0.7);
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-wrapper input:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: #102b57;
            box-shadow: 0 0 0 4px rgba(16, 43, 87, 0.15);
            transform: translateY(-2px);
        }

        /* .input-wrapper input:focus {
                background: #ffffff;
                transform: translateY(-2px);
                box-shadow:
                    0 0 0 3px rgba(16, 43, 87, .08),
                    0 10px 25px rgba(16, 43, 87, .08);
            } */

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

        .checkbox-label input:checked+.checkmark {
            background: #102b57;
            border-color: #102b57;
        }

        .checkbox-label input:checked+.checkmark::after {
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
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: "";

            position: absolute;

            top: 0;
            left: -120%;

            width: 60px;
            height: 100%;

            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, .35),
                    transparent);

            transform: skewX(-20deg);

            animation: shine 3.5s infinite;
        }

        @keyframes shine {

            0% {
                left: -120%;
            }

            100% {
                left: 150%;
            }

        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(19, 54, 208, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-state {
            cursor: not-allowed !important;
            opacity: 0.8;
            pointer-events: none;
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

        .text-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 2px;
        }

        .input-error {
            border: 1px solid #ef4444 !important;
            background: #fef2f2 !important;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: .6;
            z-index: 0;
            mix-blend-mode: multiply;
        }

        .blob-1 {
            width: 300px;
            height: 300px;
            background: #f6c40b;
            top: 0;
            left: 0;
            animation: moveBlob1 12s ease-in-out infinite alternate;
        }

        .blob-2 {
            width: 360px;
            height: 360px;
            background: #8bb7ff;
            bottom: 0;
            right: 0;
            animation: moveBlob2 15s ease-in-out infinite alternate;
        }

        @keyframes moveBlob1 {
            0% { transform: translate(0, 0) scale(1); opacity: 0.5; }
            25% { transform: translate(150px, 100px) scale(1.2); opacity: 0.8; }
            50% { transform: translate(300px, 250px) scale(0.9); opacity: 0.6; }
            75% { transform: translate(100px, 350px) scale(1.3); opacity: 0.9; }
            100% { transform: translate(250px, -50px) scale(1.1); opacity: 0.7; }
        }

        @keyframes moveBlob2 {
            0% { transform: translate(0, 0) scale(1); opacity: 0.5; }
            25% { transform: translate(-150px, -150px) scale(1.3); opacity: 0.9; }
            50% { transform: translate(-300px, -50px) scale(0.8); opacity: 0.6; }
            75% { transform: translate(-100px, -300px) scale(1.2); opacity: 0.8; }
            100% { transform: translate(-250px, 100px) scale(1.1); opacity: 0.7; }
        }

        .mobile-only {
            display: none;
        }

        @media (max-width: 1050px) {
            .auth-cover {
                display: none;
            }
            .mobile-only {
                display: flex;
            }
        }

        @media (max-width: 560px) {
            .auth-card {
                padding: 32px 24px;
                box-shadow: 0 10px 30px rgba(16, 43, 87, 0.05);
            }

            .auth-header h1 {
                font-size: 24px;
            }
        }
    </style>
@endsection