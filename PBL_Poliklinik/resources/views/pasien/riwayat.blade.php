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

<div class="riwayat-wrap">

    <div class="riwayat-section-block">

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

                            <div class="aktif-left">

                                <span class="status-badge {{ $badgeClass }}">

                                    <span class="status-badge-dot"></span>

                                    {{ strtoupper($item->status) }}

                                </span>

                                <h3 class="aktif-layanan">
                                    {{ $spesialisasi }}
                                </h3>

                                <p class="aktif-dokter">
                                    {{ $namaDokter }}
                                </p>

                                <div class="aktif-info-row">

                                    <div class="aktif-info-item">

                                        <span class="aktif-info-label">
                                            Tanggal
                                        </span>

                                        <span class="aktif-info-value">

                                            {{ Carbon::parse($item->tanggal_reservasi)
                                                ->locale('id')
                                                ->translatedFormat('l, d F Y') }}

                                        </span>

                                    </div>

                                    <div class="aktif-info-item">

                                        <span class="aktif-info-label">
                                            Waktu
                                        </span>

                                        <span class="aktif-info-value">

                                            {{ Carbon::parse($item->estimasi_jam)->format('H:i') }}
                                            WIB

                                        </span>

                                    </div>

                                </div>

                                <div class="aktif-cta">
                                    Klik kartu untuk melihat bukti reservasi
                                </div>

                            </div>

                            <div class="aktif-right">

                                <div class="antrian-label">
                                    NO. ANTRIAN
                                </div>

                                <div class="antrian-num">
                                    {{ $item->nomor_antrian }}
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

    <div class="riwayat-section-block">

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

                    <div class="riwayat-card">

                        <div class="riwayat-card-top">

                            <h4 class="riwayat-dokter-nama">
                                {{ $spesialisasi }}
                            </h4>

                            <span class="status-badge {{ $badgeClass }}">

                                <span class="status-badge-dot"></span>

                                {{ strtoupper($item->status) }}

                            </span>

                        </div>

                        <p class="riwayat-desc">

                            Reservasi dengan
                            <strong>{{ $namaDokter }}</strong>

                            pada tanggal

                            <strong>

                                {{ Carbon::parse($item->tanggal_reservasi)
                                    ->locale('id')
                                    ->translatedFormat('l, d F Y') }}

                            </strong>.

                        </p>

                        <div class="riwayat-info-row">

                            <div class="riwayat-info-item">

                                <span class="riwayat-info-label">
                                    Waktu
                                </span>

                                <span class="riwayat-info-value">

                                    {{ Carbon::parse($item->estimasi_jam)->format('H:i') }}
                                    WIB

                                </span>

                            </div>

                            <div class="riwayat-info-item">

                                <span class="riwayat-info-label">
                                    Antrian
                                </span>

                                <span class="riwayat-info-value">
                                    {{ $item->nomor_antrian }}
                                </span>

                            </div>

                        </div>

                        @if($item->status === 'selesai' || $item->status === 'done')

                            <a href="{{ route('pasien.penilaian.create', $item->id_reservasi) }}"
                               class="btn-penilaian">

                                Berikan Penilaian

                            </a>

                        @endif

                    </div>

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

</div>

<style>

    main {
        background: #f7f7f8;
        padding: 40px 0 80px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .riwayat-wrap {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .riwayat-section-block {
        margin-bottom: 36px;
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

    .aktif-card {
        background: white;
        border-radius: 24px;
        padding: 30px 34px;
        border: 1.5px solid #eef0f5;
        box-shadow: 0 10px 34px rgba(16,43,87,.07);

        display: flex;
        justify-content: space-between;
        gap: 28px;

        transition: .25s ease;
    }

    .aktif-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 48px rgba(16,43,87,.12);
    }

    .aktif-left {
        flex: 1;
    }

    .aktif-layanan {
        font-size: 1.25rem;
        font-weight: 900;
        color: #102b57;
        margin: 0 0 4px;
    }

    .aktif-dokter {
        color: #64748b;
        margin-bottom: 18px;
    }

    .aktif-info-row,
    .riwayat-info-row {
        display: flex;
        flex-wrap: wrap;
        gap: 22px;
        margin-bottom: 18px;
    }

    .aktif-info-item,
    .riwayat-info-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .aktif-info-label,
    .riwayat-info-label {
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
    }

    .aktif-info-value,
    .riwayat-info-value {
        font-weight: 700;
        color: #102b57;
    }

    .aktif-cta {
        font-size: .88rem;
        font-weight: 800;
        color: #8b6a00;
    }

    .aktif-right {
        background: #f7f8fc;
        border: 1.5px solid #eef0f5;
        border-radius: 18px;
        padding: 24px;
        min-width: 130px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .antrian-label {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .antrian-num {
        font-size: 2rem;
        font-weight: 900;
        color: #102b57;
    }

    .riwayat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .riwayat-card {
        background: white;
        border-radius: 20px;
        padding: 24px 26px;
        border: 1.5px solid #eef0f5;
        box-shadow: 0 6px 24px rgba(16,43,87,.06);

        display: flex;
        flex-direction: column;
        gap: 12px;

        transition: .25s ease;
    }

    .riwayat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 48px rgba(16,43,87,.12);
    }

    .riwayat-card-top {
        display: flex;
        justify-content: space-between;
        gap: 14px;
    }

    .riwayat-dokter-nama {
        font-size: 1.05rem;
        font-weight: 900;
        color: #102b57;
    }

    .riwayat-desc {
        color: #64748b;
        line-height: 1.7;
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