@php($hideNavbar = true)
@extends('layout.app')

@section('title', 'Pilih Identitas')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Identitas</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-2.png') }}">
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
@section('content')

    <div class="page-wrap">
        <header class="topbar">
            <a href="#" class="brand" aria-label="Poliklinik Polinema">
                <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="logo-img">
                <span>Poliklinik Polinema</span>
            </a>
        </header>

        <main class="hero-shell">
            <section class="hero-card">
                <h2 class="title">Pilih identitas Anda</h2>
                <p class="subtitle">Pilih identitas untuk melanjutkan pendaftaran anda.</p>

                <div class="options-grid">
                    <article class="option-card">
                        <div class="icon-badge" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#f6c40b" stroke-width="2"
                                viewBox="0 0 24 24" width="44" height="44">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0" />
                            </svg>
                        </div>
                        <h2 class="option-title">Mahasiswa</h2>
                        <p class="option-desc">Akses layanan kesehatan dan pendaftaran bagi seluruh mahasiswa aktif.</p>
                        <div class="option-action">
                            <a href="{{ route('daftar.mhs.create') }}" class="btn-identitas">Pilih Mahasiswa</a>
                        </div>
                    </article>

                    <article class="option-card">
                        <div class="icon-badge" aria-hidden="true">
                            <div class="icon-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#f6c40b" stroke-width="2"
                                    viewBox="0 0 24 24" width="44" height="44">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0-6l6-3" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="option-title">Dosen</h2>
                        <p class="option-desc">Akses layanan kesehatan khusus bagi tenaga pendidik Polinema.</p>
                        <div class="option-action">
                            <a href="{{ route('daftar.dosen.create') }}" class="btn-identitas">Pilih Dosen</a>
                        </div>
                    </article>

                    <article class="option-card">
                        <div class="icon-badge" aria-hidden="true">
                            <div class="icon-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#f6c40b" stroke-width="2"
                                    viewBox="0 0 24 24" width="44" height="44">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 6V4h6v2m-9 0h12a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="option-title">Tendik</h2>
                        <p class="option-desc">Akses layanan kesehatan bagi tenaga kependidikan dan staf non-akademik.</p>
                        <div class="option-action">
                            <a href="{{ route('daftar.tendik.create') }}" class="btn-identitas">Pilih Tendik</a>
                        </div>
                    </article>
                </div>
            </section>
        </main>

        <div class="auth-footer">
            © 2026 POLIKLINIK POLINEMA • SISTEM RESERVASI POLIKLINIK POLINEMA
        </div>
    </div>

    <style>
        :root {
            --navy: #102b57;
            --yellow: #f6c40b;
            --bg: #f7f7f8;
            --card: #ffffff;
            --soft: #f2f2f4;
            --text: #17315c;
            --muted: #6f7380;
            --footer: #c9cad4;
            --shadow: 0 24px 60px rgba(16, 43, 87, .08);
            --shadow-soft: 0 16px 40px rgba(16, 43, 87, .05);
            --radius: 32px;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .page-wrap {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 92px;
            display: flex;
            align-items: center;
            padding: 0 28px;
            background: rgba(255, 255, 255, .72);
            backdrop-filter: saturate(180%) blur(10px);
            box-shadow: 0 1px 0 rgba(16, 43, 87, .03);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: var(--text);
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -.02em;
        }

        .brand svg {
            width: 34px;
            height: 34px;
            flex: none;
        }

        .hero-shell {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 30px 58px;
        }

        .hero-card {
            width: min(1360px, calc(100vw - 60px));
            min-height: auto;
            background: var(--card);
            border-radius: 36px;
            box-shadow: var(--shadow);
            padding: 80px 92px 78px;
            box-sizing: border-box;
        }

        .title {
            margin: 0;
            font-size: clamp(2rem, 2.4vw, 3rem);
            line-height: 1.15;
            letter-spacing: -.04em;
            font-weight: 800;
            color: var(--text);
        }

        .subtitle {
            margin: 12px 0 0;
            font-size: 1.25rem;
            line-height: 1.55;
            color: var(--muted);
            font-weight: 400;
        }

        .options-grid {
            margin-top: 48px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
            align-items: stretch;
        }

        .option-card {
            background: var(--soft);
            border-radius: 18px;
            padding: 32px 28px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            box-shadow: inset 0 0 0 1px rgba(16, 43, 87, .02);
        }

        .auth-footer {
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
            padding-bottom: 18px;
        }

        .icon-badge {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: var(--navy);
            display: grid;
            place-items: center;
            margin-top: 3px;
            flex: none;
        }

        .icon-badge svg {
            width: 44px;
            height: 44px;
        }

        .option-title {
            margin: 28px 0 0;
            font-size: 1.7rem;
            line-height: 1.2;
            font-weight: 700;
            color: var(--text);
            text-align: center;
        }

        .option-desc {
            margin: 14px 0 0;
            font-size: 1.08rem;
            line-height: 1.55;
            color: #4d5a7a;
            text-align: center;
            max-width: 290px;
            min-height: 78px;
        }

        .option-action {
            margin-top: 18px;
            width: 100%;
        }

        .btn-identitas {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 50px;
            border-radius: 12px;
            background: var(--navy);
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: .01em;
            box-shadow: 0 12px 26px rgba(16, 43, 87, .18);
            transition: transform .15s ease, box-shadow .15s ease, opacity .15s ease;
        }

        .btn-identitas:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(16, 43, 87, .24);
            opacity: .98;
        }

        @media (max-width: 1200px) {
            .hero-card {
                width: min(100%, 1360px);
                padding: 64px 42px 54px;
            }

            .options-grid {
                gap: 18px;
            }

            .option-card {
                padding-inline: 22px;
            }
        }

        @media (max-width: 980px) {
            .hero-card {
                min-height: auto;
            }

            .options-grid {
                grid-template-columns: 1fr;
            }

            .option-card {
                min-height: auto;
                padding-bottom: 28px;
            }

            .option-desc {
                min-height: auto;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                height: 76px;
                padding-inline: 18px;
            }

            .brand {
                font-size: 1.1rem;
                gap: 10px;
            }

            .hero-shell {
                padding: 18px 14px 32px;
            }

            .hero-card {
                border-radius: 24px;
                padding: 34px 20px 28px;
            }

            .subtitle {
                font-size: 1rem;
            }

            .title {
                font-size: 1.7rem;
            }

            .option-title {
                font-size: 1.35rem;
            }
        }
    </style>
@endsection