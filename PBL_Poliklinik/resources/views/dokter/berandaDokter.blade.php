@extends('layout.app')

@php
$dokterLayout = true;
@endphp

@section('title', 'Beranda Dokter')

@section('hero')
@include('partial.hero', [
'badge' => 'Layanan Kesehatan',
'title' => 'Selamat Datang,<br><span style="color:#f6c40b">' . $dokter->user->nama . '</span>',
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
 {{ $reservasiHariIni->count() }}
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
 <h2>Antrean Pasien Hari Ini</h2>

 <a
 href="{{ route('dokter.pasien') }}"
 class="bd-link"
>
 Lihat Semua
 </a>
 </div>

 <div class="bd-antrean">

 @forelse($reservasiHariIni as $p)

 <div class="bd-row @if($p->status === 'dikonfirmasi') bd-row--active @endif" onclick="window.location='{{ route('dokter.pasien.detail', $p->id_reservasi) }}'" style="cursor: pointer;">

 <div class="bd-row__header">
 <span class="bd-row__no">#{{ $p->nomor_antrian }} - {{ \Carbon\Carbon::parse($p->estimasi_jam)->format('H:i') }} WIB</span>
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
 <p>Tidak ada antrean pasien hari ini.</p>
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

 @foreach($jadwalList as $j)

 <div class="bd-day">

 <span class="bd-day__tgl">
 {{ strtoupper($j->hari) }}
 </span>

 <span class="bd-day__hari">
 {{ substr($j->hari,0,3) }}
 </span>

 <span class="bd-day__jam">
 {{ substr($j->jam_mulai,0,5) }}
 -
 {{ substr($j->jam_selesai,0,5) }}
 </span>

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
.bd-subhead { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.bd-subhead h2 { margin: 0; font-size: 22px; font-weight: 800; color: #102b57; letter-spacing: -0.5px; }
.bd-link { color: #2d5bff; font-size: 14px; font-weight: 700; text-decoration: none; transition: opacity 0.2s ease; }
.bd-link:hover { opacity: 0.8; }

/* ── ANTREAN ── */
.bd-antrean { display: flex; flex-direction: column; gap: 14px; }
.bd-row {
 display: grid;
 grid-template-columns: 36px 1fr auto auto auto;
 align-items: center;
 gap: 20px;
 background: #fff;
 border-radius: 20px;
 padding: 18px 24px;
 border: 1px solid #e2e8f0;
 box-shadow: 0 4px 20px rgba(16,43,87,.03);
 transition: all 0.3s ease;
}
.bd-row:hover { 
 box-shadow: 0 10px 30px rgba(16,43,87,.08); 
 transform: translateY(-1px);
}
.bd-row--active { border-left: 4px solid #f6c40b; }
.bd-row__no { font-size: 16px; font-weight: 800; color: #cbd5e1; }
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
.bd-jadwal__days { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 6px; scrollbar-width: none; }
.bd-jadwal__days::-webkit-scrollbar { display: none; }
.bd-day {
 flex-shrink: 0;
 display: flex; flex-direction: column; align-items: center; gap: 6px;
 background: #f8fafc; border-radius: 14px;
 padding: 14px 12px; min-width: 76px; text-align: center;
 border: 1px solid #f1f5f9;
}
.bd-day__tgl { font-size: 10px; color: #94a3b8; font-weight: 700; white-space: nowrap; }
.bd-day__hari { font-size: 15px; font-weight: 800; color: #102b57; }
.bd-day__jam { font-size: 10px; font-weight: 700; color: #64748b; white-space: nowrap; }
.bd-day--today .bd-day__tgl,
.bd-day--today .bd-day__hari,
.bd-day--today .bd-day__jam { color: #102b57; }
.bd-day--today { background: #f6c40b; border-color: #f6c40b; box-shadow: 0 4px 12px rgba(246,196,11,.2); }
.bd-day--upcoming { opacity: .55; }

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
}
@media (max-width: 480px) {
 .bd-profil { flex-direction: column; text-align: center; }
 .bd-profil__meta { justify-content: center; }
 .bd-kontak { flex-direction: column; gap: 16px; align-items: stretch; }
 .bd-kontak__divider { display: none; }
}

</style>

@endsection