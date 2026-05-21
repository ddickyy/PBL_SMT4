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
            <button class="rp-tab" onclick="rpFilter(this,'batal')">Batal</button>
        </div>
    </div>

    <div class="rp-header-row">
        <span>WAKTU</span>
        <span>INFORMASI PASIEN</span>
        <span>DIAGNOSIS</span>
        <span>RATING</span>
        <span>KRITIK & SARAN</span>
        <span>STATUS</span>
    </div>

    {{-- RIWAYAT LIST --}}
    <div class="rp-list" id="rpList">
        @foreach($riwayatList as $r)

<div
    class="rp-item"
    data-status="{{ $r->status }}"
>

    <div class="rp-item__time">

        <strong>

            {{ \Carbon\Carbon::parse($r->tanggal_reservasi)->translatedFormat('d F Y') }}

        </strong>

    </div>

    <div class="rp-item__pasien">

        <img
            src="https://ui-avatars.com/api/?name={{ urlencode($r->user->nama) }}&background=102b57&color=fff&size=44"
        >

        <div>

            <h4>{{ $r->user->nama }}</h4>

            <p>{{ $r->user->email }}</p>

        </div>

    </div>

    <p class="rp-item__diagnosa">
        {{ $r->diagnosa ?? '-' }}
    </p>

    <div class="rp-rating">

        ⭐

    </div>

    <p class="rp-item__saran">
        {{ $r->catatan_dokter ?? '-' }}
    </p>

    <span class="rp-badge rp-badge--{{ $r->status }}">

        {{ strtoupper($r->status) }}

    </span>

</div>

@endforeach
    </div>

    {{-- LOAD MORE --}}
    <div class="rp-loadmore">
        <button class="rp-btn-more">
            Lihat Riwayat Lebih Lama
            <span class="rp-btn-more__icon"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
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

.rp-section   { padding: 30px 24px 60px; background: #f5f7fb; }
.rp-container { max-width: 1200px; margin: 0 auto; padding: 0 16px; }

/* TOP BAR */
.rp-topbar {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
}
.rp-topbar__left h2 { margin: 0; font-size: 22px; font-weight: 800; color: #102b57; }
.rp-topbar__right { display: flex; gap: 6px; }
.rp-tab {
    padding: 9px 18px; border-radius: 10px;
    border: none; cursor: pointer;
    font-size: 13px; font-weight: 600;
    background: #fff; color: #64748b;
    box-shadow: 0 2px 8px rgba(16,43,87,.06);
    transition: background .2s, color .2s;
}
.rp-tab:hover:not(.rp-tab--active) { background: #f1f5f9; }
.rp-tab--active { background: #102b57; color: #fff; }

/* HEADER ROW */
.rp-header-row {
    display: grid;
    grid-template-columns: 140px 1fr 1fr 120px 240px 120px;
    gap: 16px;
    padding: 12px 20px;
    background: #f8fafc;
    border-radius: 14px 14px 0 0;
    border: 1px solid #e2e8f0;
    border-bottom: none;
}
.rp-header-row span {
    font-size: 11px; font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase; letter-spacing: .5px;
}

/* LIST */
.rp-list {
    display: flex; flex-direction: column;
    border: 1px solid #e2e8f0;
    border-radius: 0 0 22px 22px;
    background: #fff;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(16,43,87,.07);
}
.rp-item {
    display: grid;
    grid-template-columns: 140px 1fr 1fr 120px 240px 120px;
    gap: 16px;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.rp-item:hover { background: #f8fafc; }
.rp-item:last-child { border-bottom: none; }

.rp-item__time strong { font-size: 14px; font-weight: 700; color: #102b57; }

.rp-item__pasien { display: flex; align-items: center; gap: 12px; }
.rp-item__pasien img { width: 44px; height: 44px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
.rp-item__pasien h4 { margin: 0 0 3px; font-size: 15px; font-weight: 700; color: #102b57; }
.rp-item__pasien p  { margin: 0; font-size: 12px; color: #94a3b8; }

.rp-item__diagnosa { margin: 0; font-size: 13px; color: #64748b; line-height: 1.5; }

.rp-badge {
    display: inline-flex; align-items: center;
    padding: 6px 14px; border-radius: 999px;
    font-size: 11px; font-weight: 800;
    letter-spacing: .3px; white-space: nowrap;
}
.rp-badge--selesai { background: #dcfce7; color: #15803d; }
.rp-badge--batal   { background: #fee2e2; color: #dc2626; }
.rp-badge--proses  { background: #fef9c3; color: #a16207; }

/* LOAD MORE */
.rp-loadmore { text-align: center; margin-top: 28px; }
.rp-btn-more {
    display: inline-flex; align-items: center; gap: 10px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 24px;
    font-size: 14px; font-weight: 700;
    color: #102b57; cursor: pointer;
    box-shadow: 0 4px 14px rgba(16,43,87,.06);
    transition: transform .2s, box-shadow .2s;
}
.rp-btn-more:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(16,43,87,.1); }
.rp-btn-more__icon {
    width: 28px; height: 28px;
    background: #f6c40b; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; color: #102b57;
}

@media (max-width: 900px) {
    .rp-header-row,
    .rp-item {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto auto;
    }
    .rp-header-row span:nth-child(1),
    .rp-item__time { display: none; }
}
@media (max-width: 560px) {
    .rp-header-row,
    .rp-item { grid-template-columns: 1fr; }
    .rp-header-row { display: none; }
}

.rp-rating {
    display: flex;
    align-items: center;
    gap: 4px;
}

.rp-rating i {
    font-size: 13px;
    color: #e2e8f0;
}

.rp-rating i.active {
    color: #f6c40b;
}

.rp-item__saran {
    margin: 0;
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
}

/* STATUS SAMA SEMUA */
.rp-badge {
    min-width: 95px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 6px 14px;

    border-radius: 999px;

    font-size: 11px;
    font-weight: 800;
    letter-spacing: .4px;
}

/* STATUS COLORS */
.rp-badge--selesai {
    background: #dcfce7;
    color: #15803d;
}

.rp-badge--proses {
    background: #fef3c7;
    color: #d97706;
}

.rp-badge--menunggu {
    background: #f1f5f9;
    color: #64748b;
}

.rp-badge--batal {
    background: #fee2e2;
    color: #dc2626;
}

</style>

@endsection