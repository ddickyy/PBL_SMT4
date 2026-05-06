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

<style>
    main {
        background: #f7f7f8;
        padding: 40px 0 80px;
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .riwayat-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .riwayat-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .riwayat-section-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #102b57;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .riwayat-section-block {
        margin-bottom: 36px;
    }

    .aktif-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 32px;
        box-shadow: 0 8px 32px rgba(16, 43, 87, 0.07);
        border: 1.5px solid #eef0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        transition: box-shadow 0.25s ease, transform 0.2s ease;
    }

    .aktif-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 48px rgba(16, 43, 87, 0.12);
    }

    .aktif-left {
        flex: 1;
        min-width: 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        margin-bottom: 14px;
    }

    .status-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge-dikonfirmasi {
        background: #fef9e0;
        color: #b59008;
    }

    .badge-dikonfirmasi .status-badge-dot {
        background: #f6c40b;
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

    .aktif-layanan {
        font-size: 1.3rem;
        font-weight: 800;
        color: #102b57;
        margin: 0 0 4px;
        letter-spacing: -0.02em;
    }

    .aktif-dokter {
        font-size: 0.9rem;
        color: #6f7380;
        margin: 0 0 18px;
        font-weight: 500;
    }

    .aktif-info-row {
        display: flex;
        gap: 28px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .aktif-info-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .aktif-info-label {
        font-size: 10.5px;
        font-weight: 700;
        color: #a0a8b8;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .aktif-info-value {
        font-size: 0.92rem;
        font-weight: 600;
        color: #102b57;
    }

    .aktif-btn-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-lihat-detail {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 22px;
        background: #102b57;
        color: #ffffff;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 6px 20px rgba(16, 43, 87, 0.18);
    }

    .btn-lihat-detail:hover {
        background: #0d2247;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(16, 43, 87, 0.26);
    }

    .btn-ubah-jadwal {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 22px;
        background: transparent;
        color: #102b57;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        border: 2px solid #dde1ea;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s, transform 0.15s;
    }

    .btn-ubah-jadwal:hover {
        border-color: #102b57;
        background: #f1f5fb;
        transform: translateY(-2px);
    }

    .aktif-right {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: #f7f8fc;
        border-radius: 18px;
        padding: 24px 32px;
        border: 1.5px solid #eef0f5;
        text-align: center;
        min-width: 120px;
    }

    .antrian-label {
        font-size: 10px;
        font-weight: 700;
        color: #a0a8b8;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .antrian-num {
        font-size: 2.6rem;
        font-weight: 900;
        color: #102b57;
        letter-spacing: -0.03em;
        line-height: 1;
    }

    .riwayat-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .riwayat-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 24px 26px;
        box-shadow: 0 6px 24px rgba(16, 43, 87, 0.06);
        border: 1.5px solid #eef0f5;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: box-shadow 0.25s ease, transform 0.2s ease;
        overflow: hidden;
    }

    .riwayat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 48px rgba(16, 43, 87, 0.12);
    }

    .riwayat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .riwayat-dokter-nama {
        font-size: 1.05rem;
        font-weight: 800;
        color: #102b57;
        margin: 0;
    }

    .riwayat-desc {
        font-size: 0.88rem;
        color: #6f7380;
        line-height: 1.6;
        margin: 0;
        flex: 1;
    }

    .btn-penilaian {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px 20px;
        background: #102b57;
        color: #ffffff;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        letter-spacing: 0.04em;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 6px 20px rgba(16, 43, 87, 0.16);
        box-sizing: border-box;
    }

    .btn-penilaian:hover {
        background: #0d2247;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(16, 43, 87, 0.24);
    }

    .btn-reschedule {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px 20px;
        background: #eef0f5;
        color: #102b57;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        letter-spacing: 0.04em;
        transition: background 0.2s, transform 0.15s;
        box-sizing: border-box;
    }

    .btn-reschedule:hover {
        background: #dde2ee;
        transform: translateY(-2px);
    }

    .section-divider-icon {
        width: 18px;
        height: 18px;
        color: #a0a8b8;
        flex-shrink: 0;
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
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .riwayat-wrap {
            padding: 0 18px;
        }

        .aktif-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
            padding: 22px 20px;
        }

        .aktif-right {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            padding: 16px 20px;
        }

        .antrian-label {
            margin-bottom: 0;
        }

        .riwayat-grid {
            grid-template-columns: 1fr;
        }

        .aktif-info-row {
            gap: 18px;
        }

        .riwayat-section-title {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .aktif-btn-row {
            flex-direction: column;
        }

        .btn-lihat-detail,
        .btn-ubah-jadwal {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="riwayat-wrap">

    <div class="riwayat-section-block">

        <div class="riwayat-section-header">
            <h2 class="riwayat-section-title">Reservasi Aktif</h2>
        </div>

        <div class="aktif-card">

            <div class="aktif-left">
                <span class="status-badge badge-dikonfirmasi">
                    <span class="status-badge-dot"></span>
                    DIKONFIRMASI
                </span>
                <h3 class="aktif-layanan">Pemeriksaan Gigi</h3>
                <p class="aktif-dokter">Dr. Nathanial</p>

                <div class="aktif-info-row">
                    <div class="aktif-info-item">
                        <span class="aktif-info-label">Tanggal</span>
                        <span class="aktif-info-value">23 Mei 2026</span>
                    </div>
                    <div class="aktif-info-item">
                        <span class="aktif-info-label">Waktu</span>
                        <span class="aktif-info-value">14.00 – 16.00</span>
                    </div>
                    <div class="aktif-info-item">
                        <span class="aktif-info-label">Lokasi</span>
                        <span class="aktif-info-value">Poliklinik Politeknik Negeri Malang</span>
                    </div>
                </div>

                <div class="aktif-btn-row">
                    <a href="#" class="btn-lihat-detail">
                        Lihat Detail
                    </a>
                    <a href="{{ route('pasien.reservasi') }}" class="btn-ubah-jadwal">
                        Mengubah Jadwal
                    </a>
                </div>

            </div>

            <div class="aktif-right">
                <div class="antrian-label">NO. ANTRIAN</div>
                <div class="antrian-num">G-02</div>
            </div>

        </div>
    </div>

    <div class="riwayat-section-block">

        <div class="riwayat-section-header">
            <div class="riwayat-section-meta">
                <svg class="riwayat-section-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="riwayat-section-title">Riwayat Kunjungan</h2>
            </div>
        </div>

        <div class="riwayat-grid">

            <div class="riwayat-card">
                <div class="riwayat-card-top">
                    <h4 class="riwayat-dokter-nama">Dokter Gigi</h4>
                    <span class="status-badge badge-selesai">
                        <span class="status-badge-dot"></span>
                        SELESAI
                    </span>
                </div>
                <p class="riwayat-desc">
                    Layanan pembersihan karang gigi rutin dan pemeriksaan kondisi gigi secara menyeluruh.
                </p>
                <a href="{{ route('pasien.penilaian.create', 1) }}" class="btn-penilaian">
                    BERIKAN PENILAIAN
                </a>
            </div>

            <div class="riwayat-card">
                <div class="riwayat-card-top">
                    <h4 class="riwayat-dokter-nama">Dokter Umum</h4>
                    <span class="status-badge badge-batal">
                        <span class="status-badge-dot"></span>
                        BATAL
                    </span>
                </div>
                <p class="riwayat-desc">
                    Melakukan pemeriksaan kesehatan rutin dan medical check-up dasar yang dibatalkan.
                </p>
                <a href="{{ route('pasien.reservasi') }}" class="btn-reschedule">
                    RESCHEDULE
                </a>
            </div>

        </div>
    </div>

</div>

@endsection