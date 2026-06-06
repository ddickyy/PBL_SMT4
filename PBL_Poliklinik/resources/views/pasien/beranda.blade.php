@extends('layout.app')

@section('title', 'Beranda')

@section('hero')

@include('partial.hero', [
 'badge' => 'Layanan Kesehatan Kampus',
 'title' => 'Solusi Kesehatan Terpadu di Kampus Anda',
 'desc' => 'Kami menyediakan layanan kesehatan yang profesional dan terintegrasi di lingkungan kampus untuk mendukung kebutuhan kesehatan Anda.',
 'buttonText' => 'Buat Reservasi',
 'buttonLink' => route('pasien.reservasi.index'),
 'bg' => asset('images/poliklinik.jpg')
])

@endsection

@section('content')

<section class="home-section">
 <div class="home-container">

 {{-- INFO --}}
 <div class="info-grid" data-aos="fade-up">

 {{-- OPERASIONAL --}}
 <div class="card">
 <div class="card-header">
 <div class="icon-box blue">
 <i class="fa-regular fa-clock"></i>
 </div>
 <h3>Jam Operasional Poliklinik</h3>
 </div>

 <div class="schedule-list">
 <div class="schedule-item">
 <span>Senin - Kamis</span>
 <strong>08:00 - 16:00</strong>
 </div>

 <div class="schedule-item">
 <span>Jumat</span>
 <strong>08:00 - 14:00</strong>
 </div>

 <div class="schedule-item closed">
 <span>Sabtu - Minggu</span>
 <strong>Tutup</strong>
 </div>
 </div>

 <div class="status-operational">
 <span class="status-dot {{ $isOpen ? 'open' : 'close' }}"></span>

 <span>
 {{ $isOpen ? 'Saat ini sedang beroperasi' : 'Saat ini tutup' }}
 </span>
 </div>
 </div>

 {{-- EMERGENCY --}}
 <div class="card">
 <div class="card-header">
 <div class="icon-box red">
 <i class="fa-solid fa-asterisk"></i>
 </div>

 <h3>Emergency Call</h3>
 </div>

 <span class="emergency-badge">
 EMERGENCY
 </span>

 <h2 class="emergency-number">
 085707029645
 </h2>

 <p class="emergency-desc">
 Tim medis kami siap siaga untuk menangani kondisi darurat kapan saja.
 Hubungi nomor yang tersedia untuk mendapatkan bantuan segera.
 </p>

 <a href="https://wa.me/6285707029645" target="_blank" class="btn-emergency">
 <i class="fa-brands fa-whatsapp"></i>
 Hubungi via WhatsApp
 </a>
 </div>
 </div>

 {{-- LAYANAN --}}
 <div class="section-heading" data-aos="fade-up">
 <h2>Layanan Spesialis</h2>
 <p>Pilih layanan kesehatan sesuai dengan kebutuhan Anda</p>
 </div>
 <div class="service-grid" data-aos="fade-up">
 @forelse($spesialisasiGroups as $namaSpesialisasi => $group)

 @php
 $spesialisasiLower = strtolower($namaSpesialisasi ?? '');
 @endphp
 
 <a href="{{ route('pasien.dokter.index', ['spesialisasi' => optional($group->first()?->spesialisasi)->id_spesialisasi]) }}" class="service-card" style="text-decoration: none; color: inherit;">
 <div class="service-top">
 <div class="service-icon">
 @if(str_contains($spesialisasiLower, 'gigi'))
 <i class="fa-solid fa-tooth"></i>
 @elseif(str_contains($spesialisasiLower, 'umum'))
 <i class="fa-solid fa-stethoscope"></i>
 @else
 <i class="fa-solid fa-user-doctor"></i>
 @endif
 </div>
 <span class="service-label">
 LAYANAN SPESIALIS
 </span>
 </div>

 <h3>{{ $namaSpesialisasi }}</h3>
 <p>
 {{
 optional(
 $group->first()?->spesialisasi
 )->deskripsi
 ??
 'Deskripsi layanan belum tersedia.'
 }}
 </p>

 <div class="doctor-count">
 {{ $group->count() }} Dokter Tersedia
 </div>
 </a>
 
 @empty
 <div class="empty-service">
 <div class="empty-service-icon">
 <i class="fa-solid fa-hospital"></i>
 </div>
 <h3>Belum Ada Layanan Tersedia</h3>
 <p>
 Saat ini layanan spesialis belum tersedia.
 </p>
 </div>
 @endforelse
 </div>

 {{-- DAFTAR DOKTER --}}
<div class="doctor-section" data-aos="fade-up">
 <div class="doctor-left">
 <h2>Daftar Dokter Hari ini</h2>
 <p style="margin-bottom: 24px;">
 Lihat daftar dokter yang tersedia di poliklinik
 untuk memudahkan kunjungan Anda.
 </p>
 @if($dokters->count()> 0)
 <a href="{{ route('pasien.dokter.index') }}" class="btn-more-dokter-left">
 <span>Lihat Selengkapnya</span>
 <i class="fa-solid fa-arrow-right"></i>
 </a>
 @endif
 </div>

 <div class="doctor-right">
 @forelse($doktersHariIni as $dokter)
 @php
 $fotoDokter = optional($dokter->user)->foto;
 $namaDokter = optional($dokter->user)->nama ?? 'Dokter';

 $inisial = collect(explode(' ', $namaDokter))
 ->filter()
 ->map(fn ($kata) => strtoupper(substr($kata, 0, 1)))
 ->take(2)
 ->implode('');

 $jamSekarang = \Carbon\Carbon::now()->format('H:i:s');

 // Check if doctor has schedule today
 $jadwalHariIni = $dokter->jadwalDokter->first(function($j) use ($hariSekarang) {
 return strtolower($j->hari) === strtolower($hariSekarang) && $j->aktif;
 });

 $sedangPraktik = false;
 if ($jadwalHariIni) {
 $sedangPraktik = $jamSekarang>= $jadwalHariIni->jam_mulai && $jamSekarang <= $jadwalHariIni->jam_selesai;
 }
 @endphp

 <a href="{{ route('pasien.reservasi.index') }}" class="doctor-item" style="text-decoration: none; color: inherit;">
 <div class="doctor-profile">
 @if($fotoDokter)
 <img
 src="{{ asset('storage/' . $fotoDokter) }}"
 alt="Foto Dokter">
 @else
 <div class="doctor-avatar">
 {{ $inisial }}
 </div>
 @endif

 <div>
 <h4>{{ $namaDokter }}</h4>
 <p>{{ optional($dokter->spesialisasi)->nama_spesialisasi ?? '-' }}</p>
 </div>
 </div>

 <div class="doctor-time">
 @if($jadwalHariIni)
 <span class="doctor-day" style="color: #102b57; font-weight: 700;">
 Hari Ini ({{ $hariSekarang }})
 </span>
 <strong>
 {{ \Carbon\Carbon::parse($jadwalHariIni->jam_mulai)->format('H:i') }}
 -
 {{ \Carbon\Carbon::parse($jadwalHariIni->jam_selesai)->format('H:i') }} WIB
 </strong>
 @else
 <span class="doctor-day" style="color: #dc2626; font-weight: 700;">
 Tidak ada jadwal dokter
 </span>
 <strong style="color: #94a3b8; font-size: 13px;">
 Hari Ini ({{ $hariSekarang }})
 </strong>
 @endif
 </div>

 <div>
 @if($sedangPraktik)
 <span class="badge available">
 Tersedia
 </span>
 @else
 <span class="badge full">
 Tidak Tersedia
 </span>
 @endif
 </div>
 </a>
 @empty
 <div class="empty-doctor-home">
 <div class="empty-doctor-home-icon">
 <i class="fa-solid fa-user-doctor"></i>
 </div>
 <h3>Tidak Ada Dokter yang Bertugas</h3>
 <p>
 Tidak ada dokter yang bertugas hari ini ({{ $hariSekarang }}).
 </p>
 </div>
 @endforelse


 </div>
</div>
 </div>
</section>

<style>

 .home-section {
 padding: 30px 24px 60px;
 background: #f5f7fb;
 }

 .home-container {
 max-width: 1200px;
 margin: 0 auto;
 padding: 0 32px;
 }

 .info-grid {
 display: grid;
 grid-template-columns: repeat(2, 1fr);
 gap: 24px;
 margin-bottom: 40px;
 }

 .card {
 background: white;
 border-radius: 28px;
 padding: 28px;
 box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
 }

 .card-header {
 display: flex;
 align-items: center;
 gap: 14px;
 margin-bottom: 24px;
 }

 .card-header h3 {
 margin: 0;
 font-size: 22px;
 font-weight: 800;
 color: #102b57;
 }

 .doctor-avatar {
 width: 64px;
 height: 64px;
 border-radius: 50%;
 background: #102b57;
 color: white;
 display: flex;
 align-items: center;
 justify-content: center;
 font-weight: 700;
 font-size: 18px;
 text-transform: uppercase;
 text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}
.doctor-day {
 display: block;
 font-size: 15px;
 font-weight: 600;
 color: #374151;
 margin-bottom: 2px;
}

.doctor-time strong {
 display: block;
 font-size: 15px;
}

 .icon-box {
 width: 48px;
 height: 48px;
 border-radius: 14px;
 display: flex;
 align-items: center;
 justify-content: center;
 }

 .icon-box.blue {
 background: #e7efff;
 color: #2d5bff;
 }

 .icon-box.red {
 background: #ffe5e5;
 color: #ef4444;
 }

 .schedule-list {
 display: flex;
 flex-direction: column;
 gap: 14px;
 margin-bottom: 22px;
 }

 .schedule-item {
 display: flex;
 justify-content: space-between;
 align-items: center;
 background: #f8fafc;
 padding: 15px 18px;
 border-radius: 14px;
 color: #64748b;
 }

 .schedule-item strong {
 color: #102b57;
 }

 .schedule-item.closed {
 color: #ef4444;
 }

 .schedule-item.closed strong {
 color: #ef4444;
 }

 .status-operational {
 display: flex;
 align-items: center;
 gap: 10px;
 font-size: 14px;
 font-weight: 600;
 }

 .status-operational.is-open { 
 color: #0f766e; 
 } 
 
 .status-operational.is-close { 
 color: #dc2626; 
 }

 .status-dot {
 width: 10px;
 height: 10px;
 border-radius: 50%;
 }

 .status-dot.open {
 background: #22c55e;
 }

 .status-dot.close {
 background: #ef4444;
 }

 .emergency-badge {
 display: inline-block;
 background: #ef4444;
 color: white;
 padding: 6px 12px;
 border-radius: 999px;
 font-size: 11px;
 font-weight: 700;
 margin-bottom: 12px;
 }

 .emergency-number {
 margin: 0 0 12px;
 font-size: 34px;
 font-weight: 900;
 color: #102b57;
 }

 .emergency-desc {
 color: #64748b;
 line-height: 1.7;
 margin-bottom: 24px;
 }

 .btn-emergency {
 background: #ef4444;
 color: white;
 padding: 15px;
 border-radius: 16px;
 text-decoration: none;
 display: flex;
 align-items: center;
 justify-content: center;
 gap: 10px;
 font-weight: 700;
 transition: all .25s ease;
 }

 .btn-emergency:hover {
 background: #dc2626;
 transform: translateY(-2px);
 }

 .section-heading {
 margin-bottom: 22px;
 }

 .section-heading h2 {
 margin: 0 0 8px;
 font-size: 30px;
 font-weight: 900;
 color: #102b57;
 }

 .section-heading p {
 margin: 0;
 color: #64748b;
 }

 .service-grid {
 display: grid;
 grid-template-columns: repeat(2, 1fr);
 gap: 24px;
 margin-bottom: 36px;
 }

 .service-card {
 background: white;
 border-radius: 28px;
 padding: 28px;
 box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
 }

 .service-top {
 display: flex;
 justify-content: space-between;
 align-items: center;
 margin-bottom: 24px;
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

 .service-label {
 font-size: 11px;
 font-weight: 800;
 color: #94a3b8;
 letter-spacing: 1px;
 }

 .service-card h3 {
 margin: 0 0 12px;
 font-size: 28px;
 color: #102b57;
 }

 .service-card p {
 color: #64748b;
 line-height: 1.7;
 margin-bottom: 20px;
 }

 .doctor-count {
 font-size: 14px;
 font-weight: 700;
 color: #102b57;
 }

 .doctor-section {
 display: grid;
 grid-template-columns: 320px 1fr;
 gap: 24px;
 background: white;
 border-radius: 28px;
 padding: 24px;
 box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
 }

 .doctor-left {
 background: #102b57;
 color: white;
 border-radius: 22px;
 padding: 36px 28px;
 }

 .doctor-left h2 {
 margin: 0 0 14px;
 font-size: 36px;
 font-weight: 800;
 }

 .doctor-left p {
 color: rgba(255,255,255,.8);
 line-height: 1.7;
 }

 .doctor-right {
 display: flex;
 flex-direction: column;
 gap: 16px;
 }

 .doctor-item {
 display: grid;
 grid-template-columns: 1fr auto auto;
 gap: 20px;
 align-items: center;
 background: #f8fafc;
 padding: 16px 18px;
 border-radius: 18px;
 }

 .doctor-profile {
 display: flex;
 align-items: center;
 gap: 14px;
 }

 .doctor-profile img {
 width: 52px;
 height: 52px;
 border-radius: 14px;
 object-fit: cover;
 }

 .doctor-profile h4 {
 margin: 0;
 font-size: 17px;
 color: #102b57;
 }

 .doctor-profile p {
 margin: 4px 0 0;
 color: #64748b;
 font-size: 14px;
 }

 .doctor-time small {
 display: block;
 color: #94a3b8;
 font-size: 11px;
 font-weight: 700;
 margin-bottom: 4px;
 }

 .doctor-time strong {
 color: #102b57;
 font-size: 15px;
 }

 .badge {
 padding: 8px 14px;
 border-radius: 999px;
 font-size: 13px;
 font-weight: 700;
 }

 .badge.available {
 background: #dcfce7;
 color: #15803d;
 }

 .badge.full {
 background: #fee2e2;
 color: #dc2626;
 }

 .btn-more-dokter-left {
 display: inline-flex;
 align-items: center;
 justify-content: center;
 gap: 8px;
 padding: 12px 24px;
 background: rgba(255, 255, 255, 0.08);
 border: 2px solid rgba(255, 255, 255, 0.3);
 border-radius: 14px;
 color: white;
 font-weight: 700;
 font-size: 14px;
 text-decoration: none;
 transition: all 0.25s ease;
 margin-top: 14px;
 }

 .btn-more-dokter-left:hover {
 background: white;
 color: #102b57;
 border-color: white;
 transform: translateY(-2px);
 }

 .empty-service,
 .empty-doctor-home {
 grid-column: 1 / -1;
 background: white;
 border-radius: 28px;
 padding: 70px 30px;
 text-align: center;
 box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
 }

 .empty-service-icon,
 .empty-doctor-home-icon {
 width: 90px;
 height: 90px;
 margin: 0 auto 22px;
 border-radius: 50%;
 background: #eef4ff;
 color: #1d4ed8;
 display: flex;
 align-items: center;
 justify-content: center;
 font-size: 36px;
 }

 .empty-service h3,
 .empty-doctor-home h3 {
 margin: 0 0 12px;
 font-size: 28px;
 font-weight: 800;
 color: #102b57;
 }

 .empty-service p,
 .empty-doctor-home p {
 margin: 0;
 color: #64748b;
 line-height: 1.8;
 font-size: 15px;
 }

 @media (max-width: 1024px) {

 .info-grid,
 .service-grid,
 .doctor-section {
 grid-template-columns: 1fr;
 }

 }

 @media (max-width: 768px) {

 .home-section {
 padding: 20px 14px 50px;
 }

 .info-grid,
 .service-grid {
 grid-template-columns: 1fr;
 }

 .doctor-item {
 grid-template-columns: 1fr;
 align-items: flex-start;
 }

 .doctor-more {
 text-align: left;
 }

 .emergency-number {
 font-size: 28px;
 }

 .section-heading h2 {
 font-size: 24px;
 }

 .doctor-left h2 {
 font-size: 28px;
 }

 }

</style>
@endsection