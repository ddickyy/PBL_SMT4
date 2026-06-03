@extends('layout.app')

@section('title', 'Reservasi Layanan')

@section('hero')
@include('partial.hero', [
    'badge' => 'LAYANAN KESEHATAN',
    'title' => "Atur Waktu\n<span style='color:#facc15;'>Reservasi Anda</span>",
    'desc' => "Pilih dokter dan tentukan jadwal kunjungan Anda dengan mudah dan nyaman.",
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])
@endsection

@section('content')

@php

    use Carbon\Carbon;
    use Carbon\CarbonPeriod;

    $today =
        Carbon::today()->startOfDay();

    $rangeEnd =
        Carbon::today()->addDays(13)->endOfDay();

    $hariMap = [
        1 => 'senin',
        2 => 'selasa',
        3 => 'rabu',
        4 => 'kamis',
        5 => 'jumat',
        6 => 'sabtu',
        7 => 'minggu',
    ];

@endphp

<div class="reservasi-page">

    {{-- HEADER --}}
    <div class="reservasi-header">

        <h2>Reservasi Layanan</h2>

        <p>
            Pilih dokter dan jadwal pemeriksaan Anda.
        </p>

    </div>

    @if($errors->any())

    <div style="
        background:#fee2e2;
        color:#991b1b;
        padding:14px 18px;
        border-radius:12px;
        margin-bottom:20px;
        font-weight:600;
    ">

        <ul style="margin:0;padding-left:18px;">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif
    <form action="{{ route('pasien.reservasi.store') }}"
          method="POST"
          id="reservasiForm">

        @csrf

        <input type="hidden"
               name="id_jadwal"
               id="id_jadwal">

        <input type="hidden"
               name="tanggal_reservasi"
               id="tanggal_reservasi">

        {{-- STEP 1 --}}
        <div class="step-title">

            <span>1</span>

            Pilih Dokter

        </div>

        <div class="dokter-layout">

            @forelse($dokterGroups as $idDokter => $group)

                @php

                    $dokter =
                        $group->first()->dokter;

                    $namaDokter =
                        optional($dokter->user)->nama
                        ?? 'Dokter';

                    $spesialisasi =
                        optional($dokter->spesialisasi)
                            ->nama_spesialisasi
                        ?? '-';

                    $deskripsi =
                        optional($dokter->spesialisasi)
                            ->deskripsi
                        ?? '-';

                    $foto =
                        optional($dokter->user)->foto;

                    $inisial =
                        collect(explode(' ', $namaDokter))
                            ->filter()
                            ->map(fn ($kata) =>
                                strtoupper(substr($kata, 0, 1))
                            )
                            ->take(2)
                            ->implode('');

                    $availability = collect();

                    foreach ($group as $jadwal)
                    {
                        $jadwalHari =
                            strtolower(trim($jadwal->hari));

                        $jamMulai =
                            Carbon::parse(
                                $jadwal->jam_mulai
                            )->format('H:i');

                        $jamSelesai =
                            Carbon::parse(
                                $jadwal->jam_selesai
                            )->format('H:i');

                        foreach (
                            CarbonPeriod::create(
                                $today,
                                '1 day',
                                $rangeEnd
                            ) as $tanggal
                        )
                        {
                            $hariTanggal =
                                $hariMap[
                                    $tanggal->dayOfWeekIso
                                ] ?? '';

                            if (
                                $hariTanggal !==
                                $jadwalHari
                            )
                            {
                                continue;
                            }

                            $kuota =
                                $jadwal->kuotaHarian
                                    ->first(function ($item)
                                        use ($tanggal)
                                    {
                                        return Carbon::parse(
                                            $item->tanggal
                                        )->toDateString()
                                        ===
                                        $tanggal->toDateString();
                                    });

                            $kuotaTerisi =
                                $kuota->kuota_terisi ?? 0;

                            $kuotaMaksimal =
                                $kuota->kuota_maksimal ??
                                floor(

                                    Carbon::parse(
                                        $jadwal->jam_mulai
                                    )->diffInMinutes(

                                        Carbon::parse(
                                            $jadwal->jam_selesai
                                        )

                                    )

                                    / $jadwal->durasi_menit
                                );

                            $availability->push([

                                'id_jadwal' =>
                                    $jadwal->id_jadwal,

                                'tanggal' =>
                                    $tanggal->toDateString(),

                                'hari_label' =>
                                    strtoupper(
                                        $tanggal
                                            ->locale('id')
                                            ->translatedFormat('D')
                                    ),

                                'tanggal_num' =>
                                    $tanggal->format('d'),

                                'bulan_label' =>
                                    strtoupper(
                                        $tanggal
                                            ->locale('id')
                                            ->translatedFormat('M')
                                    ),

                                'jam' =>
                                    $jamMulai .
                                    ' - ' .
                                    $jamSelesai .
                                    ' WIB',

                                'kuota_terisi' =>
                                    (int) $kuotaTerisi,

                                'kuota_maksimal' =>
                                    (int) $kuotaMaksimal,

                                'is_full' =>
                                    (int) $kuotaTerisi >=
                                    (int) $kuotaMaksimal,
                            ]);
                        }
                    }

                    $availability =
                        $availability
                            ->sortBy('tanggal')
                            ->values();

                    $firstAvailability =
                        $availability->first();

                @endphp

                <div class="doctor-card-modern"

                     onclick="pilihDokter(this)"

                     data-availability='@json($availability)'

                     data-kuota-awal="
                     {{ (optional($firstAvailability)['kuota_maksimal'] ?? 0)
                        - (optional($firstAvailability)['kuota_terisi'] ?? 0) }}
                     /
                     {{ optional($firstAvailability)['kuota_maksimal'] ?? 0 }}">

                    {{-- TOP --}}
                    <div class="doctor-top-modern">

                        <div class="doctor-icon">

                            @if($foto)

                                <img src="{{ asset('storage/' . $foto) }}"
                                     alt="Foto Dokter">

                            @elseif($inisial !== '')

                                <span>{{ $inisial }}</span>

                            @else

                                <i class="fa-solid fa-user-doctor"></i>

                            @endif

                        </div>

                        <div class="quota-side">

                            <small>KUOTA TERSEDIA</small>

                            <strong class="quota-display">
                                -
                            </strong>

                        </div>

                    </div>

                    {{-- CONTENT --}}
                    <div class="doctor-content-modern">

                        <h3>{{ $namaDokter }}</h3>

                        <div class="doctor-specialist">
                            {{ $spesialisasi }}
                        </div>

                        <p>
                            {{ $deskripsi }}
                        </p>

                        <div class="doctor-selected">
                            Pilih Dokter →
                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-doctor-card">

                    <i class="fa-solid fa-user-doctor"></i>

                    <h3>
                        Belum Ada Dokter Tersedia
                    </h3>

                    <p>
                        Saat ini belum ada dokter tersedia.
                    </p>

                </div>

            @endforelse

        </div>

        {{-- STEP 2 --}}
        <div class="step-title">

            <span>2</span>

            Pilih Tanggal

        </div>

        <div class="tanggal-wrapper">

            <div class="tanggal-grid-main"
                 id="tanggalGrid">

                <div class="empty-date">
                    Pilih dokter terlebih dahulu
                </div>

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="confirm-box">

            <button type="submit"
                    class="btn-confirm-modern"
                    id="btnConfirm"
                    disabled>

                Konfirmasi Reservasi

            </button>

        </div>

    </form>

</div>

<script>

    function pilihDokter(el)
    {
        document.querySelectorAll('.doctor-card-modern')
            .forEach(card =>
                card.classList.remove('selected-doctor')
            );

        el.classList.add('selected-doctor');

        const quotaDisplay =
            el.querySelector('.quota-display');

        quotaDisplay.innerHTML =
            el.dataset.kuotaAwal || '-';

        const availability =
            JSON.parse(el.dataset.availability || '[]');

        const tanggalContainer =
            document.getElementById('tanggalGrid');

        const availableSchedule =
            availability
                .filter(item => !item.is_full)
                .sort((a, b) =>
                    new Date(a.tanggal)
                    - new Date(b.tanggal)
                );

        document.getElementById('btnConfirm')
            .disabled = true;

        document.getElementById('id_jadwal')
            .value = '';

        document.getElementById('tanggal_reservasi')
            .value = '';

        if (!availableSchedule.length)
        {
            tanggalContainer.innerHTML = `
                <div class="empty-date">
                    Tidak ada jadwal tersedia
                    untuk 2 minggu ke depan.
                </div>
            `;

            return;
        }

        tanggalContainer.innerHTML =
            availableSchedule.map(item => `

                <button
                    type="button"
                    class="tanggal-item"

                    data-id-jadwal="${item.id_jadwal}"

                    data-tanggal="${item.tanggal}"

                    data-kuota="${
                        item.kuota_maksimal
                        - item.kuota_terisi
                    }/${item.kuota_maksimal}"

                    onclick="pilihTanggal(event, this)">

                    <span class="tgl-hari">
                        ${item.hari_label}
                    </span>

                    <span class="tgl-num">
                        ${item.tanggal_num}
                    </span>

                    <small>
                        ${item.bulan_label}
                    </small>

                </button>

            `).join('');
    }

    function pilihTanggal(event, el)
    {
        event.stopPropagation();

        document.querySelectorAll('.tanggal-item')
            .forEach(item =>
                item.classList.remove('selected')
            );

        el.classList.add('selected');

        document.getElementById('id_jadwal')
            .value = el.dataset.idJadwal;

        document.getElementById('tanggal_reservasi')
            .value = el.dataset.tanggal;

        const dokterCard =
            document.querySelector('.selected-doctor');

        if (dokterCard)
        {
            const quotaDisplay =
                dokterCard.querySelector('.quota-display');

            quotaDisplay.innerHTML =
                el.dataset.kuota;
        }

        document.getElementById('btnConfirm')
            .disabled = false;
    }

</script>

<style>

    .reservasi-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 90px;
    }

    .reservasi-header {
        margin-bottom: 34px;
    }

    .reservasi-header h2 {
        font-size: 42px;
        font-weight: 900;
        color: #102b57;
        margin-bottom: 10px;
        line-height: 1.1;
    }

    .reservasi-header p {
        font-size: 16px;
        color: #64748b;
    }

    .step-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 800;
        color: #102b57;
    }

    .step-title span {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #102b57;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .dokter-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px;
        margin-bottom: 34px;
    }

    .doctor-card-modern {
        position: relative;
        background: white;
        border-radius: 24px;
        padding: 26px;
        border: 2px solid #edf0f5;
        cursor: pointer;
        transition: all .25s ease;
        overflow: hidden;
    }

    .doctor-card-modern:hover {
        transform: translateY(-4px);
        border-color: #dbe4ff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, .08);
    }

    .selected-doctor {
        border-color: #facc15;
        background: linear-gradient(
            to bottom,
            #ffffff,
            #fffdf3
        );
        box-shadow: 0 14px 34px rgba(250, 204, 21, .18);
    }

    .doctor-top-modern {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
    }

    .doctor-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(
            135deg,
            #eef2ff,
            #dbeafe
        );
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        color: #102b57;
        font-weight: 900;
        font-size: 22px;
    }

    .doctor-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .quota-side {
        text-align: right;
    }

    .quota-side small {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        margin-bottom: 6px;
        letter-spacing: .4px;
    }

    .quota-display {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 74px;
        height: 42px;
        padding: 0 14px;
        border-radius: 14px;
        background: #102b57;
        color: white;
        font-size: 20px;
        font-weight: 900;
        box-shadow: 0 8px 18px rgba(16, 43, 87, .18);
    }

    .doctor-content-modern h3 {
        margin: 0 0 10px;
        font-size: 25px;
        font-weight: 900;
        color: #102b57;
        line-height: 1.2;
    }

    .doctor-specialist {
        display: inline-flex;
        align-items: center;
        padding: 7px 14px;
        border-radius: 999px;
        background: #eef2ff;
        color: #1e40af;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .doctor-content-modern p {
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .doctor-selected {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 800;
        color: #8b6a00;
    }

    .tanggal-wrapper {
        background: white;
        border-radius: 24px;
        padding: 26px;
        margin-bottom: 28px;
        border: 1px solid #edf0f5;
    }

    .tanggal-grid-main {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .tanggal-item {
        width: 92px;
        min-height: 122px;
        border-radius: 20px;
        border: 2px solid #edf0f5;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s ease;
        position: relative;
    }

    .tanggal-item:hover {
        transform: translateY(-3px);
        border-color: #c7d2fe;
        box-shadow: 0 10px 20px rgba(15, 23, 42, .06);
    }

    .tanggal-item.selected {
        background: linear-gradient(
            to bottom,
            #fffef2,
            #fff8db
        );

        border-color: #facc15;

        box-shadow: 0 10px 24px rgba(250, 204, 21, .22);
    }

    .tgl-hari {
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        margin-bottom: 6px;
        letter-spacing: .5px;
    }

    .tgl-num {
        font-size: 36px;
        font-weight: 900;
        color: #102b57;
        line-height: 1;
    }

    .tanggal-item small {
        margin-top: 7px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
    }

    .tanggal-item b {
        margin-top: 10px;
        font-size: 13px;
        font-weight: 800;
        color: #102b57;
        background: #f8fafc;
        padding: 4px 10px;
        border-radius: 999px;
    }

    .confirm-box {
        margin-top: 10px;
    }

    .btn-confirm-modern {
        width: 100%;
        height: 66px;
        border: none;
        border-radius: 20px;
        background: #102b57;
        color: white;
        font-size: 18px;
        font-weight: 800;
        cursor: pointer;
        transition: all .25s ease;
        box-shadow: 0 12px 28px rgba(16, 43, 87, .18);
    }

    .btn-confirm-modern:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 18px 34px rgba(16, 43, 87, .22);
    }

    .btn-confirm-modern:disabled {
        opacity: .5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .empty-date {
        width: 100%;
        padding: 24px;
        border-radius: 18px;
        background: #f8fafc;
        color: #64748b;
        text-align: center;
        font-weight: 600;
    }

    .empty-doctor-card {
        grid-column: 1 / -1;
        background: white;
        border-radius: 24px;
        padding: 46px 24px;
        text-align: center;
        border: 2px dashed #dbe4ee;
    }

    .empty-doctor-card i {
        font-size: 40px;
        color: #102b57;
        margin-bottom: 14px;
    }

    .empty-doctor-card h3 {
        font-size: 22px;
        color: #102b57;
        margin-bottom: 8px;
    }

    .empty-doctor-card p {
        color: #64748b;
    }

    @media (max-width: 768px)
    {
        .reservasi-page {
            padding: 28px 16px 80px;
        }

        .dokter-layout {
            grid-template-columns: 1fr;
        }

        .reservasi-header h2 {
            font-size: 34px;
        }

        .doctor-content-modern h3 {
            font-size: 22px;
        }

        .tanggal-grid-main {
            justify-content: center;
        }

        .tanggal-item {
            width: 82px;
            min-height: 108px;
        }

        .tgl-num {
            font-size: 30px;
        }

        .btn-confirm-modern {
            height: 60px;
            font-size: 16px;
        }
    }

</style>
@endsection