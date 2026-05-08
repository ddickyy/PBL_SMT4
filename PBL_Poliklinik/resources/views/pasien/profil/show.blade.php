@extends('layout.app')
@section('partial.navbar')

@section('title', 'Profil Mahasiswa')
@endsection

@section('content')
    @php
        $profil = [
            'nama' => 'Sheilandra Zarawiba',
            'nim' => '2100000000',
            'prodi' => 'Teknik Informatika',
            'jurusan' => 'Teknologi Informasi',
            'angkatan' => '2024',
            'status' => 'Mahasiswa Aktif',
            'email' => 'xx@gmail.com',
            'avatar' => null,
        ];

        $rekamMedis = [
            [
                'judul' => 'Alergi Paracetamol',
                'kategori' => 'Alergi',
                'detail' => 'Reaksi: Ruam & gatal',
                'ikon' => 'fa-triangle-exclamation',
                'warna' => 'danger',
            ],
            [
                'judul' => 'Alergi Antibiotik',
                'kategori' => 'Alergi',
                'detail' => 'Reaksi: Sesak napas',
                'ikon' => 'fa-triangle-exclamation',
                'warna' => 'danger',
            ],
            [
                'judul' => 'Maag',
                'kategori' => 'Penyakit',
                'detail' => 'Terakhir kontrol: 12 Jan 2025',
                'ikon' => 'fa-notes-medical',
                'warna' => 'warning',
            ],
        ];

        $aktivitas = [
            [
                'judul' => 'Pemeriksaan Umum',
                'subjudul' => 'Poliklinik - Dr. Satra',
                'tanggal' => '12 Okt 2025',
                'status' => 'Selesai',
                'ikon' => 'fa-kit-medical',
            ],
            [
                'judul' => 'Pengambilan Surat Sehat',
                'subjudul' => 'Poliklinik',
                'tanggal' => '05 Okt 2025',
                'status' => 'Selesai',
                'ikon' => 'fa-file-medical',
            ],
        ];
    @endphp

    <section class="profile-page">
        <div class="page-container">

            {{-- HERO / PROFILE CARD --}}

            <div class="hero-section">
                <div class="profile-hero card">
                    <div class="profile-avatar-wrap">
                        @if(!empty($profil['avatar']))
                            <img src="{{ $profil['avatar'] }}" alt="Foto Profil" class="profile-avatar">
                        @else
                            <div class="profile-avatar profile-avatar-placeholder">
                                <span>{{ strtoupper(substr($profil['nama'], 0, 1)) }}</span>
                            </div>
                        @endif

                        <button type="button" class="avatar-edit" aria-label="Edit Foto">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </div>

                    <div class="profile-main">
                        <span class="badge-status">
                            {{ $profil['status'] }}
                        </span>

                        <h1>Nama: {{ $profil['nama'] }}</h1>
                        <p class="profile-meta">NIM: {{ $profil['nim'] }}</p>
                        <p class="profile-meta prodi">Prodi: {{ $profil['prodi'] }}</p>

                        <div class="profile-actions">
                            <a href="{{ route('pasien.profil.edit') }}" class="btn-primary">
                                Edit Profil
                            </a>

                            <a href="{{ route('pasien.reservasi') }}" class="btn-secondary">
                                Buat Janji
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-grid">
                {{-- INFORMASI AKADEMIK --}}
                <div class="card info-card">
                    <div class="section-title">
                        <div class="section-icon orange">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <h2>Informasi Akademik</h2>
                    </div>

                    <div class="info-box-grid">
                        <div class="info-box">
                            <span>JURUSAN</span>
                            <strong>{{ $profil['jurusan'] }}</strong>
                        </div>

                        <div class="info-box">
                            <span>ANGKATAN</span>
                            <strong>{{ $profil['angkatan'] }}</strong>
                        </div>

                        <div class="info-box">
                            <span>STATUS</span>
                            <strong class="text-blue">{{ $profil['status'] }}</strong>
                        </div>

                        <div class="info-box">
                            <span>EMAIL</span>
                            <strong>{{ $profil['email'] }}</strong>
                        </div>
                    </div>
                </div>

                {{-- REKAM MEDIS --}}
                <div class="card medical-card">
                    <div class="section-title light">
                        <div class="section-icon yellow">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        <h2>Rekam Medis</h2>
                    </div>

                    <div class="medical-list">
                        @forelse($rekamMedis as $item)
                            <div class="medical-item">
                                <div class="medical-item-left">
                                    <div class="medical-icon {{ $item['warna'] }}">
                                        <i class="fa-solid {{ $item['ikon'] }}"></i>
                                    </div>

                                    <div>
                                        <h3>{{ $item['judul'] }}</h3>
                                        <p>{{ $item['kategori'] }} • {{ $item['detail'] }}</p>
                                    </div>
                                </div>

                                <button type="button" class="plus-box" aria-label="Tambah">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        @empty
                            <div class="empty-state small">
                                <i class="fa-solid fa-folder-open"></i>
                                <h3>Belum Ada Rekam Medis</h3>
                                <p>Data rekam medis belum tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- AKTIVITAS TERAKHIR --}}
            <div class="section-header-row">
                <h2>Aktivitas Terakhir</h2>
                <a href="{{ route('pasien.riwayat') }}">Lihat Semua Riwayat</a>
            </div>

            <div class="activity-list">
                @forelse($aktivitas as $item)
                    <div class="activity-item">
                        <div class="activity-left">
                            <div class="activity-icon">
                                <i class="fa-solid {{ $item['ikon'] }}"></i>
                            </div>

                            <div>
                                <h3>{{ $item['judul'] }}</h3>
                                <p>{{ $item['subjudul'] }}</p>
                            </div>
                        </div>

                        <div class="activity-right">
                            <strong>{{ $item['tanggal'] }}</strong>
                            <span class="status-pill">{{ $item['status'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <h3>Belum Ada Aktivitas</h3>
                        <p>Riwayat aktivitas akan tampil di sini setelah Anda menggunakan layanan poliklinik.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <style>
        .profile-page {
            padding: 28px 24px 64px;
            background: #f5f7fb;
        }

        .page-container {
            width: 100%;
        }

        .card {
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        }

        .hero-section {
            background: #f3f4f6;
            padding-top: 100px;
        }

        .profile-hero {
            display: flex;
            position: relative;
            width: 100%;
            align-items: center;
            gap: 34px;
            padding: 34px;
            margin-bottom: 28px;
        }

        .profile-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .profile-avatar {
            width: 210px;
            height: 210px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            border: 4px solid #fbe4e6;
            background: #102b57;
        }

        .profile-avatar-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 72px;
            font-weight: 900;
            color: #fff;
        }

        .avatar-edit {
            position: absolute;
            right: 8px;
            bottom: 12px;
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15);
            color: #facc15;
            cursor: pointer;
        }

        .profile-main h1 {
            margin: 12px 0 8px;
            font-size: 56px;
            line-height: 1.05;
            font-weight: 900;
            color: #2d3137;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            background: #facc15;
            color: #102b57;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
        }

        .profile-meta {
            margin: 0;
            font-size: 20px;
            color: #5a6170;
            line-height: 1.7;
        }

        .profile-meta.prodi {
            color: #33559a;
            font-weight: 700;
        }

        .profile-actions {
            display: flex;
            gap: 14px;
            margin-top: 26px;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary {
            text-decoration: none;
            border-radius: 16px;
            padding: 14px 28px;
            font-weight: 800;
            transition: .25s ease;
        }

        .btn-primary {
            background: #102b57;
            color: #fff;
            box-shadow: 0 10px 24px rgba(16, 43, 87, .14);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #aeb7c8;
            color: #102b57;
        }

        .btn-secondary:hover {
            background: #98a3b7;
            transform: translateY(-2px);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }

        .info-card,
        .medical-card {
            padding: 26px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .section-title h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #2d3137;
        }

        .section-title.light h2 {
            color: #fff;
        }

        .section-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
        }

        .section-icon.orange {
            color: #f59e0b;
        }

        .section-icon.yellow {
            color: #facc15;
        }

        .medical-card {
            background: #102b57;
            color: #fff;
        }

        .info-box-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 14px;
            padding: 16px 14px;
        }

        .info-box span {
            display: block;
            font-size: 11px;
            font-weight: 800;
            color: #8892a6;
            letter-spacing: .08em;
            margin-bottom: 4px;
        }

        .info-box strong {
            font-size: 16px;
            color: #2d3137;
            line-height: 1.4;
        }

        .text-blue {
            color: #33559a !important;
        }

        .medical-list {
            display: grid;
            gap: 12px;
        }

        .medical-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 16px;
            padding: 14px 16px;
        }

        .medical-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .medical-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 15px;
        }

        .medical-icon.danger {
            color: #ef4444;
            background: rgba(239, 68, 68, .12);
        }

        .medical-icon.warning {
            color: #facc15;
            background: rgba(250, 204, 21, .12);
        }

        .medical-item h3 {
            margin: 0 0 3px;
            font-size: 15px;
            color: #fff;
        }

        .medical-item p {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, .58);
        }

        .plus-box {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .14);
            background: rgba(255, 255, 255, .04);
            color: #facc15;
            font-size: 18px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .section-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 18px 0 16px;
        }

        .section-header-row h2 {
            margin: 0;
            font-size: 30px;
            font-weight: 900;
            color: #2d3137;
        }

        .section-header-row a {
            color: #f7b500;
            font-weight: 700;
            text-decoration: none;
        }

        .activity-list {
            display: grid;
            gap: 14px;
        }

        .activity-item {
            background: #fff;
            border-radius: 22px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.04);
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: #dce6ff;
            color: #102b57;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-left h3 {
            margin: 0;
            font-size: 16px;
            color: #2d3137;
        }

        .activity-left p {
            margin: 4px 0 0;
            font-size: 13px;
            color: #8b93a3;
        }

        .activity-right {
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-end;
        }

        .activity-right strong {
            color: #2d3137;
            font-size: 14px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            background: #dbe4ff;
            color: #a7b4d5;
            border-radius: 999px;
            padding: 5px 11px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
        }

        .empty-state {
            background: #fff;
            border-radius: 22px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.04);
            color: #6f7380;
        }

        .empty-state.small {
            padding: 28px 18px;
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, .72);
            box-shadow: none;
        }

        .empty-state i {
            font-size: 32px;
            margin-bottom: 10px;
            color: #9fb2df;
        }

        .empty-state h3 {
            margin: 0 0 8px;
            font-size: 18px;
            color: inherit;
        }

        .empty-state p {
            margin: 0;
            line-height: 1.7;
            color: inherit;
        }

        @media (max-width: 1100px) {
            .profile-hero {
                align-items: flex-start;
            }

            .profile-main h1 {
                font-size: 42px;
            }

            .profile-avatar {
                width: 170px;
                height: 170px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .profile-page {
                padding: 18px 14px 50px;
            }

            .profile-hero {
                flex-direction: column;
                padding: 24px;
            }

            .profile-main h1 {
                font-size: 30px;
            }

            .profile-meta {
                font-size: 16px;
            }

            .profile-avatar {
                width: 140px;
                height: 140px;
            }

            .profile-actions {
                width: 100%;
            }

            .btn-primary,
            .btn-secondary {
                flex: 1;
                text-align: center;
            }

            .section-header-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .activity-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .activity-right {
                align-items: flex-start;
                text-align: left;
            }

            .info-box-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection