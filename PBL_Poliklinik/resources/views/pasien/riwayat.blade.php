@extends('layout.app')

@section('title', 'Riwayat Reservasi')

@section('hero')
    @include('partial.hero', [
        'badge'      => 'Layanan Kesehatan',
        'title'      => "Riwayat\nReservasi",
        'desc'       => "Pantau status reservasi aktif Anda dan lihat riwayat kunjungan medis sebelumnya secara mudah.",
        'buttonText' => null,
        'bg'         => asset('images/poliklinik.jpg')
    ])
@endsection

@section('content')

@php

    use Carbon\Carbon;

    Carbon::setLocale('id');

@endphp

<section class="riwayat-page">
    <div class="riwayat-wrap">

    @if(session('success'))
        <div class="alert-success" style="background: #dcfce7; color: #15803d; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 700;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error" style="background: #fee2e2; color: #dc2626; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 700;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="riwayat-container-box">

            <div class="riwayat-section-header">

                <div class="riwayat-section-meta">

                    <svg class="riwayat-section-icon"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>

                    <h2 class="riwayat-section-title">
                        Reservasi Aktif
                    </h2>

                </div>

            </div>

            @if($reservasiAktif->count())

                <div class="reservasi-aktif-grid">

                    @foreach($reservasiAktif as $item)

                        @php

                            $badgeClass = match($item->status) {

                                'menunggu' =>
                                    'badge-menunggu',

                                'dikonfirmasi' =>
                                    'badge-dikonfirmasi',

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
                                    ->nama_spesialisasi ?? '-';

                        @endphp

                        <a href="{{ route('pasien.reservasi.show', $item->id_reservasi) }}"
                           class="aktif-card-link">

                            <div class="aktif-card">

                                <div class="activity-main-layout">
                                    <div class="activity-left">
                                        <div class="activity-icon">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </div>
                                        <div class="activity-info">
                                            <h3>{{ $spesialisasi }}</h3>
                                            <p>{{ $namaDokter }}</p>
                                            <div class="activity-meta">
                                                <span>
                                                    {{ Carbon::parse($item->tanggal_reservasi)
                                                        ->locale('id')
                                                        ->translatedFormat('l, d F Y') }}
                                                </span>
                                                <span class="dot"></span>
                                                <span>
                                                    {{ Carbon::parse($item->estimasi_jam)->format('H:i') }} WIB
                                                </span>
                                            </div>
                                            <div class="aktif-cta" style="margin-top: 8px;">
                                                Klik untuk melihat bukti reservasi
                                            </div>
                                        </div>
                                    </div>

                                    <div class="activity-right">
                                        <div class="activity-antrian">
                                            {{ $item->nomor_antrian }}
                                        </div>
                                        <span class="status-badge {{ $badgeClass }}">
                                            <span class="status-badge-dot"></span>
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="empty-riwayat">

                    <div class="empty-icon">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>

                    <h3>
                        Belum Ada Reservasi Aktif
                    </h3>

                    <p>
                        Anda belum memiliki reservasi aktif saat ini.
                    </p>

                </div>

            @endif

    </div>

    <div class="riwayat-container-box">

            <div class="riwayat-section-header">

                <div class="riwayat-section-meta">

                    <svg class="riwayat-section-icon"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>

                    <h2 class="riwayat-section-title">
                        Riwayat Reservasi
                    </h2>

                </div>

                <!-- Sorting Form -->
                <form action="{{ route('pasien.riwayat') }}" method="GET" class="filter-form">
                    <div class="filter-group">
                        <i class="fa-solid fa-sort filter-icon"></i>
                        <select name="sort" onchange="this.form.submit()" class="filter-select">
                            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Tanggal Terbaru</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Tanggal Terlama</option>
                        </select>
                    </div>
                </form>

            </div>

            @if($riwayatSelesai->count())

                <div class="riwayat-grid">

                    @foreach($riwayatSelesai as $item)

                        @php

                            $badgeClass = match($item->status) {

                                'selesai' =>
                                    'badge-selesai',

                                'done' =>
                                    'badge-selesai',

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
                                    ->nama_spesialisasi ?? '-';

                        @endphp

                        <a href="{{ route('pasien.reservasi.show', $item->id_reservasi) }}"
                           class="aktif-card-link">
                            <div class="riwayat-card">

                                <div class="activity-main-layout">
                                    <div class="activity-left">
                                        <div class="activity-icon">
                                            <i class="fa-solid fa-stethoscope"></i>
                                        </div>
                                        <div class="activity-info">
                                            <h3>{{ $spesialisasi }}</h3>
                                            <p>{{ $namaDokter }}</p>
                                            <div class="activity-meta">
                                                <span>
                                                    {{ Carbon::parse($item->tanggal_reservasi)
                                                        ->locale('id')
                                                        ->translatedFormat('l, d F Y') }}
                                                </span>
                                                <span class="dot"></span>
                                                <span>
                                                    {{ Carbon::parse($item->estimasi_jam)->format('H:i') }} WIB
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="activity-right">
                                        <div class="activity-antrian">
                                            {{ $item->nomor_antrian }}
                                        </div>
                                        <span class="status-badge {{ $badgeClass }}">
                                            <span class="status-badge-dot"></span>
                                            {{ strtoupper($item->status) }}
                                        </span>
                                    </div>
                                </div>

                                @if($item->rekamMedis)
                                    <div class="riwayat-medical-info">
                                        <div class="medical-icon">
                                            <i class="fa-solid fa-file-medical"></i>
                                        </div>
                                        <div class="medical-body">
                                            <div class="medical-meta">
                                                <h3>{{ $item->rekamMedis->diagnosis }}</h3>
                                            </div>
                                            <p>{{ $item->rekamMedis->catatan ?? '-' }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($item->status === 'selesai' || $item->status === 'done')
                                    <div class="riwayat-actions" style="margin-top: 4px; width: 100%;">
                                        @if(!$item->penilaian)
                                            <div class="btn-penilaian">
                                                Berikan Penilaian
                                            </div>
                                        @else
                                            <div style="display: flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 18px; border-radius: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; font-size: 13px; font-weight: 700; width: 100%; box-sizing: border-box;">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <span>Sudah Dinilai</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        </a>

                    @endforeach

                </div>

                @if($riwayatSelesai->hasPages())

                    <div class="pagination-wrap">

                        {{ $riwayatSelesai->links() }}

                    </div>

                @endif

            @else

                <div class="empty-riwayat">

                    <div class="empty-icon">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </div>

                    <h3>
                        Belum Ada Riwayat Reservasi
                    </h3>

                    <p>
                        Anda belum pernah melakukan reservasi selesai.
                    </p>

                </div>

            @endif

    </div>

</section>

<style>

    .riwayat-page {
        background: #f5f7fb;
        padding: 40px 0 80px;
        min-height: 80vh;
    }

    .riwayat-wrap {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .riwayat-container-box {
        background: white;
        border-radius: 28px;
        padding: 42px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.05);
        border: 1.5px solid #eef0f5;
        margin-top: 10px;
    }
    .riwayat-container-box:not(:last-child) {
        margin-bottom: 28px;
    }

    .riwayat-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .riwayat-section-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .riwayat-section-icon {
        width: 20px;
        height: 20px;
        color: #102b57;
    }

    .riwayat-section-title {
        font-size: 1.45rem;
        font-weight: 900;
        color: #102b57;
    }

    .reservasi-aktif-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .aktif-card-link {
        text-decoration: none;
        color: inherit;
    }

    .aktif-card,
    .riwayat-card {
        background: #f8fafc;
        border-radius: 24px;
        padding: 24px;
        border: 1.5px solid #eef2f6;
        box-shadow: none;
        transition: .25s ease;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .aktif-card:hover,
    .riwayat-card:hover {
        transform: translateY(-3px);
        background: white;
        border-color: #cbd5e1;
        box-shadow: 0 14px 32px rgba(16,43,87,.08);
    }

    .activity-main-layout {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        width: 100%;
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
        color: #102b57;
        font-size: 20px;
        font-weight: 900;
    }

    .activity-info p {
        margin: 0 0 4px;
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

    .aktif-cta {
        font-size: 12px;
        font-weight: 700;
        color: #b59008;
    }

    .activity-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        flex-shrink: 0;
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

    .riwayat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        padding: 3px 8px;
        border-radius: 999px;

        font-size: 10px;
        font-weight: 800;
        line-height: 1;
    }

    .status-badge-dot {
        width: 5px;
        height: 5px;
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

    .empty-riwayat {
        width: 100%;
        max-width: 1400px;

        background: white;

        border-radius: 24px;

        padding: 54px 24px;

        text-align: center;

        border: 1.5px solid #eef0f5;

        box-shadow:
            0 10px 34px rgba(16,43,87,.07);
    }

    .empty-icon {
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

    .empty-riwayat h3 {
        margin-bottom: 8px;
        color: #102b57;
    }

    .empty-riwayat p {
        color: #64748b;
    }

    .btn-penilaian {
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 12px 18px;

        border-radius: 14px;

        background: #102b57;
        color: white;

        font-size: .88rem;
        font-weight: 800;

        text-decoration: none;

        transition: .2s ease;
    }

    .btn-penilaian:hover {
        background: #0d2247;
        transform: translateY(-2px);
    }

    .riwayat-medical-info {
        display: flex;
        gap: 12px;
        background: #f8fafc;
        border: 1.5px solid #edf0f5;
        border-radius: 12px;
        padding: 10px 14px;
        margin-bottom: 4px;
        box-shadow: inset 0 2px 4px rgba(15, 23, 42, 0.02);
    }

    .riwayat-medical-info .medical-icon {
        color: #1d4ed8;
        font-size: 16px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .riwayat-medical-info .medical-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .riwayat-medical-info .medical-meta h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 800;
        color: #102b57;
    }

    .riwayat-medical-info .medical-body p {
        margin: 0;
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        border: 1.5px solid #edf0f5;
        border-radius: 12px;
        padding: 8px 14px;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.03);
        transition: border-color .2s ease;
    }

    .filter-group:hover {
        border-color: #cbd5e1;
    }

    .filter-icon {
        color: #102b57;
        font-size: 13px;
    }

    .filter-select {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        font-weight: 700;
        color: #102b57;
        cursor: pointer;
        padding-right: 4px;
        font-family: inherit;
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

    @media (max-width: 768px)
    {
        .riwayat-wrap {
            padding: 0 18px;
        }

        .riwayat-container-box {
            padding: 24px 20px;
            border-radius: 20px;
        }

        .reservasi-aktif-grid,
        .riwayat-grid {
            grid-template-columns: 1fr;
        }

        .aktif-card {
            flex-direction: column;
        }

        .aktif-right {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
        }
    }

</style>

@endsection