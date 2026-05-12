@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')

    @php
        $user = auth()->user();
    @endphp

    <section class="profile-page">

        <div class="profile-container">

            {{-- HERO PROFILE --}}
            <div class="hero-card">

                {{-- AVATAR --}}
                <div class="hero-avatar">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->nama, 0, 1)) }}

                    @endif

                    <a href="{{ route('pasien.profil.edit') }}" class="edit-avatar">
                    </a>
                </div>

                {{-- HERO INFO --}}
                <div class="hero-info">
                    <span class="role-badge">
                        @if($user->mahasiswa)
                            MAHASISWA AKTIF
                        @elseif($user->dosen)
                            DOSEN AKTIF
                        @elseif($user->tendik)
                            TENDIK AKTIF
                        @endif
                    </span>

                    <h1>{{ $user->nama }}</h1>
                    {{-- MAHASISWA --}}
                    @if($user->mahasiswa)
                        <p>
                            NIM:
                            {{ $user->mahasiswa->nim }}
                        </p>

                        <p class="highlight">
                            Prodi:
                            {{ optional($user->mahasiswa->prodi)->nama_prodi }}
                        </p>
                    @endif

                    {{-- DOSEN --}}
                    @if($user->dosen)
                        <p>
                            NIDN / NIP:
                            {{ $user->dosen->nip }}
                        </p>

                        <p class="highlight">
                            Dosen Politeknik Negeri Malang
                        </p>
                    @endif

                    {{-- TENDIK --}}
                    @if($user->tendik)
                        <p>
                            NIP:
                            {{ $user->tendik->nip }}
                        </p>

                        <p class="highlight">
                            {{ optional($user->tendik->jabatan)->nama_jabatan }}
                        </p>
                    @endif

                    {{-- ACTION --}}
                    <div class="hero-actions">
                        <a href="{{ route('pasien.profil.edit') }}" class="btn-primary">
                            Edit Profil
                        </a>
                    </div>

                </div>

            </div>

            {{-- INFORMASI --}}
            <div class="profile-grid">
                {{-- INFORMASI AKUN --}}
                <div class="info-card">
                    <div class="section-header">
                        <h2>
                            <i class="fa-solid fa-user-graduate"></i>
                            Informasi Akun
                        </h2>
                    </div>

                    <div class="info-grid">
                        {{-- MAHASISWA --}}
                        @if($user->mahasiswa)
                            <div class="info-box">
                                <span>Program Studi</span>
                                <strong>
                                    {{ optional($user->mahasiswa->prodi)->nama_prodi }}
                                </strong>
                            </div>

                            <div class="info-box">
                                <span>Status</span>
                                <strong>Mahasiswa</strong>
                            </div>

                            <div class="info-box">
                                <span>Email</span>
                                <strong>{{ $user->email }}</strong>
                            </div>

                            <div class="info-box">
                                <span>Nomor HP</span>
                                <strong>{{ $user->mahasiswa->no_hp }}</strong>
                            </div>
                        @endif

                        {{-- DOSEN --}}
                        @if($user->dosen)
                            <div class="info-box">
                                <span>Status</span>
                                <strong>Dosen</strong>
                            </div>

                            <div class="info-box">
                                <span>Email</span>
                                <strong>{{ $user->email }}</strong>
                            </div>

                            <div class="info-box">
                                <span>NIDN / NIP</span>
                                <strong>{{ $user->dosen->nip }}</strong>
                            </div>

                            <div class="info-box">
                                <span>Nomor HP</span>
                                <strong>{{ $user->dosen->no_hp }}</strong>
                            </div>
                        @endif

                        {{-- TENDIK --}}
                        @if($user->tendik)
                            <div class="info-box">
                                <span>Status</span>
                                <strong>Tendik</strong>
                            </div>

                            <div class="info-box">
                                <span>Jabatan</span>
                                <strong>
                                    {{ optional($user->tendik->jabatan)->nama_jabatan }}
                                </strong>
                            </div>

                            <div class="info-box">
                                <span>Email</span>
                                <strong>{{ $user->email }}</strong>
                            </div>

                            <div class="info-box">
                                <span>Nomor HP</span>
                                <strong>{{ $user->tendik->no_hp }}</strong>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- REKAM MEDIS --}}
                <div class="medical-card">
                    <div class="section-header">
                        <h2>Rekam Medis</h2>
                    </div>

                    <div class="medical-list">
                        @forelse($rekamMedis ?? [] as $item)
                            <div class="medical-item">
                                <div class="medical-icon">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>

                                <div>
                                    <h3>{{ $item }}</h3>
                                    <p>
                                        Data rekam medis hanya dapat
                                        dikelola oleh dokter.
                                    </p>
                                </div>
                            </div>
                        @empty

                            <div class="medical-empty">
                                <i class="fa-solid fa-notes-medical"></i>
                                <p>
                                    Belum ada data rekam medis.
                                </p>
                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

        {{-- AKTIVITAS TERAKHIR --}}
        <div class="activity-section">
            <div class="activity-header">
                <h2>Aktivitas Terakhir</h2>
                <a href="{{ route('pasien.riwayat') }}">
                    Lihat Semua Riwayat
                </a>
            </div>

            <div class="activity-list">
                @forelse($reservasiTerakhir ?? [] as $item)
                    <div class="activity-card">
                        <div class="activity-left">
                            <div class="activity-icon">
                                <i class="fa-solid fa-stethoscope"></i>
                            </div>
                            <div class="activity-info">
                                <h3>
                                    {{ optional($item->jadwal->dokter)->nama ?? 'Pemeriksaan' }}
                                </h3>
                                <p>
                                    {{ optional(optional($item->jadwal)->dokter)->spesialisasi->nama_spesialisasi ?? 'Poliklinik' }}
                                </p>
                            </div>
                        </div>

                        <div class="activity-right">
                            <strong>
                                {{ \Carbon\Carbon::parse($item->tanggal_reservasi)->translatedFormat('d M Y') }}
                            </strong>
                            <span class="status-badge">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    </div>

                @empty
                    <div class="activity-empty">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        <p>
                            Belum ada aktivitas reservasi.
                        </p>
                    </div>
                @endforelse

            </div>
        </div>

    </section>

    <style>
        .profile-page {
            background: #f5f7fb;
            min-height: 100vh;
            padding: 28px 24px 60px;
        }

        .profile-container {
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 100px;
        }

        .hero-card {
            background: white;
            border-radius: 28px;
            padding: 42px;
            display: flex;
            align-items: center;
            gap: 40px;
            margin-bottom: 28px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
        }

        .hero-avatar {
            position: relative;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: #102b57;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            font-weight: 900;
            overflow: hidden;
            flex-shrink: 0;
        }

        .hero-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-info {
            flex: 1;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 999px;
            background: #facc15;
            color: #102b57;
            font-size: 12px;
            font-weight: 900;
            margin-bottom: 14px;
        }

        .hero-info h1 {
            margin: 0 0 12px;
            font-size: 54px;
            line-height: 1.1;
            color: #2d3137;
            font-weight: 900;
        }

        .hero-info p {
            margin: 6px 0;
            color: #4b5563;
            font-size: 16px;
            font-weight: 600;
        }

        .hero-info .highlight {
            color: #1d4ed8;
            font-weight: 800;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            margin-top: 24px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 16px 28px;
            border-radius: 18px;
            text-decoration: none;
            font-weight: 800;
            transition: .25s ease;
        }

        .btn-primary {
            background: #102b57;
            color: white;
            box-shadow: 0 12px 24px rgba(16, 43, 87, 0.18);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #cbd5e1;
            color: #102b57;
        }

        .btn-secondary:hover {
            background: #b8c4d6;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 26px;
        }

        .info-card,
        .medical-card {
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        }

        .info-card {
            background: white;
        }

        .medical-card {
            background: #102b57;
            color: white;
        }

        .section-header {
            margin-bottom: 24px;
        }

        .section-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
        }

        .medical-card .section-header h2 {
            color: #facc15;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info-box {
            background: #f4f4f6;
            border-radius: 18px;
            padding: 18px;
        }

        .info-box span {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-box strong {
            color: #2d3137;
            font-size: 18px;
            font-weight: 800;
        }

        .medical-list {
            display: grid;
            gap: 16px;
        }

        .medical-item {
            display: flex;
            gap: 14px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 18px;
        }

        .medical-icon {
            color: #f87171;
            font-size: 18px;
            padding-top: 2px;
        }

        .medical-item h3 {
            margin: 0 0 6px;
            font-size: 18px;
            font-weight: 800;
        }

        .medical-item p {
            margin: 0;
            color: rgba(255, 255, 255, 0.72);
            font-size: 13px;
            line-height: 1.6;
        }

        .medical-empty {
            text-align: center;
            padding: 40px 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .medical-empty i {
            font-size: 42px;
            margin-bottom: 14px;
            color: #facc15;
        }

        .activity-section {
            margin-top: 36px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 20px;
        }

        .activity-header h2 {
            margin: 0;
            font-size: 34px;
            color: #2d3137;
            font-weight: 900;
        }

        .activity-header a {
            color: #f59e0b;
            font-weight: 700;
            text-decoration: none;
        }

        .activity-header a:hover {
            text-decoration: underline;
        }

        .activity-list {
            display: grid;
            gap: 18px;
        }

        .activity-card {
            background: white;
            border-radius: 24px;
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.05);
            transition: .25s ease;
        }

        .activity-card:hover {
            transform: translateY(-2px);
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .activity-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .activity-info h3 {
            margin: 0 0 4px;
            color: #2d3137;
            font-size: 20px;
            font-weight: 800;
        }

        .activity-info p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
        }

        .activity-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        .activity-right strong {
            color: #2d3137;
            font-size: 18px;
        }

        .status-badge {
            padding: 8px 14px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 800;
        }

        .activity-empty {
            background: white;
            border-radius: 24px;
            padding: 40px 20px;
            text-align: center;
            color: #64748b;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.05);
        }

        .activity-empty i {
            font-size: 42px;
            margin-bottom: 14px;
            color: #94a3b8;
        }

        @media (max-width: 768px) {

            .activity-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .activity-header h2 {
                font-size: 28px;
            }

            .activity-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .activity-right {
                width: 100%;
                align-items: flex-start;
            }
        }

        @media (max-width: 1200px) {

            .hero-info h1 {
                font-size: 42px;
            }
        }

        @media (max-width: 1024px) {

            .profile-grid {
                grid-template-columns: 1fr;
            }

            .hero-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-info h1 {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {

            .profile-page {
                padding: 18px 14px 40px;
            }

            .profile-container {
                padding-top: 90px;
            }

            .hero-card {
                padding: 24px;
            }

            .hero-avatar {
                width: 130px;
                height: 130px;
                font-size: 42px;
            }

            .hero-info h1 {
                font-size: 30px;
            }

            .hero-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

@endsection