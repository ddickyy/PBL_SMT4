@extends('layout.app')

@php
    $dokterLayout = true;
@endphp

@section('title', 'Daftar Pasien')

@section('hero')
@include('partial.hero', [
    'badge'      => 'Layanan Kesehatan',
    'title'      => 'Daftar<br><span style="color:#f6c40b">Antrean Pasien</span>',
    'desc'       => 'Kelola daftar antrean pasien hari ini dan pantau status konsultasi secara real-time.',
    'buttonText' => null,
    'bg'         => asset('images/poliklinik.jpg'),
])
@endsection

@section('content')

<section class="dp-section">
<div class="dp-container">

    {{-- FILTER BAR --}}
    <div class="dp-filterbar">
        <div class="dp-filter__title">
            <h2>Daftar Tunggu Umum</h2>
        </div>
        <div class="dp-filter__right">
            <div class="dp-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari nama pasien..." id="dpSearch" oninput="filterPasien()">
            </div>
            <div class="dp-tabs">
                <button class="dp-tab active" onclick="filterTab(this,'semua')">Terbaru</button>
                <button class="dp-tab" onclick="filterTab(this,'semua')">Semua Pasien</button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="dp-table-wrap">
        <table class="dp-table">
            <thead>
                <tr>
                    <th>INFORMASI PASIEN</th>
                    <th>KELUHAN</th>
                    <th>WAKTU</th>
                    <th>STATUS</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="dpTableBody">
                @foreach($pasienList as $p)

<tr class="dp-tr" data-nama="{{ strtolower($p->user->nama) }}">

    <td>
        <div class="dp-pasien">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($p->user->nama) }}&background=102b57&color=fff&size=44"
            >

            <div>
                <h4>{{ $p->user->nama }}</h4>

                <p>
                    {{ $p->user->email }}
                </p>
            </div>

        </div>
    </td>

    <td class="dp-keluhan">
        {{ $p->keluhan ?? '-' }}
    </td>

    <td class="dp-waktu">
        {{ \Carbon\Carbon::parse($p->tanggal_reservasi)->format('d M Y') }}
    </td>

    <td>

        <span class="dp-badge dp-badge--{{ $p->status }}">

            {{ strtoupper($p->status) }}

        </span>

    </td>

    <td>

        <a
            href="{{ route('dokter.pasien.detail', $p->id_reservasi) }}"
            class="dp-action"
        >
            <i class="fa-solid fa-chevron-right"></i>
        </a>

    </td>

</tr>

@endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION DUMMY --}}
    <div class="dp-pagination">
        <p>Menampilkan 8 dari 16 pasien</p>
        <div class="dp-pages">
            <button class="dp-page dp-page--prev" disabled><i class="fa-solid fa-chevron-left"></i></button>
            <button class="dp-page dp-page--active">1</button>
            <button class="dp-page">2</button>
            <button class="dp-page dp-page--next"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

</div>
</section>

<script>
function filterPasien() {
    const q = document.getElementById('dpSearch').value.toLowerCase();
    document.querySelectorAll('.dp-tr').forEach(function(tr) {
        tr.style.display = tr.dataset.nama.includes(q) ? '' : 'none';
    });
}
function filterTab(el, type) {
    document.querySelectorAll('.dp-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

document.querySelectorAll('.dp-dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();

        document.querySelectorAll('.dp-dropdown').forEach(drop => {
            if (drop !== this.parentElement) {
                drop.classList.remove('active');
            }
        });

        this.parentElement.classList.toggle('active');
    });
});

document.addEventListener('click', function() {
    document.querySelectorAll('.dp-dropdown').forEach(drop => {
        drop.classList.remove('active');
    });
});

function ubahStatus(el, statusBaru) {

    const row = el.closest('.dp-tr');

    const badge = row.querySelector('.dp-badge');

    badge.className = 'dp-badge';

    badge.classList.add(`dp-badge--${statusBaru}`);

    badge.innerText = statusBaru.toUpperCase();

    row.querySelector('.dp-dropdown').classList.remove('active');
}
</script>

<style>

.dp-section   { padding: 30px 24px 60px; background: #f5f7fb; }
.dp-container { max-width: 1200px; margin: 0 auto; padding: 0 16px; }

/* FILTER BAR */
.dp-filterbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.dp-filter__title h2 { margin: 0; font-size: 22px; font-weight: 800; color: #102b57; }
.dp-filter__right { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

.dp-search {
    display: flex; align-items: center; gap: 10px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 16px;
    min-width: 240px;
}
.dp-search i { color: #94a3b8; font-size: 14px; }
.dp-search input { border: none; outline: none; font-size: 14px; color: #1e293b; background: transparent; width: 100%; }

.dp-tabs { display: flex; gap: 6px; }
.dp-tab {
    padding: 10px 16px; border-radius: 10px;
    border: none; cursor: pointer;
    font-size: 13px; font-weight: 600;
    background: #f1f5f9; color: #64748b;
    transition: background .2s, color .2s;
}
.dp-tab.active { background: #102b57; color: #fff; }
.dp-tab:hover:not(.active) { background: #e2e8f0; }

/* TABLE */
.dp-table-wrap {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 10px 30px rgba(16,43,87,.07);
    overflow: hidden;
    overflow-x: auto;
}
.dp-table {
    width: 100%;
    border-collapse: collapse;
}
.dp-table thead tr {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.dp-table th {
    padding: 14px 20px;
    font-size: 11px; font-weight: 800;
    color: #94a3b8;
    text-transform: uppercase; letter-spacing: .5px;
    text-align: left; white-space: nowrap;
}
.dp-tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
.dp-tr:hover { background: #f8fafc; }
.dp-tr:last-child { border-bottom: none; }
.dp-table td { padding: 16px 20px; vertical-align: middle; }

.dp-pasien { display: flex; align-items: center; gap: 12px; }
.dp-pasien img { width: 44px; height: 44px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
.dp-pasien h4 { margin: 0 0 3px; font-size: 15px; font-weight: 700; color: #102b57; }
.dp-pasien p  { margin: 0; font-size: 12px; color: #94a3b8; }

.dp-keluhan { font-size: 13px; color: #64748b; max-width: 280px; }
.dp-waktu { width:150px; min-width:150px; font-size:14px; font-weight:700; color:#102b57; white-space:nowrap; }

.dp-badge { width:95px; min-width:95px; display:inline-flex; align-items:center; justify-content:center; padding:6px 14px; border-radius:999px; font-size:11px; font-weight:800; letter-spacing:.4px; white-space:nowrap; }

.dp-badge--selesai { background:#dcfce7; color:#15803d; }
.dp-badge--proses { background:#fef3c7; color:#b45309; }
.dp-badge--menunggu { background:#e2e8f0; color:#64748b; }
.dp-badge--batal, .dp-badge--dibatalkan { background:#fee2e2; color:#dc2626; }

.dp-action {
    width: 34px; height: 34px;
    border-radius: 10px;
    border: none; background: #f1f5f9;
    cursor: pointer; color: #64748b;
    font-size: 14px;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s;
}
.dp-action:hover { background: #102b57; color: #fff; }

/* PAGINATION */
.dp-pagination {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px 4px 0;
    flex-wrap: wrap; gap: 12px;
}
.dp-pagination p { margin: 0; font-size: 13px; color: #94a3b8; font-weight: 500; }
.dp-pages { display: flex; gap: 6px; }
.dp-page {
    width: 36px; height: 36px;
    border-radius: 10px; border: none;
    background: #fff; color: #64748b;
    font-size: 13px; font-weight: 700;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(16,43,87,.07);
    transition: background .2s, color .2s;
    display: flex; align-items: center; justify-content: center;
}
.dp-page:hover:not(.dp-page--active):not(:disabled) { background: #f1f5f9; }
.dp-page--active { background: #102b57; color: #fff; }
.dp-page:disabled { opacity: .4; cursor: default; }

@media (max-width: 768px) {
    .dp-filterbar { flex-direction: column; align-items: flex-start; }
    .dp-filter__right { width: 100%; }
    .dp-search { min-width: unset; width: 100%; }
    .dp-table th:nth-child(3) { display: none; }
    .dp-table td:nth-child(3) { display: none; }
}

.dp-dropdown {
    position: relative;
}

.dp-dropdown-menu {
    position: absolute;
    top: 45px;
    right: 0;
    width: 190px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, .12);
    border: 1px solid #e2e8f0;
    padding: 8px;
    display: none;
    z-index: 100;
}

.dp-dropdown.active .dp-dropdown-menu {
    display: block;
}

.dp-dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 10px;
    text-decoration: none;
    color: #334155;
    font-size: 14px;
    font-weight: 600;
    transition: .2s;
}

.dp-dropdown-item:hover {
    background: #f8fafc;
    color: #102b57;
}

.dp-dropdown-item i {
    width: 16px;
}

/* SUBMENU */

.dp-submenu {
    position: relative;
}

.dp-submenu-btn {
    width: 100%;
    background: transparent;
    border: none;
    cursor: pointer;
    justify-content: space-between;
}

.dp-submenu-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.dp-submenu-arrow {
    font-size: 12px;
    color: #94a3b8;
}


.dp-submenu-menu {
    position: absolute;
    top: 0;
    right: calc(100% + 8px);

    width: 160px;

    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, .12);

    padding: 8px;

    opacity: 0;
    visibility: hidden;
    transform: translateX(10px);

    transition: .2s ease;

    z-index: 200;
}

.dp-submenu:hover .dp-submenu-menu,
.dp-submenu-menu:hover {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}

/* STATUS OPTION */

.dp-status-option {
    width: 100%;

    border: none;

    background: transparent;

    padding: 11px 14px;

    border-radius: 10px;

    text-align: left;

    cursor: pointer;

    font-size: 14px;

    font-weight: 600;

    color: #334155;

    transition: .2s;
}

.dp-status-option:hover {
    background: #f8fafc;
}

/* BADGE */

.dp-badge--selesai {
    background: #dcfce7;
    color: #15803d;
}

.dp-badge--proses {
    background: #fef3c7;
    color: #b45309;
}

.dp-badge--menunggu {
    background: #e2e8f0;
    color: #64748b;
}

.dp-badge--batal, .dp-badge--dibatalkan {
    background: #fee2e2;
    color: #dc2626;
}

</style>

@endsection