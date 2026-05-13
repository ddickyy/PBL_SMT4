```blade id="k8x5mw"
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

@php use Carbon\Carbon; @endphp

<div class="bukti-wrap">

    <div class="section-header">
        <h2 class="section-title">Bukti Reservasi</h2>
    </div>

    @if(isset($reservasi))
        <div class="bukti-card">
            <div class="bukti-row">
                <span class="bukti-label">Dokter</span>
                <span class="bukti-value">
                    {{ optional(optional($reservasi->jadwal)->dokter->user)->nama ?? '-' }}
                </span>
            </div>

            <div class="bukti-divider"></div>
            <div class="bukti-row">
                <span class="bukti-label">Tipe Layanan</span>
                <span class="bukti-value">
                    {{ optional(optional($reservasi->jadwal)->dokter)->spesialisasi->nama_spesialisasi ?? '-' }}
                </span>
            </div>

            <div class="bukti-divider"></div>
            <div class="bukti-row">
                <span class="bukti-label">Tanggal</span>
                <span class="bukti-value">
                    {{ Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('l, d F Y') }}
                </span>
            </div>

            <div class="bukti-divider"></div>
            <div class="bukti-row">
                <span class="bukti-label">Jam Pemeriksaan</span>
                <span class="bukti-value">
                    {{ Carbon::parse($reservasi->estimasi_jam)->format('H:i') }}
                </span>
            </div>

            <div class="bukti-divider"></div>
            <div class="bukti-row">
                <span class="bukti-label">Nomor Antrian</span>
                <span class="bukti-value bukti-antrian">
                    #{{ $reservasi->nomor_antrian }}
                </span>
            </div>

            <div class="bukti-divider"></div>
            <div class="bukti-row">
                <span class="bukti-label">Status</span>
                <span class="status-badge">
                    {{ ucfirst($reservasi->status) }}
                </span>
            </div>
        </div>
    @else
        <div class="empty-box">
            <i class="fa-solid fa-file-circle-xmark"></i>
            <h3>
                Bukti Reservasi Tidak Ditemukan
            </h3>
            <p>
                Data reservasi tidak tersedia atau sudah dihapus.
            </p>
        </div>
    @endif

    <div class="wa-card">
        <div class="wa-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487z"/>
            </svg>
        </div>
        <div class="wa-text">

            <p class="wa-title">
                Konfirmasi WhatsApp
            </p>
            <p class="wa-desc">
                Anda akan menerima konfirmasi WhatsApp terkait reservasi dan jadwal pemeriksaan Anda.
            </p>
        </div>
    </div>

    <div class="aksi-grid">
        <a href="{{ route('pasien.reservasi') }}"
           class="btn-secondary">
            ← Ubah Reservasi
        </a>

        <a href="{{ route('pasien.beranda') }}"
           class="btn-primary-bukti">
            Kembali ke Beranda
        </a>
    </div>
</div>

<style>
    main {
        background: #f7f7f8;
        padding: 40px 0 80px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .bukti-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .section-header {
        margin-bottom: 28px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #102b57;
        margin: 0;
    }

    .bukti-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 36px;
        box-shadow: 0 8px 32px rgba(16,43,87,.07);
        margin-bottom: 20px;
    }

    .bukti-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        gap: 18px;
    }

    .bukti-label {
        font-size: .95rem;
        color: #6f7380;
        font-weight: 500;
    }

    .bukti-value {
        font-size: .95rem;
        font-weight: 700;
        color: #102b57;
        text-align: right;
    }

    .bukti-antrian {
        font-size: 1.1rem;
        font-weight: 800;
        color: #102b57;
        background: #f1f5fb;
        padding: 4px 14px;
        border-radius: 8px;
    }

    .status-badge {
        background: #dbeafe;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .bukti-divider {
        height: 1px;
        background: #f1f3f6;
    }

    .wa-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 22px 28px;
        box-shadow: 0 8px 32px rgba(16,43,87,.07);
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 28px;
        border-left: 4px solid #f6c40b;
    }

    .wa-icon {
        width: 40px;
        height: 40px;
        background: #f6c40b;
        border-radius: 50%;
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
        font-size: .95rem;
        font-weight: 700;
        color: #102b57;
        margin: 0 0 4px;
    }

    .wa-desc {
        font-size: .88rem;
        color: #6f7380;
        margin: 0;
        line-height: 1.55;
    }

    .aksi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .btn-secondary,
    .btn-primary-bukti {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-radius: 14px;
        font-size: .95rem;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-secondary {
        background: #ffffff;
        color: #102b57;
        border: 2px solid #e8eaef;
    }

    .btn-secondary:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    .btn-primary-bukti {
        background: #102b57;
        color: white;
        box-shadow: 0 8px 24px rgba(16,43,87,.2);
    }

    .btn-primary-bukti:hover {
        background: #0d2247;
        transform: translateY(-2px);
    }

    .empty-box {
        background: white;
        border-radius: 20px;
        padding: 50px 20px;
        text-align: center;
        margin-bottom: 24px;
        box-shadow: 0 8px 32px rgba(16,43,87,.07);
    }

    .empty-box i {
        font-size: 42px;
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

    @media (max-width: 560px) {

        .bukti-wrap {
            padding: 0 16px;
        }

        .bukti-card {
            padding: 24px 20px;
        }

        .wa-card {
            padding: 18px 20px;
            flex-direction: column;
            gap: 12px;
        }

        .aksi-grid {
            grid-template-columns: 1fr;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .bukti-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .bukti-value {
            text-align: left;
        }
    }
</style>
@endsection