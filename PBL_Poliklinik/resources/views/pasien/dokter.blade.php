@extends('layout.app')

@section('title', 'Daftar Dokter')

@section('hero')
@include('partial.hero', [
    'badge' => 'Layanan Kesehatan Kampus',
    'title' => 'Daftar & Jadwal <br><span style="color:#facc15;">Dokter Poliklinik</span>',
    'desc' => 'Kami menghadirkan tenaga medis profesional terbaik untuk mendukung kesehatan seluruh warga Polinema melalui pelayanan yang hangat dan berstandar tinggi.',
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])
@endsection

@section('content')
<section class="doctor-page">
    <div class="doctor-container">

        <div class="section-heading">
            <h2>Tenaga Medis Berpengalaman</h2>
        </div>

        <!-- Filter Bar -->
        <div class="doctor-filter-bar">
            <form action="{{ route('pasien.dokter.index') }}" method="GET" class="doc-search-form">
                <div class="doc-search-input-wrap">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama dokter...">
                </div>
                
                <div class="doc-filter-select-wrap">
                    <i class="fa-solid fa-stethoscope filter-icon"></i>
                    <select name="spesialisasi" onchange="this.form.submit()">
                        <option value="">Semua Spesialisasi</option>
                        @foreach($spesialisasis ?? [] as $sp)
                            <option value="{{ $sp->id_spesialisasi }}" {{ (int)($spesialisasi ?? 0) === $sp->id_spesialisasi ? 'selected' : '' }}>
                                {{ $sp->nama_spesialisasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if($search || $spesialisasi)
                    <a href="{{ route('pasien.dokter.index') }}" class="btn-reset">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="doctor-grid">

            @forelse($dokters as $item)

                @php
                    $spesialisasi = strtolower(
                        optional($item->spesialisasi)->nama_spesialisasi ?? ''
                    );

                    $foto = optional($item->user)->foto;

                    $namaDokter = optional($item->user)->nama ?? 'Dokter';

                    $inisial = collect(explode(' ', $namaDokter))
                        ->filter()
                        ->map(fn ($kata) => strtoupper(substr($kata, 0, 1)))
                        ->take(2)
                        ->implode('');
                @endphp

                <div class="doctor-card">

                    {{-- FOTO DOKTER --}}
                    <div class="doctor-image">

                        @if($foto)
                            <img
                                src="{{ asset('storage/' . $foto) }}"
                                alt="Doctor">
                        @else
                            <div class="doctor-avatar-large">
                                {{ $inisial }}
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="doctor-content">
                        <span class="doctor-badge">
                            {{ optional($item->spesialisasi)->nama_spesialisasi ?? 'POLI UMUM' }}
                        </span>
                        <h3>
                            {{ $namaDokter }}
                        </h3>
                        {{-- SPESIALISASI --}}
                        <div class="doctor-specialist">
                            @if(str_contains($spesialisasi, 'gigi'))
                                <i class="fa-solid fa-tooth"></i>
                            @elseif(str_contains($spesialisasi, 'mata'))
                                <i class="fa-solid fa-eye"></i>
                            @elseif(str_contains($spesialisasi, 'anak'))
                                <i class="fa-solid fa-baby"></i>
                            @elseif(str_contains($spesialisasi, 'jantung'))
                                <i class="fa-solid fa-heart-pulse"></i>
                            @else
                                <i class="fa-solid fa-stethoscope"></i>
                            @endif

                            <span>
                                {{ optional($item->spesialisasi)->nama_spesialisasi ?? '-' }}
                            </span>
                        </div>

                        {{-- JADWAL --}}
                        <div class="doctor-schedule-list">

                            @forelse($item->jadwalDokter as $jadwal)
                                <div class="doctor-schedule">
                                    <div class="schedule-icon">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>

                                    <div>
                                        <small>
                                            JADWAL PRAKTIK
                                        </small>
                                        <strong class="schedule-day">
                                            {{ $jadwal->hari }}
                                        </strong>

                                        <span class="schedule-time">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            WIB
                                        </span>
                                    </div>
                                </div>

                                @empty
                                <div class="empty-schedule">
                                    Jadwal belum tersedia.
                                </div>
                            @endforelse
                        </div>

                        {{-- DESKRIPSI --}}
                       <p class="doctor-description">
                            {{ optional($item->spesialisasi)->deskripsi 
                            ?? 'Layanan kesehatan profesional untuk membantu menjaga kesehatan pasien.' }}
                        </p>

                        {{-- BUTTON --}}
                        <a href="{{ route('pasien.reservasi.index') }}"
                           class="btn-book">
                            Buat Reservasi
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            @empty
                <div class="empty-doctor">
                    <div class="empty-icon">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <h3>
                        Belum Ada Dokter Tersedia
                    </h3>
                    <p>
                        Saat ini data dokter belum tersedia.
                        Silakan kembali beberapa saat lagi.
                    </p>
                </div>
            @endforelse
        </div>

        @if($dokters->hasPages())
            <div class="pagination-wrap">
                {{ $dokters->links() }}
            </div>
        @endif

    </div>
</section>

<style>

    .doctor-page {
        padding: 34px 24px 70px;
        background: #f5f7fb;
    }

    .doctor-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .section-heading {
        margin-bottom: 30px;
    }

    .section-heading h2 {
        font-size: 48px;
        font-weight: 900;
        color: #102b57;
        margin: 0;
        letter-spacing: -0.03em;
    }

    .doctor-filter-bar {
        margin-bottom: 30px;
        background: white;
        padding: 16px 20px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        border: 1.5px solid #edf0f5;
    }

    .doc-search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }

    .doc-search-input-wrap,
    .doc-filter-select-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1.5px solid #edf0f5;
        border-radius: 14px;
        padding: 10px 14px;
        flex: 1;
        min-width: 200px;
    }

    .doc-search-input-wrap i,
    .doc-filter-select-wrap i {
        color: #94a3b8;
        font-size: 15px;
    }

    .doc-search-input-wrap input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        font-size: 14px;
        color: #102b57;
        font-weight: 600;
    }

    .doc-search-input-wrap input::placeholder {
        color: #94a3b8;
    }

    .doc-filter-select-wrap select {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        font-size: 14px;
        color: #102b57;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-reset {
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        color: #dc2626;
        padding: 10px 18px;
        border-radius: 14px;
        background: #fee2e2;
        transition: .2s ease;
    }

    .btn-reset:hover {
        background: #fecaca;
        transform: translateY(-1px);
    }

    .pagination-wrap {
        margin-top: 36px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrap svg {
        width: 18px;
        height: 18px;
    }

    .doctor-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 28px;
    }

    .doctor-card {
        background: white;
        border-radius: 28px;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(180px, 220px) 1fr;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        transition: .3s ease;
        border-left: 5px solid #facc15;
    }

    .doctor-card:hover {
        transform: translateY(-4px);
    }

    .doctor-image {
        width: 100%;
        height: 100%;
    }

    .doctor-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doctor-avatar-large {
        width: 100%;
        height: 100%;
        min-height: 320px;
        background: #102b57;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 64px;
        font-weight: 800;
        letter-spacing: 2px;
    }

    .doctor-content {
        padding: 26px 24px;
        display: flex;
        flex-direction: column;
    }

    .doctor-badge {
        width: fit-content;
        background: #102b57;
        color: #facc15;
        font-size: 11px;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 999px;
        margin-bottom: 16px;
        letter-spacing: .08em;
    }

    .doctor-content h3 {
        margin: 0 0 10px;
        font-size: 22px;
        font-weight: 800;
        color: #102b57;
    }

    .doctor-specialist {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
        margin-bottom: 24px;
        font-size: 15px;
    }

    .doctor-specialist i {
        color: #102b57;
    }

    .doctor-schedule-list {
        display: grid;
        gap: 14px;
        margin-bottom: 24px;
    }

    .doctor-schedule {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .schedule-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #eef4ff;
        color: #1d4ed8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .doctor-schedule small {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .schedule-day {
        display: block;
        color: #102b57;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .schedule-time {
        display: block;
        color: #475569;
        font-size: 15px;
        font-weight: 600;
    }

    .empty-schedule {
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px;
        color: #64748b;
        font-size: 14px;
    }

    .doctor-description {
        color: #64748b;
        line-height: 1.8;
        margin-bottom: 28px;
    }

    .btn-book {
        margin-top: auto;
        background: #facc15;
        color: #102b57;
        text-decoration: none;
        padding: 16px 22px;
        border-radius: 16px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: .3s ease;
    }

    .btn-book:hover {
        background: #eab308;
    }

    .empty-doctor {
        grid-column: 1 / -1;
        background: white;
        border-radius: 28px;
        padding: 70px 30px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
    }

    .empty-icon {
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

    .empty-doctor h3 {
        margin: 0 0 12px;
        font-size: 28px;
        font-weight: 800;
        color: #102b57;
    }

    .empty-doctor p {
        margin: 0;
        color: #64748b;
        line-height: 1.8;
        font-size: 15px;
    }

    @media (max-width: 1200px) {

        .doctor-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 768px) {

        .doctor-page {
            padding: 24px 14px 60px;
        }

        .doctor-container {
            padding: 0;
        }

        .section-heading h2 {
            font-size: 32px;
        }

        .doctor-card {
            grid-template-columns: 1fr;
        }

        .doctor-image {
            height: 280px;
        }

        .doctor-content {
            padding: 22px;
        }

        .doctor-avatar-large {
            min-height: 280px;
            font-size: 52px;
        }

    }

</style>
@endsection