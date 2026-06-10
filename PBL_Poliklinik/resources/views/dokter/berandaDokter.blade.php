@extends('layout.app')

@php
$dokterLayout = true;
@endphp

@section('title', 'Beranda Dokter')

@section('hero')
@include('partial.hero', [
'badge' => 'Layanan Kesehatan',
'title' => 'Selamat Datang,<br><span class="text-[#f6c40b]">' . $dokter->user->nama . '</span>',
'desc' => 'Kelola jadwal praktik, pantau antrean pasien, dan berikan pelayanan kesehatan terbaik hari ini.',
'buttonText' => null,
'bg' => asset('images/poliklinik.jpg'),
])
@endsection

@section('content')

<section class="bd-section">
<div class="bd-container">

 {{-- STATS --}}
 <div class="bd-stats" data-aos="fade-up">

 <div class="bd-stat bd-stat--blue">
 <div class="bd-stat__icon">
 <i class="fa-solid fa-calendar-check"></i>
 </div>

 <div class="bd-stat__body">
 <span class="bd-stat__label">
 Reservasi Menunggu (Minggu Ini)
 </span>

 <strong class="bd-stat__val">
 {{ $menunggu }}
 </strong>
 </div>
 </div>

 <div class="bd-stat bd-stat--yellow">
 <div class="bd-stat__icon">
 <i class="fa-solid fa-users"></i>
 </div>

 <div class="bd-stat__body">
 <span class="bd-stat__label">
 Selesai Hari Ini
 </span>

 <strong class="bd-stat__val">
 {{ $selesai }}
 </strong>
 </div>
 </div>

 <div class="bd-stat bd-stat--green">
 <div class="bd-stat__icon">
 <i class="fa-solid fa-chart-line"></i>
 </div>

 <div class="bd-stat__body">
 <span class="bd-stat__label">
 Total Pasien Hari Ini
 </span>

 <strong class="bd-stat__val">
 {{ $antreanHariIniCount }}
 </strong>
 </div>
 </div>

 </div>

 {{-- MAIN --}}
 <div class="bd-main">

 {{-- LEFT --}}
 <div class="bd-left" data-aos="fade-up">

 <div class="bd-card bd-queue-card">

 <div class="bd-subhead">
 <h2>Antrean Pasien</h2>

 <div class="bd-tabs">
 <a href="?filter=hari_ini" class="bd-tab {{ $filter == 'hari_ini' ? 'bd-tab--active' : '' }}">Hari Ini</a>
 <a href="?filter=semua" class="bd-tab {{ $filter == 'semua' ? 'bd-tab--active' : '' }}">Seluruh Antrean</a>
 </div>
 </div>

 <div class="bd-antrean">

 @forelse($reservasiHariIni as $p)

 <div class="bd-row @if($p->status === 'dikonfirmasi') bd-row--active @endif" onclick="window.location='{{ route('dokter.pasien.detail', $p->id_reservasi) }}'" style="cursor: pointer; animation-delay: {{ $loop->index * 0.15 }}s;">

 <div class="bd-row__header">
 <span class="bd-row__no">
 #{{ $p->nomor_antrian }} - 
 @if($filter === 'semua' && $p->tanggal_reservasi != now()->toDateString())
 <span style="color: #64748b; font-size: 13px;">{{ \Carbon\Carbon::parse($p->tanggal_reservasi)->translatedFormat('d M Y') }}</span>,
 @endif
 {{ \Carbon\Carbon::parse($p->estimasi_jam)->format('H:i') }} WIB
 </span>
 <span class="bd-badge bd-badge--{{ $p->status }}">{{ strtoupper($p->status) }}</span>
 </div>

 <div class="bd-row__body">
 <div class="bd-row__info">
 <img
 src="{{ $p->user->foto ? asset('storage/' . $p->user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($p->user->nama) . '&background=102b57&color=fff&size=44' }}"
 alt="{{ $p->user->nama }}"
>
 <div>
 <h4>{{ $p->user->nama }}</h4>
 <p>{{ $p->user->email }}</p>
 </div>
 </div>
 <span class="bd-row__btn-wrap">
 <span class="bd-row__btn">
 <i class="fa-solid fa-chevron-right"></i>
 </span>
 </span>
 </div>

 </div>

 @empty

 <div class="bd-empty-state">
 <i class="fa-solid fa-calendar-times"></i>
 <p>Tidak ada antrean pasien {{ $filter == 'hari_ini' ? 'hari ini' : 'tersedia' }}.</p>
 </div>

 @endforelse

 </div>

 </div>

 </div>

 {{-- RIGHT --}}
 <div class="bd-right" data-aos="fade-up">

 {{-- PROFIL --}}
 <div class="bd-card bd-profil">

 <img
 class="bd-profil__img"
 src="{{ $dokter->user->foto ? asset('storage/' . $dokter->user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($dokter->user->nama) . '&background=102b57&color=fff&size=80' }}"
 alt="Profil"
>

 <div class="bd-profil__detail">

 <h3>
 {{ $dokter->user->nama }}
 </h3>

 <p>
 {{ $dokter->spesialisasi->nama_spesialisasi ?? '-' }}
 </p>

 <div class="bd-profil__meta">

 <span>
 <i class="fa-solid fa-id-card"></i>

 {{ $dokter->sip_dokter ?? '-' }}
 </span>

 </div>
 </div>

 <a
 href="{{ route('dokter.profil.edit') }}"
 class="bd-btn-edit"
>
 <i class="fa-solid fa-pen"></i>
 Edit Profil
 </a>

 </div>

 {{-- STATUS
 <div class="bd-card bd-status">

 <div class="bd-status__head">

 <span class="bd-status__title">
 STATUS KEGIATAN
 </span>

 <span class="bd-status__pill">

 @if($sedangPraktik)
 ● Sedang Praktik
 @else
 ● Tidak Praktik
 @endif

 </span>

 </div>

 <p class="bd-status__place">
 Poliklinik Politeknik Negeri Malang
 </p>

 <hr class="bd-status__divider">

 <div class="bd-status__row">

 <div>

 <small>Hari</small>

 <strong>
 {{ ucfirst($jadwalHariIni->hari ?? '-') }}
 </strong>

 </div>

 <div>

 <small>Jam</small>

 <strong>

 @if($jadwalHariIni)

 {{ substr($jadwalHariIni->jam_mulai,0,5) }}
 -
 {{ substr($jadwalHariIni->jam_selesai,0,5) }}

 @else

 Tidak Ada Jadwal

 @endif

 </strong>

 </div>

 <div class="bd-status__pasien">

 <small>Pasien Hari Ini</small>

 <strong class="bd-big">
 {{ $reservasiHariIni->count() }}
 </strong>

 </div>

 </div>

 </div> --}}

 {{-- JADWAL --}}
 <div class="bd-card bd-jadwal">

 <div class="bd-jadwal__head">

 <h3>Jadwal Praktik Mingguan</h3>

 <span class="bd-jadwal__zone">
 Zona Waktu: WIB (UTC+7)
 </span>

 </div>

 <div class="bd-jadwal__days">

 @foreach($groupedJadwal as $hari => $jadwals)
 <div class="bd-day {{ $hari === \Carbon\Carbon::now()->translatedFormat('l') ? 'bd-day--today' : 'bd-day--upcoming' }}">
 <span class="bd-day__hari">{{ substr($hari, 0, 3) }}</span>
 <div style="display: flex; flex-direction: column; gap: 4px; align-items: center;">
 @foreach($jadwals as $jadwal)
 <span class="bd-day__jam">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
 @endforeach
 </div>
 </div>
 @endforeach

 </div>

 </div>

 {{-- KONTAK --}}
 <div class="bd-card bd-kontak">

 <div class="bd-kontak__item">

 <i class="fa-regular fa-envelope"></i>

 <div>

 <small>Email</small>

 <span>
 {{ $dokter->user->email }}
 </span>

 </div>

 </div>

 <div class="bd-kontak__divider"></div>

 <div class="bd-kontak__item">

 <i class="fa-solid fa-phone"></i>

 <div>

 <small>Kontak</small>

 <span>
 {{ $dokter->no_hp ?? '-' }}
 </span>

 </div>

 </div>

 </div>

 </div>

 </div>

</div>
</section>

<style>


/* ── LAYOUT ── */
.bd-section {
 font-family: 'Poppins', system-ui, sans-serif;
 padding: 40px 24px 80px; 
 background: #f8fafc; 
}
.bd-container { max-width: 1280px; margin: 0 auto; padding: 0 16px; }

/* ── STATS ── */
.bd-stats {
 display: grid;
 grid-template-columns: repeat(3, 1fr);
 gap: 24px;
 margin-bottom: 32px;
}
.bd-stat {
 background: #fff;
 border-radius: 20px;
 padding: 24px;
 display: flex;
 align-items: center;
 gap: 20px;
 border: 1px solid #e2e8f0;
 box-shadow: 0 4px 20px rgba(16,43,87,.03);
 transition: all 0.3s ease;
}
.bd-stat:hover { 
 transform: translateY(-2px); 
 box-shadow: 0 10px 30px rgba(16,43,87,.08);
}
.bd-stat__icon {
 width: 56px; height: 56px;
 border-radius: 16px;
 display: flex; align-items: center; justify-content: center;
 font-size: 22px; flex-shrink: 0;
}
.bd-stat--blue .bd-stat__icon { background:#e7efff; color:#2d5bff; }
.bd-stat--yellow .bd-stat__icon { background:#fff9e0; color:#c8980a; }
.bd-stat--green .bd-stat__icon { background:#dcfce7; color:#15803d; }
.bd-stat__label {
 display: block;
 font-size: 11px; font-weight: 700;
 color: #94a3b8;
 text-transform: uppercase; letter-spacing: 0.5px;
 margin-bottom: 4px;
}
.bd-stat__val { font-size: 32px; font-weight: 900; color: #102b57; letter-spacing: -0.5px; }
.bd-stat__val small { font-size: 14px; font-weight: 600; color: #94a3b8; }

/* ── MAIN GRID ── */
.bd-main {
 display: grid;
 grid-template-columns: 1fr 400px;
 gap: 30px;
 align-items: stretch;
}
.bd-left {
 display: flex;
 flex-direction: column;
}
.bd-queue-card {
 height: 100%;
 display: flex;
 flex-direction: column;
}
.bd-queue-card .bd-subhead {
 margin-bottom: 20px;
}
.bd-queue-card .bd-antrean {
 flex: 1;
 display: flex;
 flex-direction: column;
 gap: 12px;
}

/* ── SUBHEAD ── */
.bd-subhead { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
.bd-subhead h2 { margin: 0; font-size: 22px; font-weight: 800; color: #102b57; letter-spacing: -0.5px; }

.bd-tabs { display: flex; gap: 8px; }
.bd-tab {
 padding: 8px 16px; 
 border-radius: 10px;
 border: 1px solid #e2e8f0; 
 font-size: 13px; 
 font-weight: 600;
 background: #fff; 
 color: #64748b;
 text-decoration: none;
 transition: all .2s ease;
 box-shadow: 0 2px 6px rgba(16,43,87,.02);
}
.bd-tab:hover:not(.bd-tab--active) { 
 background: #f1f5f9; 
 color: #102b57;
}
.bd-tab--active { 
 background: #102b57; 
 color: #fff; 
 border-color: #102b57;
 box-shadow: 0 4px 12px rgba(16, 43, 87, 0.1);
}

/* ── ANTREAN ── */
.bd-antrean { display: flex; flex-direction: column; gap: 14px; }
.bd-row {
 display: flex;
 flex-direction: column;
 gap: 14px;
 background: #fff;
 border-radius: 20px;
 padding: 18px 24px;
 border: 1px solid #e2e8f0;
 box-shadow: 0 4px 20px rgba(16,43,87,.03);
 transition: all 0.3s ease;
 opacity: 0;
 transform: translateY(-15px);
 animation: slideDownRow 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes slideDownRow {
 to { opacity: 1; transform: translateY(0); }
}
.bd-row:hover { 
 box-shadow: 0 12px 36px rgba(16,43,87,.12), 0 0 0 1px rgba(246,196,11,.4); 
 transform: translateY(-3px);
 z-index: 10;
 position: relative;
}
.bd-row--active { border-left: 4px solid #f6c40b; }
.bd-row__header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 10px; }
.bd-row__body { display: flex; justify-content: space-between; align-items: center; }
.bd-row__no { font-size: 15px; font-weight: 800; color: #102b57; }
.bd-row__info { display: flex; align-items: center; gap: 12px; }
.bd-row__info img { width: 44px; height: 44px; border-radius: 12px; object-fit: cover; box-shadow: 0 2px 6px rgba(16,43,87,.05); }
.bd-row__info h4 { margin: 0 0 3px; font-size: 15px; font-weight: 700; color: #102b57; }
.bd-row__info p { margin: 0; font-size: 12px; color: #94a3b8; }
.bd-row__time { font-size: 14px; font-weight: 700; color: #475569; white-space: nowrap; }
.bd-row__btn {
 width: 34px; height: 34px;
 border-radius: 10px;
 background: #f1f5f9; border: none;
 cursor: pointer; color: #64748b;
 font-size: 14px;
 display: flex; align-items: center; justify-content: center;
 transition: all 0.2s ease; text-decoration: none;
}
.bd-row__btn:hover { background: #102b57; color: #fff; }

/* BADGE */
.bd-badge {
 min-width: 95px;
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
}
.bd-badge--selesai {
 background: #dcfce7;
 color: #15803d;
}
.bd-badge--proses, .bd-badge--dikonfirmasi {
 background: #eef2ff;
 color: #1d4ed8;
}
.bd-badge--menunggu {
 background: #f1f5f9;
 color: #64748b;
}

/* ── RIGHT COL ── */
.bd-right { display: flex; flex-direction: column; gap: 24px; }
.bd-card { 
 background: #fff; 
 border-radius: 20px; 
 padding: 24px; 
 border: 1px solid #e2e8f0;
 box-shadow: 0 4px 20px rgba(16,43,87,.03); 
 transition: all 0.3s ease;
}
.bd-card:hover {
 box-shadow: 0 10px 30px rgba(16,43,87,.08);
}
.bd-queue-card .bd-row {
 display: flex;
 flex-direction: column;
 gap: 12px;
 background: #f8fafc;
 border: 1px solid #f1f5f9;
 box-shadow: none;
 border-radius: 16px;
 padding: 16px;
}
.bd-queue-card .bd-row:hover {
 background: #f1f5f9;
 transform: translateY(-1px);
}
.bd-row__header {
 display: flex;
 justify-content: space-between;
 align-items: center;
 border-bottom: 1px dashed #e2e8f0;
 padding-bottom: 8px;
}
.bd-row__body {
 display: flex;
 align-items: center;
 justify-content: space-between;
 gap: 12px;
 width: 100%;
}
.bd-row__btn-wrap {
 display: flex;
 align-items: center;
}
.bd-empty-state {
 flex: 1;
 display: flex;
 flex-direction: column;
 align-items: center;
 justify-content: center;
 color: #94a3b8;
 gap: 12px;
 padding: 40px 20px;
}
.bd-empty-state i {
 font-size: 44px;
 color: #cbd5e1;
}
.bd-empty-state p {
 margin: 0;
 font-weight: 600;
 font-size: 15px;
}

/* PROFIL */
.bd-profil { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; }
.bd-profil__img { width: 64px; height: 64px; border-radius: 18px; border: 3px solid #f6c40b; object-fit: cover; flex-shrink: 0; box-shadow: 0 4px 12px rgba(16,43,87,.1); }
.bd-profil__detail { flex: 1; }
.bd-profil__detail h3 { margin: 0 0 4px; font-size: 17px; font-weight: 800; color: #102b57; }
.bd-profil__detail p { margin: 0 0 8px; font-size: 13px; color: #64748b; font-weight: 500; }
.bd-profil__meta { display: flex; gap: 14px; flex-wrap: wrap; }
.bd-profil__meta span { font-size: 12px; font-weight: 600; color: #94a3b8; display: flex; align-items: center; gap: 5px; }
.bd-profil__meta i { color: #f6c40b; }
.bd-btn-edit {
 background: #f6c40b; color: #102b57;
 border-radius: 12px; padding: 10px 18px;
 font-size: 13px; font-weight: 700;
 text-decoration: none;
 display: flex; align-items: center; gap: 6px;
 white-space: nowrap;
 transition: all 0.2s ease;
 box-shadow: 0 4px 12px rgba(246,196,11,.15);
}
.bd-btn-edit:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(246,196,11,.3); }

/* JADWAL */
.bd-jadwal__head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.bd-jadwal__head h3 { margin: 0; font-size: 16px; font-weight: 800; color: #102b57; letter-spacing: -0.3px; }
.bd-jadwal__zone { font-size: 11px; color: #94a3b8; font-weight: 600; }
.bd-jadwal__days { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 12px; }
.bd-jadwal__days::-webkit-scrollbar { height: 6px; }
.bd-jadwal__days::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
.bd-jadwal__days::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.bd-jadwal__days::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
.bd-day {
 flex-shrink: 0;
 display: flex; flex-direction: column; align-items: center; gap: 6px;
 background: #f8fafc; border-radius: 14px;
 padding: 14px 16px; min-width: 90px; text-align: center;
 border: 1px solid #f1f5f9;
 transition: all 0.2s ease;
}
.bd-day:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,43,87,.05); }
.bd-day__tgl { font-size: 11px; color: #94a3b8; font-weight: 700; white-space: nowrap; }
.bd-day__hari { font-size: 16px; font-weight: 800; color: #102b57; }
.bd-day__jam { font-size: 12px; font-weight: 700; color: #64748b; white-space: nowrap; background: #fff; padding: 4px 8px; border-radius: 6px; box-shadow: 0 2px 4px rgba(16,43,87,.02); border: 1px solid #e2e8f0; }
.bd-day--today .bd-day__tgl,
.bd-day--today .bd-day__hari,
.bd-day--today .bd-day__jam { color: #102b57; }
.bd-day--today { background: #f6c40b; border-color: #f6c40b; box-shadow: 0 4px 12px rgba(246,196,11,.2); }
.bd-day--today .bd-day__jam { background: #fff; border: none; }
.bd-day--upcoming { opacity: .7; }

/* KONTAK */
.bd-kontak { display: flex; align-items: center; gap: 12px; }
.bd-kontak__item { flex: 1; display: flex; align-items: center; gap: 12px; }
.bd-kontak__item i { width: 42px; height: 42px; background: #eef4ff; color: #2d5bff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
.bd-kontak__item small { display: block; font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.bd-kontak__item span { font-size: 13.5px; font-weight: 700; color: #102b57; word-break: break-all; }
.bd-kontak__divider { width: 1px; height: 42px; background: #e2e8f0; margin: 0 6px; flex-shrink: 0; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
 .bd-main { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
 .bd-stats { grid-template-columns: 1fr; gap: 16px; }
 .bd-wrapper { padding: 20px 14px 100px; }
 .bd-row { padding: 16px; }
 .bd-row__info img { width: 36px; height: 36px; }
 .bd-row__info h4 { font-size: 14px; }
 .bd-row__no { font-size: 13px; }
 .bd-badge { padding: 5px 12px; font-size: 10px; min-width: auto; }
}
@media (max-width: 480px) {
 .bd-profil { flex-direction: column; text-align: center; }
 .bd-profil__meta { justify-content: center; }
 .bd-kontak { flex-direction: column; gap: 16px; align-items: stretch; }
 .bd-kontak__divider { display: none; }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statVals = document.querySelectorAll('.bd-stat__val');
    statVals.forEach(el => {
        const textVal = el.innerText.trim();
        const target = parseInt(textVal, 10);
        
        // If it's not a number or it's 0, just leave it as is
        if(isNaN(target) || target === 0) return;
        
        let current = 0;
        const duration = 1500; // 1.5 seconds
        const stepTime = Math.abs(Math.floor(duration / target));
        
        el.innerText = '0';
        
        const timer = setInterval(() => {
            current += 1;
            el.innerText = current;
            if(current >= target) {
                el.innerText = target;
                clearInterval(timer);
            }
        }, stepTime);
    });
});
</script>

@endsection