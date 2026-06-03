@extends('layout.app')

@php
    $dokterLayout = true;
@endphp

@section('content')

    @php
        // No hardcoded schedules here, we will read from database.
    @endphp

    <section class="pf-section">
        <div class="pf-container">

            {{-- TOP PROFILE CARD --}}
            <div class="pf-hero-card">

                {{-- LEFT: FOTO --}}
                <div class="pf-hero-img">
                    @php
                        $fotoUrl = $dokter->user->foto
                            ? asset('storage/' . $dokter->user->foto)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($dokter->user->nama) . '&background=102b57&color=fff&size=200';
                    @endphp
                    <img src="{{ $fotoUrl }}" alt="{{ $dokter->user->nama }}">
                </div>

                {{-- CENTER: INFO --}}
                <div class="pf-hero-info">
                    <h1>{{ $dokter->user->nama }}</h1>
                    <p class="pf-spesialis">Spesialis {{ $dokter->spesialisasi->nama_spesialisasi ?? '-' }}</p>
                    <div class="pf-role-badge">
                        Dokter {{ $dokter->spesialisasi->nama_spesialisasi ?? 'Umum' }}
                    </div>

                    <div class="pf-meta-grid">
                        <div class="pf-meta-item">
                            <small>SIP DOKTER</small>
                            <strong>{{ $dokter->sip_dokter }}</strong>
                        </div>
                        <div class="pf-meta-item">
                            <small>Pasien Ditangani</small>
                            <strong>{{ $totalPasien }}</strong>
                        </div>
                    </div>

                    <div class="pf-hero-actions">
                        <a href="{{ route('dokter.profil.edit') }}" class="pf-btn pf-btn--yellow">
                            <i class="fa-solid fa-pen"></i> Edit Profil
                        </a>
                    </div>
                </div>

                {{-- RIGHT: STATUS --}}
                <div class="pf-status-mini">
                    <span class="pf-sm-label">STATUS KEGIATAN</span>
                    @php
                        $todaySchedule = $dokter->jadwalDokter->first(function($j) {
                            return strtolower($j->hari) === strtolower(now()->translatedFormat('l'));
                        });
                    @endphp
                    @if($todaySchedule)
                        <h3>Sedang Praktik</h3>
                        <p>Poliklinik Politeknik Negeri Malang</p>
                        <p style="font-size: 11px; margin-top: 4px; color: rgba(255, 255, 255, 0.75);">
                            Jam: {{ substr($todaySchedule->jam_mulai, 0, 5) }} - {{ substr($todaySchedule->jam_selesai, 0, 5) }} WIB
                        </p>
                    @else
                        <h3>Tidak Praktik Hari Ini</h3>
                        <p>Poliklinik Politeknik Negeri Malang</p>
                    @endif
                    <div class="pf-sm-divider"></div>
                    <small>Pasien Hari Ini</small>
                    <span class="pf-sm-num">{{ sprintf('%02d', $pasienHariIni) }}</span>
                    <span class="pf-sm-unit">Pasien</span>
                </div>

            </div>

            {{-- BODY GRID --}}
            <div class="pf-body">

                <div class="pf-body-left">
                    <div class="pf-card">
                        <div class="pf-jadwal-head">
                            <h3 class="pf-card__title" style="margin:0">
                                Jadwal Praktik Mingguan
                            </h3>
                            <span class="pf-jadwal-zone">
                                Zona Waktu: WIB (UTC+7)
                            </span>
                        </div>
                        <div class="pf-jadwal-days">
                            @forelse($dokter->jadwalDokter as $j)
                                @php
                                    $isToday = strtolower($j->hari) === strtolower(now()->translatedFormat('l'));
                                @endphp
                                <div class="pf-day @if($isToday) pf-day--today @endif">
                                    <span class="pf-day__tgl">
                                        {{ strtoupper($j->hari) }}
                                    </span>
                                    <span class="pf-day__hari">
                                        {{ substr($j->hari, 0, 3) }}
                                    </span>
                                    <span class="pf-day__jam">
                                        {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                                    </span>
                                </div>
                            @empty
                                <div style="color: #94a3b8; font-size: 14px; padding: 10px;">
                                    Belum ada jadwal praktik.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="pf-card pf-kontak">
                        <div class="pf-kontak-item">
                            <div class="pf-kontak-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <small>Alamat Email</small>
                                <span>{{ $dokter->user->email }}</span>
                            </div>
                        </div>
                        <div class="pf-kontak-divider"></div>
                        <div class="pf-kontak-item">
                            <div class="pf-kontak-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <small>No. Kontak</small>
                                <span>{{ $dokter->no_hp ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pf-body-right">
                    <div class="pf-stats-card">
                        <h3 class="pf-card__title">
                            Statistik Singkat
                        </h3>
                        <div class="pf-stats-list">
                            <div class="pf-stat-row">
                                <div class="pf-stat-row__icon blue">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="pf-stat-row__body">
                                    <span>Total Pasien</span>
                                    <strong>{{ $totalPasien }}</strong>
                                </div>
                            </div>
                            <div class="pf-stat-row">
                                <div class="pf-stat-row__icon green">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <div class="pf-stat-row__body">
                                    <span>Jadwal Aktif</span>
                                    <strong>{{ $dokter->jadwalDokter->count() }} Hari / Minggu</strong>
                                </div>
                            </div>

                            <div class="pf-stat-row">
                                <div class="pf-stat-row__icon red">
                                    <i class="fa-solid fa-clock"></i>
                                </div>

                                <div class="pf-stat-row__body">
                                    <span>Rata-rata Konsultasi</span>
                                    <strong>15 - 20 Menit</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .pf-section {
            padding: 110px 24px 60px;
            background: #f5f7fb;
        }

        .pf-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .pf-hero-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            background: #fff;
            border-radius: 32px;
            padding: 32px 38px;
            box-shadow: 0 12px 40px rgba(15, 23, 42, .06);
            margin-bottom: 28px;
        }

        .pf-hero-img {
            flex-shrink: 0;
        }

        .pf-hero-img img {
            width: 210px;
            height: 250px;
            border-radius: 28px;
            object-fit: cover;
            border: 4px solid #f6c40b;
        }

        .pf-role-badge {
            width: fit-content;
            margin-top: -12px;
            margin-bottom: 28px;
            padding: 8px 14px;
            border-radius: 999px;
            background: #eef4ff;
            color: #102b57;
            font-size: 12px;
            font-weight: 800;
            border: 1px solid #dbe7ff;
        }

        .pf-hero-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .pf-hero-info h1 {
            margin: 0;
            font-size: 44px;
            line-height: 1.1;
            font-weight: 900;
            color: #102b57;
        }

        .pf-spesialis {
            margin-top: 8px;
            margin-bottom: 28px;
            font-size: 20px;
            color: #64748b;
            font-weight: 500;
        }

        .pf-meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }

        .pf-meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .pf-meta-item small {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .pf-meta-item strong {
            font-size: 15px;
            font-weight: 800;
            color: #102b57;
        }

        .pf-hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pf-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .pf-btn:hover {
            transform: translateY(-1px);
        }

        .pf-btn--yellow {
            background: #f6c40b;
            color: #102b57;
        }

        .pf-btn--yellow:hover {
            box-shadow: 0 6px 18px rgba(246, 196, 11, .35);
        }

        .pf-btn--outline {
            background: #fff;
            color: #102b57;
            border: 1.5px solid #e2e8f0;
        }

        .pf-btn--outline:hover {
            box-shadow: 0 6px 18px rgba(16, 43, 87, .1);
        }

        .pf-status-mini {
            background: #102b57;
            border-radius: 22px;
            padding: 24px;
            color: #fff;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .pf-sm-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, .5);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .pf-status-mini h3 {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 800;
            color: #fff;
        }

        .pf-status-mini p {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, .65);
        }

        .pf-sm-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, .1);
            margin: 16px 0 10px;
        }

        .pf-status-mini small {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255, 255, 255, .5);
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .pf-sm-num {
            font-size: 52px;
            font-weight: 900;
            color: #f6c40b;
            line-height: 1;
            margin-top: 4px;
        }

        .pf-sm-unit {
            font-size: 12px;
            color: rgba(255, 255, 255, .7);
            font-weight: 600;
        }

        .pf-body {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 24px;
            align-items: start;
        }

        .pf-body-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pf-body-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pf-card {
            background: #fff;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(16, 43, 87, .07);
        }

        .pf-card__title {
            margin: 0 0 18px;
            font-size: 17px;
            font-weight: 800;
            color: #102b57;
        }

        .pf-quote {
            margin: 0 0 20px;
            padding: 16px 20px;
            background: #f8fafc;
            border-left: 4px solid #f6c40b;
            border-radius: 0 12px 12px 0;
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
            font-style: italic;
        }

        .pf-edu-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 14px;
        }

        .pf-edu-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            background: #f8fafc;
            border-radius: 14px;
            padding: 14px 16px;
        }

        .pf-edu-item small {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .pf-edu-item strong {
            font-size: 14px;
            font-weight: 700;
            color: #102b57;
        }

        .pf-jadwal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .pf-jadwal-zone {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
        }

        .pf-jadwal-days {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .pf-jadwal-days::-webkit-scrollbar {
            display: none;
        }

        .pf-day {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            border-radius: 14px;
            padding: 12px 10px;
            min-width: 72px;
            text-align: center;
        }

        .pf-day__tgl {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 600;
            white-space: nowrap;
        }

        .pf-day__hari {
            font-size: 14px;
            font-weight: 800;
            color: #102b57;
        }

        .pf-day__jam {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            white-space: nowrap;
        }

        .pf-day--today {
            background: #f6c40b;
        }

        .pf-day--today .pf-day__tgl,
        .pf-day--today .pf-day__hari,
        .pf-day--today .pf-day__jam {
            color: #102b57;
        }

        .pf-day--upcoming {
            opacity: .55;
        }

        /* KONTAK */
        .pf-kontak {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .pf-kontak-item {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pf-kontak-icon {
            width: 40px;
            height: 40px;
            background: #eef4ff;
            color: #2d5bff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .pf-kontak-item small {
            display: block;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 2px;
        }

        .pf-kontak-item span {
            font-size: 13px;
            font-weight: 700;
            color: #102b57;
        }

        .pf-kontak-divider {
            width: 1px;
            height: 40px;
            background: #e2e8f0;
            margin: 0 18px;
            flex-shrink: 0;
        }

        /* STATS CARD */
        .pf-stats-card {
            background: #fff;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(16, 43, 87, .07);
        }

        .pf-stats-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .pf-stat-row {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #f8fafc;
            border-radius: 14px;
            padding: 14px 16px;
        }

        .pf-stat-row__icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .pf-stat-row__icon.blue {
            background: #e7efff;
            color: #2d5bff;
        }

        .pf-stat-row__icon.yellow {
            background: #fff9e0;
            color: #c8980a;
        }

        .pf-stat-row__icon.green {
            background: #dcfce7;
            color: #15803d;
        }

        .pf-stat-row__icon.red {
            background: #fee2e2;
            color: #dc2626;
        }

        .pf-stat-row__body {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .pf-stat-row__body span {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }

        .pf-stat-row__body strong {
            font-size: 15px;
            font-weight: 800;
            color: #102b57;
        }

        /* QUICK CARD */
        .pf-quick-card {
            background: #fff;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(16, 43, 87, .07);
        }

        .pf-quick-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pf-quick-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8fafc;
            border-radius: 14px;
            padding: 14px 16px;
            text-decoration: none;
            color: #102b57;
            font-size: 14px;
            font-weight: 600;
            transition: background .2s;
        }

        .pf-quick-item:hover {
            background: #eef4ff;
        }

        .pf-quick-item>i:first-child {
            width: 20px;
            color: #2d5bff;
            font-size: 16px;
            text-align: center;
        }

        .pf-quick-arrow {
            margin-left: auto;
            font-size: 12px;
            color: #94a3b8;
        }

    @media (max-width: 1024px){

        .pf-hero-card{
            flex-wrap:wrap;
            gap:24px;
            padding:28px;
        }

        .pf-hero-img img{
            width:180px;
            height:220px;
        }

        .pf-status-mini{
            width:100%;
            flex-direction:row;
            justify-content:space-between;
            align-items:center;
        }

        .pf-sm-divider{
            width:1px;
            height:50px;
            margin:0 16px;
        }

        .pf-body{
            grid-template-columns:1fr;
        }
    }

    @media (max-width: 768px){

        .pf-section{
            padding:90px 12px 40px;
        }

        .pf-container{
            padding:0;
        }

        .pf-hero-card{
            flex-direction:column;
            text-align:center;
            padding:22px;
            border-radius:24px;
        }

        .pf-hero-img{
            width:100%;
            display:flex;
            justify-content:center;
        }

        .pf-hero-img img{
            width:150px;
            height:180px;
        }

        .pf-hero-info{
            align-items:center;
        }

        .pf-hero-info h1{
            font-size:38px;
        }

        .pf-spesialis{
            font-size:18px;
            margin-bottom:18px;
        }

        .pf-role-badge{
            margin:0 0 20px;
        }

        .pf-meta-grid{
            grid-template-columns:1fr;
            text-align:center;
            width:100%;
        }

        .pf-hero-actions{
            justify-content:center;
            width:100%;
        }

        .pf-btn{
            width:100%;
            justify-content:center;
        }

        .pf-status-mini{
            width:100%;
            flex-direction:column;
            align-items:center;
            text-align:center;
        }

        .pf-sm-divider{
            width:100%;
            height:1px;
            margin:10px 0;
        }

        .pf-jadwal-head{
            flex-direction:column;
            align-items:flex-start;
            gap:8px;
        }

        .pf-kontak{
            flex-direction:column;
            align-items:flex-start;
        }

        .pf-kontak-divider{
            width:100%;
            height:1px;
            margin:0;
        }
    }

    @media (max-width: 375px){

        .pf-hero-info h1{
            font-size:30px;
        }

        .pf-spesialis{
            font-size:16px;
        }

        .pf-hero-img img{
            width:120px;
            height:150px;
        }

        .pf-card,
        .pf-stats-card{
            padding:18px;
        }

        .pf-sm-num{
            font-size:42px;
        }
    }
    </style>

@endsection