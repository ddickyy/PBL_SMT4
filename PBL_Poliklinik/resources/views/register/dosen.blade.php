@php($hideNavbar = true)

@extends('layout.app')

@section('title', 'Daftar - Dosen')

@section('content')

    <div class="auth-wrapper">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="auth-card">
            <div class="auth-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Poliklinik Polinema" onerror="this.style.display='none'">
                <span class="logo-text">
                    Poliklinik Polinema
                </span>
            </div>

            <div class="auth-header">
                <h1>Buat Akun Dosen</h1>
                <p>
                    Bergabung dengan layanan kesehatan kampus
                    terintegrasi secara digital.
                </p>
            </div>

            {{-- ERROR GLOBAL --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('daftar.dosen.store') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-row">
                    {{-- NIDN --}}
                    <div class="form-group">
                        <label>NIDN</label>
                        <div class="input-wrapper">
                            <input type="text" name="nidn" value="{{ old('nidn') }}" placeholder="Masukkan NIDN Anda"
                                required>
                        </div>
                    </div>

                    {{-- NAMA --}}
                    <div class="form-group">
                        <label>NAMA LENGKAP</label>
                        <div class="input-wrapper">
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                    </div>
                </div>

                {{-- EMAIL --}}
                <div class="form-group">
                    <label>EMAIL</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda"
                            required>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label>PASSWORD</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                        <button type="button" class="toggle-password" onclick="togglePass('password')">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0
                                                                  3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943
                                                                  7.523 5 12 5c4.478 0
                                                                  8.268 2.943 9.542 7
                                                                  -1.274 4.057-5.064 7
                                                                  -9.542 7-4.477
                                                                  0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- KONFIRMASI PASSWORD --}}
                <div class="form-group">
                    <label>KONFIRMASI PASSWORD</label>
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Masukkan kembali password Anda" required>
                        <button type="button" class="toggle-password" onclick="togglePass('password_confirmation')">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0
                                                                  3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943
                                                                  7.523 5 12 5c4.478 0
                                                                  8.268 2.943 9.542 7
                                                                  -1.274 4.057-5.064 7
                                                                  -9.542 7-4.477
                                                                  0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- JURUSAN --}}
                <div class="form-group">
                    <label>JURUSAN</label>
                    <div class="input-wrapper">
                        <select name="id_jurusan" id="id_jurusan" placeholder="Cari jurusan..." required>
                            <option value="">
                                --- Pilih jurusan Anda ---
                            </option>

                            @foreach ($jurusan as $item)
                                <option value="{{ $item->id_jurusan }}" {{ old('id_jurusan') == $item->id_jurusan ? 'selected' : '' }}>{{ $item->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- NOMOR HP --}}
                <div class="form-group">
                    <label>NOMOR TELEPON</label>
                    <div class="input-wrapper">
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan nomor telepon Anda"
                            required>
                    </div>
                </div>


                <button type="submit" class="btn-primary">
                    DAFTAR
                </button>

                <p class="auth-redirect">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">
                        Masuk
                    </a>
                </p>
            </form>

        </div>
        <div class="auth-footer">
            © 2026 POLIKLINIK POLINEMA • SISTEM RESERVASI POLIKLINIK POLINEMA
        </div>
    </div>

    <script>

        function togglePass(id) {
            const input = document.getElementById(id);

            if (input) {

                input.type =
                    input.type === 'password'
                        ? 'text'
                        : 'password';
            }
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
            background: linear-gradient(135deg, #eef4ff 0%, #f8fbff 50%, #edf2ff 100%);
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
            animation: cardReveal .7s ease;
            transition: .4s ease;
        }

        .auth-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 80px rgba(16, 43, 87, .15);
        }

        @keyframes cardReveal {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            line-height: 1.6;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
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

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input,
        .input-wrapper select {
            width: 100%;
            padding: 14px 16px;
            border: none;
            border-radius: 12px;
            background: #f1f5f9;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition:
                background 0.2s,
                box-shadow 0.2s,
                border 0.2s;
            box-sizing: border-box;
            appearance: none;
        }

        .input-wrapper input:focus,
        .input-wrapper select:focus {
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
            margin-top: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(19, 54, 208, .4);
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

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: .25;
            animation: floatBlob 8s ease-in-out infinite;
            z-index: 0;
        }

        .blob-1 {
            width: 220px;
            height: 220px;
            background: #f6c40b;
            top: -60px;
            left: -60px;
        }

        .blob-2 {
            width: 260px;
            height: 260px;
            background: #8bb7ff;
            bottom: -80px;
            right: -80px;
        }

        @keyframes floatBlob {
            0%,
            100% {
                transform: translateY(0);
            }
            
            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 560px) {

            .auth-card {
                padding: 32px 24px;
            }

            .auth-header h1 {
                font-size: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

@endsection