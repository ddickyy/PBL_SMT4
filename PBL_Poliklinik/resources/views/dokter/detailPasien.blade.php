@extends('layout.app')

@php
 $dokterLayout = true;
@endphp

@section('title', 'Detail Pasien')
@section('hero')

 @include('partial.hero', [
 'badge' => 'Detail Pasien',
 'title' => 'Informasi Lengkap Pasien',
 'desc' => 'Lihat informasi lengkap pasien, termasuk keluhan, diagnosa, dan catatan dokter.',
 'buttonText' => null,
 'buttonLink' => null, 
 'bg' => asset('images/poliklinik.jpg'),
 ])

@section('content')

 @php

 $statusConfig = [
 'selesai' => ['bg' => '#dcfce7', 'color' => '#15803d'],
 'dikonfirmasi' => ['bg' => '#eef2ff', 'color' => '#1d4ed8'],
 'menunggu' => ['bg' => '#fef9e0', 'color' => '#b59008'],
 'dibatalkan' => ['bg' => '#fee2e2', 'color' => '#dc2626'],
 ];

 $sc = $statusConfig[$pasien->status] ?? $statusConfig['menunggu'];

 $fotoUrl = $pasien->user->foto
 ? asset('storage/' . $pasien->user->foto)
 : 'https://ui-avatars.com/api/?name=' . urlencode($pasien->user->nama) . '&background=102b57&color=fff&size=120';

 @endphp

 <section class="det-section">

 <div class="det-container">

 @if(session('success'))
 <div class="alert-success" style="background: #dcfce7; color: #15803d; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(22, 101, 52, 0.05); display: flex; align-items: center; gap: 8px;">
 <i class="fa-solid fa-circle-check"></i>
 <span>{{ session('success') }}</span>
 </div>
 @endif

 @if($errors->any())
 <div class="alert-error" style="background: #fee2e2; color: #dc2626; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.05); display: flex; align-items: flex-start; gap: 8px;">
 <i class="fa-solid fa-circle-exclamation"></i>
 <ul style="margin: 0; padding-left: 18px;">
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
 @endif

 {{-- TOPBAR --}}
 <div class="det-topbar" data-aos="fade-up">

 <a href="{{ route('dokter.pasien') }}" class="det-btn det-btn-back">
 <i class="fa-solid fa-arrow-left"></i>
 Kembali
 </a>

 </div>

 {{-- GRID --}}
 <div class="det-grid">

 {{-- LEFT --}}
 <div class="det-left" data-aos="fade-up">

 {{-- PROFILE --}}
 <div class="det-card">

 <div class="det-profile">

 <img src="{{ $fotoUrl }}" alt="{{ $pasien->user->nama }}">

 <h2>{{ $pasien->user->nama }}</h2>

 <p>{{ $pasien->user->identitas }}</p>

 <span class="det-kategori">
 {{ $pasien->user->jenis_pasien }}
 </span>

 <span class="det-status" style="background:{{ $sc['bg'] }}; color:{{ $sc['color'] }}">
 {{ ucfirst($pasien->status) }}
 </span>

 </div>

 </div>

 {{-- INFO PASIEN --}}
 <div class="det-card">

 <h3 class="det-title">
 Informasi Pasien
 </h3>

 <div class="det-info-list">

 <div class="det-info-item">
 <small>Email</small>
 <strong>{{ $pasien->user->email }}</strong>
 </div>

 <div class="det-info-item">
 <small>Telepon</small>
 <strong>{{ $pasien->user->mahasiswa->no_hp ?? $pasien->user->dosen->no_hp ?? $pasien->user->tendik->no_hp ?? '-' }}</strong>
 </div>


 <div class="det-info-item">
 <small>No Antrean</small>
 <strong>#{{ $pasien->nomor_antrian }}</strong>
 </div>

 <div class="det-info-item">
 <small>Jadwal Reservasi</small>
 <strong>{{ \Carbon\Carbon::parse($pasien->tanggal_reservasi)->translatedFormat('d F Y') }}</strong>
 </div>

 <div class="det-info-item">
 <small>Jam Reservasi</small>
 <strong>{{ \Carbon\Carbon::parse($pasien->estimasi_jam)->format('H:i') }} WIB</strong>
 </div>

 </div>

 </div>

 </div>

 {{-- RIGHT --}}
 <div class="det-right" data-aos="fade-up">

 {{-- REKAM MEDIS --}}
 <div class="det-card">

 <h3 class="det-title" style="border-bottom: 2px solid #eef2f7; padding-bottom: 12px; margin-bottom: 20px;">
 Pemeriksaan & Rekam Medis Pasien
 </h3>

 <form action="{{ route('dokter.pasien.rekamMedis', $pasien->id_reservasi) }}" method="POST">
 @csrf
 
 <div style="margin-bottom: 20px;">
 <label for="diagnosis" style="display: block; font-size: 13px; font-weight: 700; color: #102b57; margin-bottom: 8px;">
 DIAGNOSA PENYAKIT
 </label>
 <textarea id="diagnosis" class="det-textarea" name="diagnosis" required placeholder="Tuliskan diagnosa penyakit pasien di sini..." style="min-height: 120px;">{{ optional($pasien->rekamMedis)->diagnosis }}</textarea>
 </div>

 <div style="margin-bottom: 24px;">
 <label for="catatan" style="display: block; font-size: 13px; font-weight: 700; color: #102b57; margin-bottom: 8px;">
 CATATAN DOKTER
 </label>
 <textarea id="catatan" class="det-textarea" name="catatan" placeholder="Tuliskan catatan tambahan, anjuran obat, atau petunjuk medis lainnya..." style="min-height: 120px;">{{ optional($pasien->rekamMedis)->catatan }}</textarea>
 </div>

 <div class="det-form-action" style="display: flex; justify-content: flex-end;">
 <button type="submit" class="det-save-btn" style="padding: 12px 30px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
 <i class="fa-solid fa-floppy-disk"></i>
 Simpan Perubahan
 </button>
 </div>
 </form>

 </div>

 {{-- KRITIK & SARAN --}}
 <div class="det-card" style="margin-top: 24px;">

 <h3 class="det-title" style="border-bottom: 2px solid #eef2f7; padding-bottom: 12px; margin-bottom: 20px;">
 Kritik & Saran dari Pasien
 </h3>

 @if($pasien->penilaian)
 <div class="det-info-list" style="display: grid; grid-template-columns: 1fr; gap: 14px;">
 <div class="det-info-item" style="background: #fff9e6; border-color: #ffe0b2; padding: 16px;">
 <small style="color: #b7791f; font-size: 11px; font-weight: 700; text-transform: uppercase;">Kritik Pasien</small>
 <strong style="color: #744210; font-weight: 500; font-size: 14px; margin-top: 6px; display: block;">
 {{ $pasien->penilaian->kritik ?? '-' }}
 </strong>
 </div>
 <div class="det-info-item" style="background: #ecfdf5; border-color: #a7f3d0; padding: 16px;">
 <small style="color: #047857; font-size: 11px; font-weight: 700; text-transform: uppercase;">Saran Pasien</small>
 <strong style="color: #064e3b; font-weight: 500; font-size: 14px; margin-top: 6px; display: block;">
 {{ $pasien->penilaian->saran ?? '-' }}
 </strong>
 </div>
 </div>
 @else
 <div style="color: #94a3b8; font-size: 14px; text-align: center; padding: 24px 0;">
 <i class="fa-regular fa-comment-dots" style="font-size: 32px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
 Belum ada kritik dan saran yang diberikan oleh pasien.
 </div>
 @endif

 </div>

 </div>

 </div>

 </div>

 </section>

 <style>


 .det-section {
 font-family: 'Poppins', system-ui, sans-serif;
 padding: 40px 24px 80px;
 background: #f8fafc;
 }

 .det-container {
 max-width: 1200px;
 margin: auto;
 }

 .det-topbar {
 display: flex;
 justify-content: space-between;
 align-items: center;
 margin-bottom: 24px;
 }

 .det-btn {
 border: none;
 border-radius: 14px;
 padding: 12px 22px;
 font-size: 14px;
 font-weight: 700;
 cursor: pointer;
 text-decoration: none;
 display: flex;
 align-items: center;
 gap: 8px;
 box-shadow: 0 4px 12px rgba(16, 43, 87, 0.05);
 transition: all 0.2s ease;
 }

 .det-btn-back {
 background: #fff;
 color: #102b57;
 border: 1px solid #e2e8f0;
 }

 .det-btn:hover {
 transform: translateY(-2px);
 box-shadow: 0 8px 20px rgba(16, 43, 87, 0.1);
 }

 .det-grid {
 display: grid;
 grid-template-columns: 360px 1fr;
 gap: 30px;
 align-items: start;
 }

 .det-left,
 .det-right {
 display: flex;
 flex-direction: column;
 gap: 24px;
 }

 .det-card {
 background: #fff;
 border-radius: 20px;
 padding: 30px;
 border: 1px solid #e2e8f0;
 box-shadow: 0 4px 20px rgba(16, 43, 87, 0.03);
 transition: all 0.3s ease;
 }

 .det-card:hover {
 box-shadow: 0 10px 30px rgba(16, 43, 87, 0.08);
 transform: translateY(-1px);
 }

 .det-profile {
 text-align: center;
 }

 .det-profile img {
 width: 96px;
 height: 96px;
 border-radius: 24px;
 object-fit: cover;
 margin-bottom: 16px;
 box-shadow: 0 8px 24px rgba(16, 43, 87, 0.1);
 }

 .det-profile h2 {
 margin: 0;
 font-size: 22px;
 font-weight: 800;
 color: #102b57;
 letter-spacing: -0.5px;
 }

 .det-profile p {
 margin: 6px 0 16px;
 color: #64748b;
 font-size: 14px;
 font-weight: 500;
 }

 .det-kategori {
 display: inline-flex;
 padding: 6px 16px;
 border-radius: 99px;
 background: #eef2ff;
 color: #3b82f6;
 font-size: 12px;
 font-weight: 700;
 margin-bottom: 14px;
 }

 .det-status {
 display: flex;
 align-items: center;
 justify-content: center;
 width: 110px;
 margin: auto;
 padding: 8px 16px;
 border-radius: 99px;
 font-size: 11px;
 font-weight: 800;
 letter-spacing: 0.5px;
 text-transform: uppercase;
 }

 .det-title {
 margin: 0 0 20px;
 font-size: 16px;
 font-weight: 800;
 color: #102b57;
 letter-spacing: -0.3px;
 }

 .det-info-item {
 display: flex;
 flex-direction: column;
 gap: 6px;
 background: #f8fafc;
 padding: 12px 14px;
 border-radius: 12px;
 border: 1px solid #f1f5f9;
 }

 .det-info-item small {
 font-size: 10px;
 color: #94a3b8;
 font-weight: 700;
 text-transform: uppercase;
 letter-spacing: 0.5px;
 }

 .det-info-item strong {
 font-size: 13px;
 color: #1e293b;
 font-weight: 600;
 word-break: break-all;
 }

 .det-textarea {
 width: 100%;
 min-height: 140px;
 border: 1.5px solid #e2e8f0;
 border-radius: 16px;
 padding: 18px;
 resize: vertical;
 font-size: 14px;
 line-height: 1.7;
 outline: none;
 background: #f8fafc;
 color: #334155;
 font-family: inherit;
 transition: all 0.2s ease;
 }

 .det-textarea:focus {
 border-color: #102b57;
 background: #fff;
 box-shadow: 0 0 0 4px rgba(16, 43, 87, 0.06);
 }

 .det-save-btn {
 border: none;
 background: #102b57;
 color: #fff;
 padding: 14px 28px;
 border-radius: 14px;
 font-size: 14px;
 font-weight: 700;
 cursor: pointer;
 box-shadow: 0 4px 12px rgba(16, 43, 87, 0.15);
 transition: all 0.2s ease;
 }

 .det-save-btn:hover {
 transform: translateY(-2px);
 box-shadow: 0 8px 24px rgba(16, 43, 87, 0.25);
 background: #0d2245;
 }

 @media(max-width: 900px) {
 .det-grid {
 grid-template-columns: 1fr;
 }
 }

 @media(max-width: 600px) {
 .det-topbar {
 flex-direction: column;
 align-items: stretch;
 }
 .det-btn {
 justify-content: center;
 }
 .det-info-list {
 grid-template-columns: 1fr;
 }
 }
 </style>

@endsection