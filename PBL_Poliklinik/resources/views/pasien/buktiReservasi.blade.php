@extends('layout.app')

@section('title', 'Bukti Reservasi')

@section('hero')
@include('partial.hero', [
    'badge' => 'Layanan Kesehatan',
    'title' => "Reservasi\nBerhasil Dibuat",
    'desc' => "Simpan bukti reservasi Anda dan datang sesuai jadwal yang telah ditentukan.",
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])
@endsection

@section('content')

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<div class="bukti-wrap">

    {{-- HEADER --}}
    <div class="section-header">

        <h2 class="section-title">
            Bukti Reservasi
        </h2>

    </div>

    @if(isset($reservasi))

        <div class="bukti-card">

            {{-- DOKTER --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Dokter
                </span>

                <span class="bukti-value">

                    {{
                        optional(
                            optional(
                                $reservasi->jadwal
                            )->dokter->user
                        )->nama ?? '-'
                    }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- LAYANAN --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Layanan
                </span>

                <span class="bukti-value">

                    {{
                        optional(
                            optional(
                                $reservasi->jadwal
                            )->dokter
                        )->spesialisasi
                            ->nama_spesialisasi ?? '-'
                    }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- TANGGAL --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Tanggal Pemeriksaan
                </span>

                <span class="bukti-value">

                    {{
                        Carbon::parse(
                            $reservasi->tanggal_reservasi
                        )
                        ->locale('id')
                        ->translatedFormat(
                            'l, d F Y'
                        )
                    }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- JAM --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Estimasi Jam
                </span>

                <span class="bukti-value">

                    {{
                        Carbon::parse(
                            $reservasi->estimasi_jam
                        )->format('H:i')
                    }}
                    WIB

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- ANTRIAN --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Nomor Antrian
                </span>

                <span class="bukti-value bukti-antrian">

                    #{{ $reservasi->nomor_antrian }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- STATUS --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Status
                </span>

                <span class="status-badge">

                    {{
                        ucfirst(
                            $reservasi->status
                        )
                    }}

                </span>

            </div>

        </div>

    @else

        {{-- EMPTY --}}
        <div class="empty-box">

            <i class="fa-solid fa-file-circle-xmark"></i>

            <h3>
                Bukti Reservasi Tidak Ditemukan
            </h3>

            <p>
                Data reservasi tidak tersedia
                atau sudah dihapus.
            </p>

        </div>

    @endif


    {{-- BUTTON --}}
    <div class="aksi-grid">

        <a href="{{ route('pasien.beranda') }}"
           class="btn-primary-bukti">

            Kembali ke Beranda

        </a>

    </div>

</div>

<style>

    main {
        background: #f7f8fa;
        padding: 40px 0 90px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .bukti-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .section-header {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 900;
        color: #102b57;
        margin: 0;
    }

    .bukti-card {
        background: white;
        border-radius: 24px;
        padding: 34px 38px;
        box-shadow:
            0 10px 34px rgba(16,43,87,.07);

        margin-bottom: 22px;
    }

    .bukti-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 16px 0;
    }

    .bukti-label {
        font-size: .95rem;
        font-weight: 600;
        color: #64748b;
    }

    .bukti-value {
        font-size: .96rem;
        font-weight: 800;
        color: #102b57;
        text-align: right;
    }

    .bukti-divider {
        height: 1px;
        background: #eef2f6;
    }

    .bukti-antrian {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 900;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 14px;
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 800;
    }

    .wa-card {
        background: white;
        border-radius: 22px;
        padding: 22px 28px;
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 28px;

        border-left: 5px solid #facc15;

        box-shadow:
            0 10px 34px rgba(16,43,87,.07);
    }

    .wa-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #facc15;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .wa-icon svg {
        width: 22px;
        height: 22px;
        color: #102b57;
    }

    .wa-title {
        margin: 0 0 4px;
        font-size: .95rem;
        font-weight: 800;
        color: #102b57;
    }

    .wa-desc {
        margin: 0;
        color: #64748b;
        font-size: .88rem;
        line-height: 1.6;
    }

    .aksi-grid {
        display: 1400px;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .btn-secondary,
    .btn-primary-bukti {

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 16px;

        border-radius: 16px;

        text-decoration: none;

        font-size: .95rem;
        font-weight: 800;

        transition: .25s ease;
    }

    .btn-secondary {
        background: white;
        border: 2px solid #e7ebf2;
        color: #102b57;
    }

    .btn-secondary:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    .btn-primary-bukti {
        background: linear-gradient(
            135deg,
            #102b57,
            #163d78
        );

        color: white;

        box-shadow:
            0 10px 26px rgba(16,43,87,.18);
    }

    .btn-primary-bukti:hover {
        transform: translateY(-2px);
    }

    .empty-box {
        background: white;
        border-radius: 24px;
        padding: 54px 24px;
        text-align: center;
        margin-bottom: 24px;

        box-shadow:
            0 10px 34px rgba(16,43,87,.07);
    }

    .empty-box i {
        font-size: 44px;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    .empty-box h3 {
        margin: 0 0 8px;
        color: #102b57;
    }

    .empty-box p {
        margin: 0;
        color: #64748b;
    }

    @media (max-width: 560px)
    {
        .bukti-wrap {
            padding: 0 16px;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .bukti-card {
            padding: 24px 22px;
        }

        .bukti-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .bukti-value {
            text-align: left;
        }

        .wa-card {
            flex-direction: column;
            padding: 20px;
            gap: 12px;
        }

        .aksi-grid {
            grid-template-columns: 1fr;
        }
    }

</style>

@endsection