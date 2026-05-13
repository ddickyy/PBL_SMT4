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

        <div class="doctor-grid">
            @forelse($dokters as $item)
                @php
                    $spesialisasi = strtolower(
                        optional($item->spesialisasi)->nama_spesialisasi ?? ''
                    );

                    $foto = optional($item->user)->foto;
                @endphp

                <div class="doctor-card">
                    <div class="doctor-image">
                        @if($foto)

                            <img src="{{ asset('storage/' . $foto) }}"
                                 alt="Doctor">
                        @else
                            <img src="{{ asset('images/default-doctor.png') }}"
                                 alt="Doctor">
                        @endif
                    </div>

                    <div class="doctor-content">
                        <span class="doctor-badge">
                            {{ optional($item->spesialisasi)->nama_spesialisasi ?? 'POLI UMUM' }}
                        </span>
                        <h3>
                            {{ optional($item->user)->nama ?? 'Dokter' }}
                        </h3>
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

                        <div class="doctor-schedule-list">
                            @forelse($item->jadwalDokter as $jadwal)
                                <div class="doctor-schedule">
                                    <div class="schedule-icon">
                                        <i class="fa-regular fa-calendar"></i>
                                    </div>

                                    <div>
                                        <small>JADWAL PRAKTIK</small>
                                        <strong>
                                            {{ $jadwal->hari }}
                                        </strong>

                                        <span>
                                            {{ $jadwal->jam_mulai }}
                                            -
                                            {{ $jadwal->jam_selesai }}
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

                        <p class="doctor-description">
                            Dokter profesional dengan pengalaman di layanan kesehatan
                            untuk membantu menjaga kesehatan pasien secara menyeluruh.
                        </p>

                        <a href="{{ route('pasien.reservasi') }}"
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

    .doctor-schedule strong {
        display: block;
        color: #102b57;
        font-size: 16px;
        margin-bottom: 4px;
    }

    .doctor-schedule span {
        color: #64748b;
        font-size: 14px;
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

    }

</style>
@endsection