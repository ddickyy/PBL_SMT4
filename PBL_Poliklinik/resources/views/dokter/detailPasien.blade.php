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
        'bg'         => asset('images/poliklinik.jpg'),
    ])

@section('content')

    @php

        $statusConfig = [
            'finished' => ['bg' => '#dcfce7', 'color' => '#15803d'],
            'processing' => ['bg' => '#fef3c7', 'color' => '#b45309'],
            'waiting' => ['bg' => '#e2e8f0', 'color' => '#64748b'],
            'batal' => ['bg' => '#fee2e2', 'color' => '#dc2626'],
        ];

        $sc = $statusConfig[$pasien['status']] ?? $statusConfig['waiting'];

        $fotoUrl = $pasien['foto']
            ? asset('storage/' . $pasien['foto'])
            : 'https://ui-avatars.com/api/?name=' . urlencode($pasien['nama']) . '&background=102b57&color=fff&size=120';

    @endphp

    <section class="det-section">

        <div class="det-container">

            {{-- TOPBAR --}}
            <div class="det-topbar">

                <a href="{{ route('dokter.pasien') }}" class="det-btn det-btn-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

                <button class="det-btn det-btn-status" onclick="toggleStatusModal()">
                    <i class="fa-solid fa-pen"></i>
                    Ubah Status
                </button>

            </div>

            {{-- GRID --}}
            <div class="det-grid">

                {{-- LEFT --}}
                <div class="det-left">

                    {{-- PROFILE --}}
                    <div class="det-card">

                        <div class="det-profile">

                            <img src="{{ $fotoUrl }}" alt="{{ $pasien['nama'] }}">

                            <h2>{{ $pasien['nama'] }}</h2>

                            <p>{{ $pasien['nim'] }}</p>

                            <span class="det-kategori">
                                {{ $pasien['kategori'] }}
                            </span>

                            <span class="det-status" style="background:{{ $sc['bg'] }}; color:{{ $sc['color'] }}">
                                {{ $pasien['label_status'] }}
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
                                <strong>{{ $pasien['email'] }}</strong>
                            </div>

                            <div class="det-info-item">
                                <small>Telepon</small>
                                <strong>{{ $pasien['telepon'] }}</strong>
                            </div>

                            <div class="det-info-item">
                                <small>Alamat</small>
                                <strong>{{ $pasien['alamat'] }}</strong>
                            </div>

                            <div class="det-info-item">
                                <small>No Antrean</small>
                                <strong>#{{ $pasien['no_antrean'] }}</strong>
                            </div>

                            <div class="det-info-item">
                                <small>Jadwal Reservasi</small>
                                <strong>{{ $pasien['tanggal_reservasi'] }}</strong>
                            </div>

                            <div class="det-info-item">
                                <small>Jam Reservasi</small>
                                <strong>{{ $pasien['jam_reservasi'] }} WIB</strong>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="det-right">

                    {{-- KELUHAN --}}
                    <div class="det-card">

                        <h3 class="det-title">
                            Keluhan Pasien
                        </h3>

                        <div class="det-box">
                            {{ $pasien['keluhan'] }}
                        </div>

                    </div>

                   {{-- DIAGNOSA --}}
                    <div class="det-card">

                        <div class="det-card-head">

                            <h3 class="det-title">
                                Diagnosa
                            </h3>

                            <button class="det-edit-btn" onclick="toggleDiagnosaEdit()">
                                <i class="fa-solid fa-pen"></i>
                                Edit
                            </button>

                        </div>

                        {{-- VIEW MODE --}}
                        <div id="diagnosaView">

                            <div class="det-box">
                                {{ $pasien['diagnosa'] }}
                            </div>

                        </div>

                        {{-- EDIT MODE --}}
                        <div id="diagnosaEdit" style="display:none;">

                            <textarea class="det-textarea" id="diagnosaInput">{{ $pasien['diagnosa'] }}</textarea>

                            <div class="det-form-action">

                                <button class="det-save-btn" onclick="simpanDiagnosa()">
                                    Simpan Diagnosa
                                </button>

                            </div>

                        </div>

                    </div>

                    {{-- CATATAN --}}
                    <div class="det-card">

                        <div class="det-card-head">

                            <h3 class="det-title">
                                Catatan Dokter
                            </h3>

                            <button class="det-edit-btn" onclick="toggleCatatanEdit()">
                                <i class="fa-solid fa-pen"></i>
                                Edit
                            </button>

                        </div>

                        {{-- VIEW MODE --}}
                        <div id="catatanView">

                            <div class="det-box">
                                {{ $pasien['catatan_dokter'] }}
                            </div>

                        </div>

                        {{-- EDIT MODE --}}
                        <div id="catatanEdit" style="display:none;">

                            <textarea class="det-textarea" id="catatanInput">{{ $pasien['catatan_dokter'] }}</textarea>

                            <div class="det-form-action">

                                <button class="det-save-btn" onclick="simpanCatatan()">
                                    Simpan Catatan
                                </button>

                            </div>

                        </div>

                    </div>

                    {{-- PENILAIAN --}}
                    <div class="det-card">

                        <h3 class="det-title">
                            Penilaian Pasien
                        </h3>

                        <div class="det-rating">
                            ⭐ {{ $pasien['rating'] }}/5
                        </div>

                        <div class="det-box">
                            {{ $pasien['kritik_saran'] }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- MODAL STATUS --}}
    <div class="det-modal-overlay" id="statusModal">

        <div class="det-modal">

            <div class="det-modal-head">

                <h3>Ubah Status</h3>

                <button onclick="toggleStatusModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            <div class="det-modal-body">

                <button class="status-btn waiting">
                    Tunggu
                </button>

                <button class="status-btn processing">
                    Proses
                </button>

                <button class="status-btn finished">
                    Selesai
                </button>

                <button class="status-btn batal">
                    Batal
                </button>

            </div>

        </div>

    </div>

    <script>

    function toggleDiagnosaEdit() {

        const view = document.getElementById('diagnosaView');
        const edit = document.getElementById('diagnosaEdit');

        if(edit.style.display === 'none') {

            edit.style.display = 'block';
            view.style.display = 'none';

        } else {

            edit.style.display = 'none';
            view.style.display = 'block';
        }
    }

    function toggleCatatanEdit() {

        const view = document.getElementById('catatanView');
        const edit = document.getElementById('catatanEdit');

        if(edit.style.display === 'none') {

            edit.style.display = 'block';
            view.style.display = 'none';

        } else {

            edit.style.display = 'none';
            view.style.display = 'block';
        }
    }

    function simpanDiagnosa() {

        const isi = document.getElementById('diagnosaInput').value;

        document.querySelector('#diagnosaView .det-box').innerText = isi;

        toggleDiagnosaEdit();
    }

    function simpanCatatan() {

        const isi = document.getElementById('catatanInput').value;

        document.querySelector('#catatanView .det-box').innerText = isi;

        toggleCatatanEdit();
    }

    </script>

    <style>
        .det-section {
            padding: 20px 24px 60px;
            background: #f5f7fb;
        }

        .det-container {
            max-width: 1200px;
            margin: auto;
        }

        .det-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
        }

        .det-btn {
            border: none;
            border-radius: 12px;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;

            display: flex;
            align-items: center;
            gap: 8px;

            transition: .2s;
        }

        .det-btn-back {
            background: #fff;
            color: #102b57;
        }

        .det-btn-status {
            background: #102b57;
            color: #fff;
        }

        .det-btn:hover {
            transform: translateY(-1px);
        }

        .det-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 20px;
        }

        .det-left,
        .det-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .det-card {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            border: 1px solid #eef2f7;
        }

        .det-profile {
            text-align: center;
        }

        .det-profile img {
            width: 88px;
            height: 88px;
            border-radius: 20px;
            object-fit: cover;
            margin-bottom: 14px;
        }

        .det-profile h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #102b57;
        }

        .det-profile p {
            margin: 6px 0 14px;
            color: #94a3b8;
            font-size: 13px;
        }

        .det-kategori {
            display: inline-flex;
            padding: 6px 14px;
            border-radius: 999px;
            background: #eef4ff;
            color: #2d5bff;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .det-status {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 95px;
            min-width: 95px;

            margin: auto;

            padding: 7px 14px;

            border-radius: 999px;

            font-size: 11px;
            font-weight: 800;
        }

        .det-title {
            margin: 0 0 16px;
            font-size: 15px;
            font-weight: 800;
            color: #102b57;
        }

        .det-info-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .det-info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .det-info-item small {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 700;
            text-transform: uppercase;
        }

        .det-info-item strong {
            font-size: 14px;
            color: #1e293b;
        }

        .det-box {
            background: #f8fafc;
            border-radius: 14px;
            padding: 18px;
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
        }

        .det-rating {
            margin-bottom: 14px;
            font-size: 15px;
            font-weight: 800;
            color: #102b57;
        }

        .det-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .det-modal-overlay.show {
            display: flex;
        }

        .det-modal {
            width: 100%;
            max-width: 360px;
            background: #fff;
            border-radius: 22px;
            padding: 24px;
        }

        .det-modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .det-modal-head h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #102b57;
        }

        .det-modal-head button {
            border: none;
            background: #f1f5f9;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            cursor: pointer;
        }

        .det-modal-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .status-btn {
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .status-btn.waiting {
            background: #e2e8f0;
            color: #64748b;
        }

        .status-btn.processing {
            background: #fef3c7;
            color: #b45309;
        }

        .status-btn.finished {
            background: #dcfce7;
            color: #15803d;
        }

        .status-btn.batal {
            background: #fee2e2;
            color: #dc2626;
        }

        @media(max-width:900px) {

            .det-grid {
                grid-template-columns: 1fr;
            }

        }

        @media(max-width:600px) {

            .det-topbar {
                flex-direction: column;
                align-items: stretch;
            }

            .det-btn {
                justify-content: center;
            }

        }

        .det-card-head{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            margin-bottom:16px;
        }

        .det-edit-btn{
            border:none;
            background:#eef4ff;
            color:#2d5bff;
            border-radius:10px;
            padding:8px 14px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;

            display:flex;
            align-items:center;
            gap:6px;

            transition:.2s;
        }

        .det-edit-btn:hover{
            background:#dbeafe;
        }

        .det-textarea{
            width:100%;
            min-height:140px;

            border:1px solid #dbe3ee;
            border-radius:14px;

            padding:16px;

            resize:none;

            font-size:14px;
            line-height:1.7;

            outline:none;

            background:#fff;
            color:#334155;
        }

        .det-textarea:focus{
            border-color:#102b57;
        }

        .det-form-action{
            margin-top:14px;
            display:flex;
            justify-content:flex-end;
        }

        .det-save-btn{
            border:none;
            background:#102b57;
            color:#fff;

            padding:12px 18px;

            border-radius:12px;

            font-size:13px;
            font-weight:700;

            cursor:pointer;

            transition:.2s;
        }

        .det-save-btn:hover{
            transform:translateY(-1px);
        }
    </style>

@endsection