@extends('layout.app')

@section('title', 'Reservasi Layanan')

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

<div class="reservasi-wrap">

    <div class="section-header">
        <h2 class="section-title">Reservasi Layanan</h2>
        <p class="section-sub">Pilih dan tentukan jadwal kunjungan Anda.</p>
    </div>

    <div class="step-block">
        <div class="step-label">
            <span class="step-num">1</span>
            <span class="step-text">Pilih Dokter</span>
        </div>

        <div class="dokter-grid" id="dokterGrid">

            <div class="dokter-card" data-id="umum" onclick="pilihDokter(this)">
                <div class="dokter-top">
                    <div class="service-icon">
                            <i class="fa-solid fa-stethoscope"></i>
                        </div>
                    <span class="kuota-badge">KUOTA MINGGU INI <b>3/5</b></span>
                </div>
                <h3 class="dokter-nama">Dokter Umum</h3>
                <p class="dokter-desc">Konsultasi umum, rujukan, dan pemeriksaan kesehatan rutin.</p>
                <a href="#" class="dokter-link" onclick="return false;">Pilih Layanan →</a>
            </div>

            <div class="dokter-card selected" data-id="gigi" onclick="pilihDokter(this)">
                <div class="dokter-top">
                    <div class="service-icon">
                        <i class="fa-solid fa-tooth"></i>
                    </div>
                    <span class="kuota-badge kuota-tipis">KUOTA TIPIS <b>2/3</b></span>
                </div>
                <h3 class="dokter-nama">Dokter Gigi</h3>
                <p class="dokter-desc">Pemeriksaan gigi, pembersihan karang, dan pencabutan gigi.</p>
                <span class="layanan-terpilih">Layanan Terpilih ✓</span>
            </div>

        </div>
    </div>

    <div class="step-block">
        <div class="step-label">
            <span class="step-num">2</span>
            <span class="step-text">Pilih Tanggal</span>
        </div>

        <div class="tanggal-grid" id="tanggalGrid">
            @php
                $days = [
                    ['hari' => 'RAB',  'tgl' => '01'],
                    ['hari' => 'KAMS', 'tgl' => '09'],
                    ['hari' => 'RAB',  'tgl' => '15'],
                    ['hari' => 'RAB',  'tgl' => '22'],
                    ['hari' => 'KAMS', 'tgl' => '29'],
                ];
            @endphp

            @foreach($days as $i => $d)
                <div class="tanggal-card {{ $i === 1 ? 'selected' : '' }}" onclick="pilihTanggal(this)">
                    <span class="tgl-hari">{{ $d['hari'] }}</span>
                    <span class="tgl-num">{{ $d['tgl'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- <div class="confirm-wrap">
        <a href="{{ route('pasien.bukti') }}" class="btn-confirm">
            Konfirmasi Reservasi ▶
        </a>
    </div> --}}

        <div class="confirm-wrap">
            <a href="/preview-bukti" class="btn-confirm">
                Konfirmasi Reservasi ▶
            </a>
        </div>

</div>

<script>
    function pilihDokter(el) {

        document.querySelectorAll('.dokter-card').forEach(card => {

            card.classList.remove('selected');

            const oldBadge = card.querySelector('.layanan-terpilih');

            if (oldBadge) {
                oldBadge.outerHTML =
                    `<a href="#" class="dokter-link" onclick="return false;">Pilih Layanan →</a>`;
            }
        });

        el.classList.add('selected');

        const link = el.querySelector('.dokter-link');

        if (link) {
            link.outerHTML =
                `<span class="layanan-terpilih">Layanan Terpilih ✓</span>`;
        }
    }

    function pilihTanggal(el) {
        document.querySelectorAll('.tanggal-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
    }
</script>

<style>
    main {
        background: #f7f7f8;
        padding: 40px 0 80px;
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .reservasi-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .section-header {
        margin-bottom: 32px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #102b57;
        margin: 0 0 6px;
        letter-spacing: -0.03em;
    }

    .section-sub {
        font-size: 1rem;
        color: #6f7380;
        margin: 0;
    }

    .service-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: #eef4ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .step-block {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 20px;
        box-shadow: 0 8px 32px rgba(16, 43, 87, 0.06);
    }

    .step-label {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .step-num {
        width: 32px;
        height: 32px;
        background: #102b57;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .step-text {
        font-size: 1.15rem;
        font-weight: 700;
        color: #102b57;
    }

    .dokter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        display: grid;
        gap: 16px;
    }

    .dokter-card {
        border: 2px solid #e8eaef;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
        background: #fafafa;
        min-height: 260px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .dokter-card:hover {
        border-color: #102b57;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 43, 87, 0.1);
    }

    .dokter-card.selected {
        border-color: #f6c40b;
        background: #fffef5;
        box-shadow: 0 8px 28px rgba(246, 196, 11, 0.18);
    }

    .dokter-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .dokter-icon {
        width: 44px;
        height: 44px;
        background: #f1f5fb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dokter-icon svg {
        width: 22px;
        height: 22px;
        color: #102b57;
    }

    .kuota-badge {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
        background: #f1f5f9;
        border-radius: 6px;
        padding: 4px 8px;
        letter-spacing: 0.04em;
        text-align: right;
        line-height: 1.4;
    }

    .kuota-tipis {
        background: #fff0f0;
        color: #dc2626;
    }

    .dokter-nama {
        font-size: 1.15rem;
        font-weight: 700;
        color: #102b57;
        margin: 0 0 6px;
    }

    .dokter-desc {
        font-size: 0.88rem;
        color: #6f7380;
        margin: 0 0 14px;
        line-height: 1.5;
    }

    .dokter-link {
        font-size: 0.88rem;
        font-weight: 600;
        color: #102b57;
        text-decoration: none;
    }

    .layanan-terpilih {
        display: inline-block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #b59008;
        background: #fef9e0;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .tanggal-grid {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .tanggal-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 68px;
        padding: 14px 0;
        border: 2px solid #e8eaef;
        border-radius: 14px;
        cursor: pointer;
        background: #fafafa;
        transition: border-color 0.2s, background 0.2s, transform 0.15s;
        gap: 6px;
    }

    .tanggal-card:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    .tanggal-card.selected {
        border-color: #f6c40b;
        background: #102b57;
    }

    .tanggal-card.selected .tgl-hari,
    .tanggal-card.selected .tgl-num {
        color: #ffffff;
    }

    .tgl-hari {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.06em;
    }

    .tgl-num {
        font-size: 1.4rem;
        font-weight: 800;
        color: #102b57;
        line-height: 1;
    }

    .confirm-wrap {
        margin-top: 8px;
    }

    .btn-confirm {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 18px;
        background: #102b57;
        color: white;
        border-radius: 16px;
        font-size: 1rem;
        font-weight: 800;
        text-decoration: none;
        letter-spacing: 0.02em;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        box-shadow: 0 10px 30px rgba(16, 43, 87, 0.2);
    }

    .btn-confirm:hover {
        background: #0d2247;
        transform: translateY(-2px);
        box-shadow: 0 14px 36px rgba(16, 43, 87, 0.28);
    }

    @media (max-width: 640px) {
        .step-block {
            padding: 20px 18px;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .dokter-grid {
            grid-template-columns: 1fr;
        }

        .tanggal-grid {
            gap: 8px;
        }

        .tanggal-card {
            width: 58px;
        }
    }
</style>

@endsection