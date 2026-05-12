@extends('layout.app')

@section('title', 'Reservasi Layanan')

@section('hero')
@include('partial.hero', [
    'badge' => 'Layanan Kesehatan',
    'title' => "Atur Waktu\nPemeriksaan Anda",
    'desc' => "Pilih layanan spesialis yang Anda butuhkan.\nKami memastikan setiap kunjungan terasa personal, tenang, dan profesional.",
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])
@endsection

@section('content')

@php use Carbon\Carbon; @endphp

<div class="reservasi-wrap">

    <div class="section-header">
        <h2 class="section-title">Reservasi Layanan</h2>
        <p class="section-sub">Pilih dokter, jadwal, dan tanggal kunjungan Anda.</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pasien.reservasi.store') }}" method="POST" id="reservasiForm">
        @csrf
        <input type="hidden" name="id_jadwal" id="id_jadwal">
        <input type="hidden" name="tanggal_reservasi" id="tanggal_reservasi">

        <div class="step-block">

            <div class="step-label">
                <span class="step-num">1</span>
                <span class="step-text">Pilih Dokter & Jadwal</span>
            </div>

            @if($dokterGroups->isEmpty())

                <div class="empty-box">
                    <i class="fa-solid fa-user-doctor"></i>
                    <h3>Belum Ada Jadwal Aktif</h3>
                    <p>Saat ini belum ada jadwal dokter yang tersedia.</p>
                </div>

            @else

                <div class="dokter-grid">
                    @foreach($dokterGroups as $idDokter => $group)
                        @php
                            $dokter = $group->first()->dokter;
                            $foto = optional($dokter->user)->foto;
                        @endphp
                        <div class="dokter-card">
                            <div class="dokter-top">
                                <div class="dokter-profile">
                                    <div class="dokter-avatar">
                                        @if($foto)
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto Dokter">
                                        @else
                                            {{ strtoupper(substr(optional($dokter->user)->nama ?? 'D', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="dokter-nama">{{ optional($dokter->user)->nama ?? 'Dokter' }}</h3>
                                        <p class="dokter-desc">{{ optional($dokter->spesialisasi)->nama_spesialisasi ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="jadwal-list">

                                @foreach($group as $jadwal)

                                    @php
                                        $kuotas = $jadwal->kuotaHarian;
                                    @endphp

                                    <div class="jadwal-item">
                                        <div class="jadwal-head">
                                            <strong>{{ $jadwal->hari }}</strong>
                                            <span>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>
                                        </div>

                                        @if($kuotas->isEmpty())
                                            <div class="empty-inline">
                                                Kuota harian belum tersedia.
                                            </div>
                                        @else

                                            <div class="tanggal-grid">
                                                @foreach($kuotas as $kuota)

                                                    @php
                                                        $isFull = $kuota->kuota_terisi >= $kuota->kuota_maksimal;
                                                    @endphp

                                                    <button type="button"
                                                        class="tanggal-chip {{ $isFull ? 'disabled-chip' : '' }}"
                                                        {{ $isFull ? 'disabled' : '' }}
                                                        data-id-jadwal="{{ $jadwal->id_jadwal }}"
                                                        data-tanggal="{{ $kuota->tanggal }}"
                                                        data-dokter="{{ optional($dokter->user)->nama }}"
                                                        data-spesialisasi="{{ optional($dokter->spesialisasi)->nama_spesialisasi }}"
                                                        data-jam="{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}"
                                                        onclick="pilihKuota(this)">

                                                        <span class="tgl-hari">{{ Carbon::parse($kuota->tanggal)->translatedFormat('D') }}</span>
                                                        <span class="tgl-num">{{ Carbon::parse($kuota->tanggal)->translatedFormat('d') }}</span>
                                                        <small>{{ Carbon::parse($kuota->tanggal)->translatedFormat('d M') }}</small>
                                                        <b>{{ $kuota->kuota_terisi }}/{{ $kuota->kuota_maksimal }}</b>

                                                        @if($isFull)
                                                            <span class="full-text">Penuh</span>
                                                        @endif
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="step-block">
            <div class="step-label">
                <span class="step-num">2</span>
                <span class="step-text">Konfirmasi Reservasi</span>
            </div>

            <div class="confirm-box">

                <div id="summaryText">
                    Belum ada jadwal yang dipilih.
                </div>

                <button type="submit" class="btn-confirm" id="btnConfirm" disabled>
                    Konfirmasi Reservasi ▶
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function pilihKuota(el)
    {
        document.querySelectorAll('.tanggal-chip')
            .forEach(c => c.classList.remove('selected'));

        el.classList.add('selected');

        document.getElementById('id_jadwal').value = el.dataset.idJadwal;
        document.getElementById('tanggal_reservasi').value = el.dataset.tanggal;

        document.getElementById('summaryText').innerHTML = `
            <strong>${el.dataset.dokter}</strong><br>
            ${el.dataset.spesialisasi}<br>
            ${el.dataset.jam}<br>
            Tanggal: <strong>${el.dataset.tanggal}</strong>
        `;

        document.getElementById('btnConfirm').disabled = false;
    }
</script>

<style>

    main {
        background: #f7f7f8;
        padding: 40px 0 80px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .reservasi-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .section-header {
        margin-bottom: 28px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #102b57;
        margin: 0 0 6px;
    }

    .section-sub {
        color: #6f7380;
        margin: 0;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 600;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px 18px;
        border-radius: 14px;
        margin-bottom: 18px;
        font-size: 14px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 18px;
    }

    .step-block {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 20px;
        box-shadow: 0 8px 32px rgba(16,43,87,.06);
    }

    .step-label {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .step-num {
        width: 32px;
        height: 32px;
        background: #102b57;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
    }

    .step-text {
        font-size: 1.1rem;
        font-weight: 700;
        color: #102b57;
    }

    .dokter-grid {
        display: grid;
        gap: 18px;
    }

    .dokter-card {
        border: 2px solid #e8eaef;
        border-radius: 18px;
        padding: 22px;
        background: #fafafa;
    }

    .dokter-top {
        margin-bottom: 18px;
    }

    .dokter-profile {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .dokter-avatar {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: #102b57;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        overflow: hidden;
        flex-shrink: 0;
    }

    .dokter-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .dokter-nama {
        margin: 0 0 4px;
        color: #102b57;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .dokter-desc {
        margin: 0;
        color: #64748b;
        font-size: .92rem;
    }

    .jadwal-list {
        display: grid;
        gap: 16px;
    }

    .jadwal-item {
        background: white;
        border-radius: 16px;
        border: 1px solid #e8eaef;
        padding: 18px;
    }

    .jadwal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        gap: 12px;
    }

    .jadwal-head strong {
        color: #102b57;
    }

    .jadwal-head span {
        color: #64748b;
        font-size: 14px;
    }

    .tanggal-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .tanggal-chip {
        border: 2px solid #e8eaef;
        background: #fafafa;
        border-radius: 14px;
        padding: 12px;
        cursor: pointer;
        min-width: 100px;
        text-align: center;
        transition: .2s ease;
    }

    .tanggal-chip:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    .tanggal-chip.selected {
        border-color: #f6c40b;
        background: #fffef5;
        box-shadow: 0 8px 28px rgba(246,196,11,.18);
    }

    .disabled-chip {
        opacity: .55;
        cursor: not-allowed;
    }

    .tgl-hari {
        display: block;
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
    }

    .tgl-num {
        display: block;
        font-size: 24px;
        font-weight: 900;
        color: #102b57;
    }

    .tanggal-chip small {
        display: block;
        margin-top: 4px;
        color: #64748b;
    }

    .tanggal-chip b {
        display: block;
        margin-top: 6px;
        color: #102b57;
        font-size: 12px;
    }

    .full-text {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
    }

    .empty-inline,
    .empty-box {
        background: #f8fafc;
        border: 1px dashed #dbe2ea;
        border-radius: 16px;
        padding: 18px;
        text-align: center;
        color: #64748b;
    }

    .empty-box {
        padding: 40px 20px;
    }

    .empty-box i {
        display: block;
        font-size: 34px;
        color: #102b57;
        margin-bottom: 10px;
    }

    .confirm-box {
        display: grid;
        gap: 16px;
    }

    #summaryText {
        background: #f8fafc;
        border: 1px solid #e8eaef;
        border-radius: 16px;
        padding: 16px;
        color: #102b57;
        line-height: 1.7;
    }

    .btn-confirm {
        width: 100%;
        padding: 18px;
        background: #102b57;
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 1rem;
        font-weight: 800;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-confirm:hover:not(:disabled) {
        background: #0d2247;
        transform: translateY(-2px);
    }

    .btn-confirm:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .reservasi-wrap {
            padding: 0 16px;
        }

        .step-block {
            padding: 22px 18px;
        }

        .jadwal-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .tanggal-grid {
            width: 100%;
        }

        .tanggal-chip {
            flex: 1;
            min-width: 90px;
        }
    }

</style>

@endsection