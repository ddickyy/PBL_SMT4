@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')

@php
    $user = auth()->user();
@endphp

<section class="profile-page">
    <div class="profile-container">
        <div class="hero-card">
            <div class="hero-avatar">
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                @else
                    <div class="profile-initials">
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    </div>
                @endif
            </div>

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

                <h1>
                    {{ $user->nama }}
                </h1>

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

                @if($user->dosen)
                    <p>
NIDN:
                        {{ $user->dosen->nidn }}
                    </p>

                    <p class="highlight">
                        Dosen Politeknik Negeri Malang
                    </p>
                @endif

                @if($user->tendik)

                    <p>
                        NIP:
                        {{ $user->tendik->nip }}
                    </p>

                    <p class="highlight">
                        {{ optional($user->tendik->jabatan)->nama_jabatan }}
                    </p>

                @endif

                <div class="hero-actions">

                    <a href="{{ route('pasien.profil.edit') }}"
                       class="btn-primary">

                        Edit Profil

                    </a>

                </div>

            </div>

        </div>

        <div class="profile-grid">

            <div class="info-card">

                <div class="section-header">

                    <h2>

                        <i class="fa-solid fa-user-graduate"></i>

                        Informasi Akun

                    </h2>

                </div>

                <div class="info-grid">

                    @if($user->mahasiswa)

                        <div class="info-box">

                            <span>
                                Program Studi
                            </span>

                            <strong>

                                {{ optional($user->mahasiswa->prodi)->nama_prodi }}

                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Status
                            </span>

                            <strong>
                                Mahasiswa
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Email
                            </span>

                            <strong>
                                {{ $user->email }}
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Nomor HP
                            </span>

                            <strong>
                                {{ $user->mahasiswa->no_hp }}
                            </strong>

                        </div>

                    @endif

                    @if($user->dosen)

                        <div class="info-box">

                            <span>
                                Status
                            </span>

                            <strong>
                                Dosen
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Email
                            </span>

                            <strong>
                                {{ $user->email }}
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                NIDN
                            </span>

                            <strong>
                                {{ $user->dosen->nidn }}
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Nomor HP
                            </span>

                            <strong>
                                {{ $user->dosen->no_hp }}
                            </strong>

                        </div>

                    @endif

                    @if($user->tendik)

                        <div class="info-box">

                            <span>
                                Status
                            </span>

                            <strong>
                                Tendik
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Jabatan
                            </span>

                            <strong>

                                {{ optional($user->tendik->jabatan)->nama_jabatan }}

                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Email
                            </span>

                            <strong>
                                {{ $user->email }}
                            </strong>

                        </div>

                        <div class="info-box">

                            <span>
                                Nomor HP
                            </span>

                            <strong>
                                {{ $user->tendik->no_hp }}
                            </strong>

                        </div>

                    @endif

                </div>

            </div>

            <div class="medical-card">

                <div class="section-header">

                    <h2>
                        Rekam Medis
                    </h2>

                </div>

                <div class="medical-list">

                    @forelse($rekamMedis ?? [] as $item)

                        <div class="medical-item">

                            <div class="medical-icon">

                                <i class="fa-solid fa-file-medical"></i>

                            </div>

                            <div style="flex: 1;">

                                <div class="medical-meta">

                                    <h3>
                                        {{ $item->diagnosis }}
                                    </h3>

                                    <span class="medical-date">
                                        {{ \Carbon\Carbon::parse($item->tanggal_periksa)->translatedFormat('d M Y') }}
                                    </span>

                                </div>

                                <p>
                                    {{ $item->catatan ?? '-' }}
                                </p>

                                <div class="medical-doc">

                                    <i class="fa-solid fa-user-md"></i>

                                    <span>
                                        {{ optional($item->dokter->user)->nama ?? 'Dokter' }}
                                        @if(optional($item->dokter->spesialisasi)->nama_spesialisasi)
                                            ({{ optional($item->dokter->spesialisasi)->nama_spesialisasi }})
                                        @endif
                                    </span>

                                </div>

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

                @if($rekamMedis->hasPages())
                    <div class="pagination-wrap" style="margin-top: 20px;">
                        {{ $rekamMedis->appends(request()->except('page_rekam'))->links() }}
                    </div>
                @endif

            </div>

        </div>

        <div class="activity-section">

            <div class="activity-header">

                <h2>
                    Aktivitas Terakhir
                </h2>

                <a href="{{ route('pasien.riwayat') }}">
                    Lihat Semua Riwayat
                </a>

            </div>

            @if(($aktivitasReservasi ?? collect())->count())

                <div class="activity-grid">

                    @foreach($aktivitasReservasi as $item)

                        @php

                            $statusClass = match($item->status) {

                                'menunggu' =>
                                    'badge-menunggu',

                                'dikonfirmasi' =>
                                    'badge-dikonfirmasi',

                                'selesai' =>
                                    'badge-selesai',

                                'done' =>
                                    'badge-selesai',

                                'dibatalkan' =>
                                    'badge-batal',

                                default =>
                                    'badge-dikonfirmasi'
                            };

                            $namaDokter =
                                optional(
                                    optional(
                                        $item->jadwal
                                    )->dokter->user
                                )->nama ?? 'Dokter';

                            $spesialisasi =
                                optional(
                                    optional(
                                        $item->jadwal
                                    )->dokter
                                )->spesialisasi
                                    ->nama_spesialisasi ?? 'Poliklinik';

                        @endphp

                        <a href="{{ route('pasien.reservasi.show', $item->id_reservasi) }}"
                           class="activity-card-link">

                            <div class="activity-card">

                                <div class="activity-left">

                                    <div class="activity-icon">

                                        <i class="fa-solid fa-stethoscope"></i>

                                    </div>

                                    <div class="activity-info">

                                        <h3>
                                            {{ $spesialisasi }}
                                        </h3>

                                        <p>
                                            {{ $namaDokter }}
                                        </p>

                                        <div class="activity-meta">

                                            <span>

                                                {{ \Carbon\Carbon::parse($item->tanggal_reservasi)
                                                    ->locale('id')
                                                    ->translatedFormat('l, d F Y') }}

                                            </span>

                                            @if($item->estimasi_jam)
                                                <span class="dot"></span>

                                                <span>

                                                    {{ \Carbon\Carbon::parse($item->estimasi_jam)
                                                        ->format('H:i') }}
                                                    WIB

                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                                <div class="activity-right">

                                    <div class="activity-antrian">

                                        {{ $item->nomor_antrian }}

                                    </div>

                                    <span class="status-badge {{ $statusClass }}">

                                        <span class="status-badge-dot"></span>

                                        {{ strtoupper($item->status) }}

                                    </span>

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

                @if($aktivitasReservasi->hasPages())

                    <div class="pagination-wrap">

                        {{ $aktivitasReservasi->appends(request()->except('page_aktivitas'))->links() }}

                    </div>

                @endif

            @else

                <div class="activity-empty">

                    <div class="activity-empty-icon">

                        <i class="fa-regular fa-calendar-xmark"></i>

                    </div>

                    <h3>
                        Belum Ada Aktivitas Reservasi
                    </h3>

                    <p>
                        Aktivitas reservasi Anda akan muncul di sini.
                    </p>

                </div>

            @endif

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
    box-shadow: 0 10px 25px rgba(16, 43, 87, 0.15);
}

.hero-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #102b57;
    color: white;
    font-weight: 900;
    text-transform: uppercase;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
    width: 100%;
    height: 100%;
    font-size: 64px;
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

.highlight {
    color: #1d4ed8;
    font-weight: 800;
}

.hero-actions {
    margin-top: 24px;
}

.btn-primary {
    padding: 16px 28px;
    border-radius: 18px;
    text-decoration: none;
    font-weight: 800;
    background: #102b57;
    color: white;
    display: inline-flex;
    transition: .25s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
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
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    padding: 18px;
}

.medical-icon {
    color: #facc15;
    font-size: 20px;
}

.medical-item h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 800;
    color: #ffffff;
}

.medical-meta {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
    gap: 8px;
}

.medical-date {
    font-size: 12px;
    color: rgba(255,255,255,.6);
    font-weight: 600;
}

.medical-doc {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #facc15;
    font-weight: 700;
    margin-top: 10px;
}

.medical-doc i {
    font-size: 13px;
}

.medical-item p {
    margin: 0;
    color: rgba(255,255,255,.72);
    font-size: 13px;
    line-height: 1.6;
}

.medical-empty {
    text-align: center;
    padding: 40px 20px;
    color: rgba(255,255,255,.7);
}

.medical-empty i {
    font-size: 42px;
    margin-bottom: 14px;
    color: #facc15;
}

.activity-section {
    margin-top: 36px;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
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

.activity-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

.activity-card-link {
    text-decoration: none;
    color: inherit;
}

.activity-card {
    background: white;
    border-radius: 24px;
    padding: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    border: 1.5px solid #eef0f5;
    box-shadow: 0 14px 32px rgba(15,23,42,.05);
    transition: .25s ease;
}

.activity-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 48px rgba(16,43,87,.12);
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
}

.activity-info h3 {
    margin: 0 0 4px;
    color: #102b57;
    font-size: 20px;
    font-weight: 900;
}

.activity-info p {
    margin: 0 0 10px;
    color: #64748b;
    font-size: 14px;
}

.activity-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
}

.dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #cbd5e1;
}

.activity-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
}

.activity-antrian {
    background: #f7f8fc;
    border: 1.5px solid #eef0f5;
    border-radius: 14px;
    padding: 10px 16px;
    font-size: 18px;
    font-weight: 900;
    color: #102b57;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
}

.status-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.badge-menunggu {
    background: #fef9e0;
    color: #b59008;
}

.badge-menunggu .status-badge-dot {
    background: #f6c40b;
}

.badge-dikonfirmasi {
    background: #eef2ff;
    color: #1d4ed8;
}

.badge-dikonfirmasi .status-badge-dot {
    background: #3b82f6;
}

.badge-selesai {
    background: #ecfdf5;
    color: #15803d;
}

.badge-selesai .status-badge-dot {
    background: #22c55e;
}

.badge-batal {
    background: #fff0f0;
    color: #dc2626;
}

.badge-batal .status-badge-dot {
    background: #ef4444;
}

.activity-empty {
    width: 100%;
    background: white;
    border-radius: 24px;
    padding: 54px 24px;
    text-align: center;
    border: 1.5px solid #eef0f5;
    box-shadow: 0 10px 34px rgba(16,43,87,.07);
}

.activity-empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 14px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5fb;
    color: #94a3b8;
    font-size: 26px;
}

.activity-empty h3 {
    margin-bottom: 8px;
    color: #102b57;
}

.activity-empty p {
    color: #64748b;
}

.pagination-wrap {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination-wrap svg {
    width: 18px;
    height: 18px;
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

    .info-grid,
    .activity-grid {
        grid-template-columns: 1fr;
    }

    .activity-header {
        flex-direction: column;
        align-items: flex-start;
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

</style>

@endsection