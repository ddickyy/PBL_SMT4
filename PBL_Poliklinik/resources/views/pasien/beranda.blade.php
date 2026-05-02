@php($hideNavbar=false)
@extends('layout.app')

@section('title', 'Beranda Pasien')

{{-- HERO --}}
@section('hero')
    @include('partial.hero', [
        'badge' => 'Layanan Kesehatan Kampus',
        'title' => 'Solusi Kesehatan Terpadu di Kampus Anda',
        'desc' => 'Kami menyediakan layanan kesehatan yang profesional dan terintegrasi di lingkungan kampus.',
        'buttonText' => 'Buat Reservasi',
        'buttonLink' => route('pasien.reservasi'),
        'bg' => asset('images/poliklinik.jpg')
    ])
@endsection

{{-- CONTENT --}}
@section('content')
<section class="home-container">

    {{-- INFO --}}
    <div class="info-grid">

        {{-- JAM --}}
        <div class="card">
            <h3 class="icon-title">
                <svg class="icon blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Jam Operasional
            </h3>

            <div class="schedule">
                <div><span>Senin - Kamis</span><b>08:00 - 16:00</b></div>
                <div><span>Jumat</span><b>08:00 - 14:00</b></div>
                <div class="closed"><span>Sabtu - Minggu</span><b>Tutup</b></div>
            </div>

            <p class="status icon-title">
                @if($isOpen)
                    <svg class="icon success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                    </svg>
                    Sedang Beroperasi
                @else
                    <svg class="icon danger" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup
                @endif
            </p>
        </div>

        {{-- EMERGENCY --}}
        <div class="card emergency">
            <h3 class="icon-title">
                <svg class="icon danger" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M12 9v2m0 4h.01M10 3l-7 12h18L14 3z"/>
                </svg>
                Emergency
            </h3>

            <span class="badge">EMERGENCY</span>
            <h2>085707029645</h2>

            <a href="tel:085707029645" class="btn-danger">Call Now</a>
        </div>

    </div>

    {{-- LAYANAN --}}
    <div class="section-title">
        <h2>Layanan Spesialis</h2>
        <p>Pilih layanan sesuai kebutuhan Anda</p>
    </div>

    <div class="service-grid">
        @foreach($dokters->groupBy('spesialisasi.nama_spesialisasi') as $sp => $items)
            <div class="card service">
                <h3>{{ $sp ?? '-' }}</h3>
                <p>Layanan {{ strtolower($sp ?? '-') }} tersedia</p>
                <span class="small">{{ $items->count() }} dokter</span>
            </div>
        @endforeach
    </div>

    {{-- DOKTER --}}
    <div class="doctor-section">

        <div class="doctor-left">
            <h2>Daftar Dokter</h2>
            <p>Lihat dokter yang tersedia di poliklinik</p>
        </div>

        <div class="doctor-list">
            @foreach($dokters as $dokter)
                @php
                    $jadwal = $dokter->jadwalDokter->first();
                @endphp

                <div class="doctor-item">

                    <div class="doctor-info">
                        <img src="{{ asset('images/default-doctor.png') }}" alt="doctor">
                        <div>
                            <b>{{ $dokter->user->nama ?? '-' }}</b>
                            <p>{{ $dokter->spesialisasi->nama_spesialisasi ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="doctor-meta">
                        @if($jadwal)
                            <span>
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>

                            @if($jadwal->aktif)
                                <span class="status-ok">Tersedia</span>
                            @else
                                <span class="status-full">Tidak Aktif</span>
                            @endif
                        @else
                            <span class="status-full">Belum ada jadwal</span>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>

</section>
@endsection


<style>
main {
    padding: 30px 24px 80px;
    background: #f5f7fb;
}

.home-container {
    max-width: 1200px;
    margin: auto;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.icon-title {
    display: flex;
    gap: 10px;
    align-items: center;
}

.icon {
    width: 20px;
    height: 20px;
    stroke-width: 2;
}

.blue { color: #3b82f6; }
.danger { color: #ef4444; }

.schedule div {
    display: flex;
    justify-content: space-between;
}

.closed {
    background: #f1f5f9;
    padding: 10px;
    border-radius: 10px;
    color: red;
}

.status {
    margin-top: 14px;
    font-weight: 600;
    font-size: 14px;
}

.badge {
    background: red;
    color: white;
    padding: 4px 10px;
    border-radius: 8px;
}

.btn-danger {
    display: block;
    background: red;
    color: white;
    padding: 12px;
    border-radius: 10px;
    text-align: center;
    margin-top: 10px;
}

.service-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.doctor-section {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 24px;
    margin-top: 40px;
}

.doctor-left {
    background: #102b57;
    color: white;
    padding: 30px;
    border-radius: 20px;
}

.doctor-item {
    display: flex;
    justify-content: space-between;
    background: white;
    padding: 16px;
    border-radius: 12px;
    align-items: center;
    gap: 20px;
}

.status-ok { color: #16a34a; }
.status-full { color: #ef4444; }

.icon.success { color: #16a34a; }
.icon.danger { color: #ef4444; }

@media(max-width:768px){
    .info-grid,
    .service-grid,
    .doctor-section {
        grid-template-columns: 1fr;
    }
}
</style>