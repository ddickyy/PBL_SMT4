@extends('layout.app')

@section('title', 'Bukti Reservasi')

@section('hero')
    @include('partial.hero', [
        'badge'      => 'Layanan Kesehatan',
        'title'      => "Atur Waktu\nPemeriksaan Anda",
        'desc'       => "Pilih layanan spesialis yang Anda butuhkan.\nKami memastikan setiap kunjungan terasa personal, tenang, dan profesional.",
        'buttonText' => null,
        'bg'         => asset('images/poliklinik.jpg')
    ])
@endsection

@section('content')

<div class="bukti-wrap">

    <div class="section-header">
        <h2 class="section-title">Bukti Reservasi</h2>
    </div>

    <div class="bukti-card">

        <div class="bukti-row">
            <span class="bukti-label">Tipe Layanan</span>
            <span class="bukti-value">Dokter Gigi</span>
        </div>
        <div class="bukti-divider"></div>

        <div class="bukti-row">
            <span class="bukti-label">Tanggal</span>
            <span class="bukti-value">Selasa, 23 Mei 2026</span>
        </div>
        <div class="bukti-divider"></div>

        <div class="bukti-row">
            <span class="bukti-label">Jam</span>
            <span class="bukti-value">14.00 – 15.00</span>
        </div>
        <div class="bukti-divider"></div>

        <div class="bukti-row">
            <span class="bukti-label">Nomor Antrian</span>
            <span class="bukti-value bukti-antrian">G-02</span>
        </div>

    </div>

    <div class="wa-card">
        <div class="wa-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </div>
        <div class="wa-text">
            <p class="wa-title">Konfirmasi WhatsApp</p>
            <p class="wa-desc">Anda akan menerima pesan WhatsApp untuk konfirmasi kesediaan Anda dalam 2 waktu jadwal reservasi.</p>
        </div>
    </div>

    <div class="aksi-grid">
        <a href="{{ route('pasien.reservasi') }}" class="btn-secondary">
            ← Ubah Reservasi
        </a>
        <a href="{{ route('pasien.beranda') }}" class="btn-primary-bukti">
            Kembali ke Beranda
        </a>
    </div>

</div>

<style>
    main {
        background: #f7f7f8;
        padding: 40px 0 80px;
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
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
        letter-spacing: -0.03em;
    }

    .bukti-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 36px;
        box-shadow: 0 8px 32px rgba(16, 43, 87, 0.07);
        margin-bottom: 20px;
    }

    .bukti-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
    }

    .bukti-label {
        font-size: 0.95rem;
        color: #6f7380;
        font-weight: 500;
    }

    .bukti-value {
        font-size: 0.95rem;
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

    .bukti-divider {
        height: 1px;
        background: #f1f3f6;
    }

    .wa-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 22px 28px;
        box-shadow: 0 8px 32px rgba(16, 43, 87, 0.07);
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
        margin-top: 2px;
    }

    .wa-icon svg {
        width: 22px;
        height: 22px;
        color: #102b57;
    }

    .wa-text {
        flex: 1;
    }

    .wa-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #102b57;
        margin: 0 0 4px;
    }

    .wa-desc {
        font-size: 0.88rem;
        color: #6f7380;
        margin: 0;
        line-height: 1.55;
    }

    .aksi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .btn-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: #ffffff;
        color: #102b57;
        border: 2px solid #e8eaef;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        transition: border-color 0.2s, transform 0.15s;
    }

    .btn-secondary:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    .btn-primary-bukti {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: #102b57;
        color: white;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 8px 24px rgba(16, 43, 87, 0.2);
    }

    .btn-primary-bukti:hover {
        background: #0d2247;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(16, 43, 87, 0.28);
    }

    @media (max-width: 560px) {
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
    }
</style>

@endsection