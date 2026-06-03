@extends('layout.app')

@php
    $dokterLayout = true;
@endphp

@section('title', 'Riwayat Pasien')

@section('hero')
@include('partial.hero', [
    'badge'      => 'Layanan Kesehatan',
    'title'      => 'Riwayat<br><span style="color:#f6c40b">Reservasi Pasien</span>',
    'desc'       => 'Pantau riwayat konsultasi dan tindakan yang telah diberikan kepada pasien.',
    'buttonText' => null,
    'bg'         => asset('images/poliklinik.jpg'),
])
@endsection

@section('content')

<section class="rp-section">
<div class="rp-container">

    {{-- FILTER TABS --}}
    <div class="rp-topbar">
        <div class="rp-topbar__left">
            <h2>Riwayat Reservasi</h2>
        </div>
        <div class="rp-topbar__right">
            <button class="rp-tab rp-tab--active" onclick="rpFilter(this,'semua')">Semua</button>
            <button class="rp-tab" onclick="rpFilter(this,'selesai')">Selesai</button>
            <button class="rp-tab" onclick="rpFilter(this,'dibatalkan')">Batal</button>
        </div>
    </div>

    <div class="rp-header-row">
        <span>Waktu</span>
        <span>Informasi Pasien</span>
        <span>Diagnosis</span>
        <span>Kritik & Saran</span>
        <span>Status</span>
    </div>

    {{-- RIWAYAT LIST --}}
    <div class="rp-list" id="rpList">
        @forelse($riwayatList as $r)

<div
    class="rp-item"
    data-status="{{ $r->status }}"
    onclick="window.location='{{ route('dokter.pasien.detail', $r->id_reservasi) }}'"
    style="cursor: pointer;"
>

    <div class="rp-item__time">
        <small class="rp-mobile-label">Waktu Reservasi</small>
        <strong>
            {{ \Carbon\Carbon::parse($r->tanggal_reservasi)->translatedFormat('d F Y') }}
        </strong>
    </div>

    <div class="rp-item__pasien">
        <img
            src="https://ui-avatars.com/api/?name={{ urlencode($r->user->nama) }}&background=102b57&color=fff&size=44"
            alt="{{ $r->user->nama }}"
        >
        <div>
            <h4>{{ $r->user->nama }}</h4>
            <p>{{ $r->user->email }}</p>
        </div>
    </div>

    <div class="rp-item__diagnosa-wrapper">
        <small class="rp-mobile-label">Diagnosis</small>
        <p class="rp-item__diagnosa">
            {{ optional($r->rekamMedis)->diagnosis ?? '-' }}
        </p>
    </div>

    <div class="rp-item__saran-wrapper">
        <small class="rp-mobile-label">Kritik & Saran</small>
        <p class="rp-item__saran">
            @if($r->penilaian)
                @php
                    $text = ($r->penilaian->kritik ? 'Kritik: ' . $r->penilaian->kritik : '') . ($r->penilaian->saran ? ' | Saran: ' . $r->penilaian->saran : '');
                @endphp
                {{ Str::limit($text, 45) }}
            @else
                -
            @endif
        </p>
    </div>

    <div class="rp-item__status-wrapper">
        <small class="rp-mobile-label">Status</small>
        <span class="rp-badge rp-badge--{{ $r->status }}">
            {{ strtoupper($r->status) }}
        </span>
    </div>

</div>

        @empty

<div class="rp-empty">
    <i class="fa-solid fa-folder-open"></i>
    <p>Belum ada riwayat reservasi pasien.</p>
</div>

        @endforelse
    </div>



</div>
</section>

<script>
function rpFilter(el, status) {
    document.querySelectorAll('.rp-tab').forEach(t => t.classList.remove('rp-tab--active'));
    el.classList.add('rp-tab--active');
    document.querySelectorAll('.rp-item').forEach(function(item) {
        if (status === 'semua' || item.dataset.status === status) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

.rp-section   {
    font-family: 'Outfit', 'Inter', sans-serif;
    padding: 40px 24px 80px; 
    background: #f8fafc; 
}
.rp-container { max-width: 1200px; margin: 0 auto; padding: 0 16px; }

/* TOP BAR */
.rp-topbar {
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    margin-bottom: 24px; 
    gap: 12px; 
    flex-wrap: wrap;
}
.rp-topbar__left h2 { 
    margin: 0; 
    font-size: 22px; 
    font-weight: 800; 
    color: #102b57; 
    letter-spacing: -0.5px;
}
.rp-topbar__right { display: flex; gap: 8px; }
.rp-tab {
    padding: 10px 20px; 
    border-radius: 12px;
    border: 1px solid #e2e8f0; 
    cursor: pointer;
    font-size: 13px; 
    font-weight: 600;
    background: #fff; 
    color: #64748b;
    box-shadow: 0 2px 8px rgba(16,43,87,.03);
    transition: all .2s ease;
}
.rp-tab:hover:not(.rp-tab--active) { 
    background: #f1f5f9; 
    color: #102b57;
}
.rp-tab--active { 
    background: #102b57; 
    color: #fff; 
    border-color: #102b57;
    box-shadow: 0 4px 12px rgba(16, 43, 87, 0.1);
}

/* HEADER ROW */
.rp-header-row {
    display: grid;
    grid-template-columns: 140px 1.2fr 1.2fr 1.5fr 110px;
    gap: 20px;
    padding: 16px 24px;
    background: #f1f5f9;
    border-radius: 16px 16px 0 0;
    border: 1px solid #e2e8f0;
    border-bottom: none;
}
.rp-header-row span {
    font-size: 12px; 
    font-weight: 800;
    color: #475569;
    text-transform: uppercase; 
    letter-spacing: .5px;
}

/* LIST */
.rp-list {
    display: flex; 
    flex-direction: column;
    border: 1px solid #e2e8f0;
    border-radius: 0 0 20px 20px;
    background: #fff;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(16,43,87,.04);
}
.rp-item {
    display: grid;
    grid-template-columns: 140px 1.2fr 1.2fr 1.5fr 110px;
    gap: 20px;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    transition: background .2s ease;
}
.rp-item:hover { background: #f8fafc; }
.rp-item:last-child { border-bottom: none; }

.rp-item__time strong { 
    font-size: 14.5px; 
    font-weight: 700; 
    color: #102b57; 
}

.rp-item__pasien { display: flex; align-items: center; gap: 12px; }
.rp-item__pasien img { 
    width: 44px; 
    height: 44px; 
    border-radius: 12px; 
    object-fit: cover; 
    flex-shrink: 0; 
    box-shadow: 0 2px 6px rgba(16,43,87,.08);
}
.rp-item__pasien h4 { margin: 0 0 3px; font-size: 15px; font-weight: 700; color: #102b57; }
.rp-item__pasien p  { margin: 0; font-size: 12px; color: #94a3b8; }

.rp-item__diagnosa { 
    margin: 0; 
    font-size: 13.5px; 
    color: #334155; 
    line-height: 1.6; 
}

.rp-badge {
    display: inline-flex; 
    align-items: center;
    justify-content: center;
    padding: 7px 16px; 
    border-radius: 99px;
    font-size: 11px; 
    font-weight: 800;
    letter-spacing: .5px; 
    white-space: nowrap;
    text-transform: uppercase;
    min-width: 95px;
}
.rp-badge--selesai { background: #dcfce7; color: #15803d; }
.rp-badge--batal, .rp-badge--dibatalkan { background: #fee2e2; color: #dc2626; }
.rp-badge--proses  { background: #fef9c3; color: #a16207; }
.rp-badge--menunggu { background: #f1f5f9; color: #64748b; }

/* LOAD MORE */
.rp-loadmore { text-align: center; margin-top: 32px; }
.rp-btn-more {
    display: inline-flex; 
    align-items: center; 
    gap: 10px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 24px;
    font-size: 14px; 
    font-weight: 700;
    color: #102b57; 
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16,43,87,.04);
    transition: all .2s ease;
}
.rp-btn-more:hover { 
    transform: translateY(-2px); 
    box-shadow: 0 8px 20px rgba(16,43,87,.08); 
    border-color: #cbd5e1;
}
.rp-btn-more__icon {
    width: 26px; height: 26px;
    background: #f6c40b; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; color: #102b57;
}

.rp-rating {
    display: flex;
    align-items: center;
    gap: 4px;
}
.rp-rating i {
    font-size: 13px;
    color: #cbd5e1;
}
.rp-rating i.active {
    color: #f6c40b;
}

.rp-item__saran {
    margin: 0;
    font-size: 13.5px;
    color: #475569;
    line-height: 1.6;
}

.rp-mobile-label {
    display: none;
    font-size: 10px;
    font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.rp-empty {
    padding: 60px 20px;
    text-align: center;
    color: #94a3b8;
}
.rp-empty i {
    font-size: 40px;
    margin-bottom: 12px;
    color: #cbd5e1;
}
.rp-empty p {
    font-size: 15px;
    font-weight: 600;
    margin: 0;
}

@media (max-width: 992px) {
    .rp-header-row {
        display: none;
    }
    .rp-list {
        background: transparent;
        border: none;
        box-shadow: none;
        overflow: visible;
        border-radius: 0;
        gap: 16px;
    }
    .rp-item {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        padding: 24px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        background: #fff;
        box-shadow: 0 4px 16px rgba(16,43,87,.02);
    }
    .rp-mobile-label {
        display: block;
    }
    .rp-item__pasien {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
        margin-bottom: 4px;
    }
    .rp-item__diagnosa, .rp-item__saran {
        background: #f8fafc;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
    }
}
</style>

@endsection