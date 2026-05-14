@extends('layout.app')

@php
    $dokterLayout = true;
@endphp

@section('title', 'Beranda Dokter')

@section('hero')
@include('partial.hero', [
    'badge'      => 'Layanan Kesehatan',
    'title'      => 'Selamat Datang,<br><span style="color:#f6c40b">dr. Satra Wiyanto</span>',
    'desc'       => 'Kelola jadwal praktik, pantau antrean pasien, dan berikan pelayanan kesehatan terbaik hari ini.',
    'buttonText' => null,
    'bg'         => asset('images/poliklinik.jpg'),
])
@endsection

@section('content')

@php
$statsData = [
    ['icon' => 'fa-calendar-check', 'color' => 'blue',   'label' => 'Reservasi Menunggu',       'value' => '02'],
    ['icon' => 'fa-users',          'color' => 'yellow', 'label' => 'Selesai Hari Ini',          'value' => '02'],
    ['icon' => 'fa-chart-line',     'color' => 'green',  'label' => 'Rata-rata Waktu Konsultasi','value' => '26', 'unit' => 'mnt'],
];

$antreanList = [
    ['no'=>'01','nama'=>'Daniel Caesar', 'id'=>'NIM 12310100','kategori'=>'Pasien Umum','waktu'=>'12:15','status'=>'selesai','label'=>'SELESAI'],
    ['no'=>'02','nama'=>'Bruno Mars', 'id'=>'NIM 12310101','kategori'=>'Pendaftaran','waktu'=>'13:00','status'=>'selesai','label'=>'SELESAI'],
    ['no'=>'03','nama'=>'Ariana Grande', 'id'=>'NIM 12310102','kategori'=>'Pasien Umum','waktu'=>'13:30','status'=>'proses','label'=>'PROSES'],
    ['no'=>'04','nama'=>'Taylor Swift', 'id'=>'NIM 12310103','kategori'=>'Mahasiswa','waktu'=>'14:00','status'=>'tunggu','label'=>'TUNGGU'],
    ['no'=>'05','nama'=>'Ed Sheeran', 'id'=>'NIM 12310104','kategori'=>'Dosen','waktu'=>'14:30','status'=>'tunggu','label'=>'TUNGGU'],
];

$jadwalList = [
    [
        'tanggal'=>'2 Mei 2026',
        'hari'=>'Jum',
        'jam'=>'12:15 - 14:00',
        'today'=>false,
        'upcoming'=>false
    ],

    [
        'tanggal'=>'9 Mei 2026',
        'hari'=>'Jum',
        'jam'=>'12:15 - 14:00',
        'today'=>false,
        'upcoming'=>false
    ],

    [
        'tanggal'=>'16 Mei 2026',
        'hari'=>'Jum',
        'jam'=>'12:15 - 14:00',
        'today'=>true,
        'upcoming'=>false
    ],

    [
        'tanggal'=>'23 Mei 2026',
        'hari'=>'Jum',
        'jam'=>'12:15 - 14:00',
        'today'=>false,
        'upcoming'=>false
    ],

    [
        'tanggal'=>'30 Mei 2026',
        'hari'=>'Jum',
        'jam'=>'12:15 - 14:00',
        'today'=>false,
        'upcoming'=>false
    ],
];
@endphp

<section class="bd-section">
<div class="bd-container">

    {{-- STATS ROW --}}
    <div class="bd-stats">
        @foreach($statsData as $s)
        <div class="bd-stat bd-stat--{{ $s['color'] }}">
            <div class="bd-stat__icon"><i class="fa-solid {{ $s['icon'] }}"></i></div>
            <div class="bd-stat__body">
                <span class="bd-stat__label">{{ $s['label'] }}</span>
                <strong class="bd-stat__val">
                    {{ $s['value'] }}
                    @isset($s['unit'])<small>{{ $s['unit'] }}</small>@endisset
                </strong>
            </div>
        </div>
        @endforeach
    </div>

    {{-- MAIN GRID --}}
    <div class="bd-main">

        {{-- LEFT: ANTREAN --}}
        <div class="bd-left">

            <div class="bd-subhead">
                <h2>Antrean Pasien Hari Ini</h2>
                <a href="{{ route('dokter.pasien') }}" class="bd-link">Lihat semua</a>
            </div>

            <div class="bd-antrean">
                @foreach($antreanList as $p)
                <div class="bd-row @if($p['status']==='proses') bd-row--active @endif">
                    <span class="bd-row__no">{{ $p['no'] }}</span>
                    <div class="bd-row__info">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p['nama']) }}&background=102b57&color=fff&size=44" alt="{{ $p['nama'] }}">
                        <div>
                            <h4>{{ $p['nama'] }}</h4>
                            <p>{{ $p['id'] }} • {{ $p['kategori'] }}</p>
                        </div>
                    </div>
                    <span class="bd-row__time">{{ $p['waktu'] }}</span>
                    <span class="bd-badge bd-badge--{{ $p['status'] }}">{{ $p['label'] }}</span>
                    <a href="{{ route('dokter.pasien.detail', $p['no']) }}" class="bd-row__btn"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
                @endforeach
            </div>

        </div>

        {{-- RIGHT: PROFIL + STATUS + JADWAL + KONTAK --}}
        <div class="bd-right">

            {{-- PROFIL SINGKAT --}}
            <div class="bd-card bd-profil">
                <img class="bd-profil__img" src="https://ui-avatars.com/api/?name=Satra+Wiyanto&background=102b57&color=fff&size=80" alt="Profil">
                <div class="bd-profil__detail">
                    <h3>dr. Satra Wiyanto, MARS</h3>
                    <p>Spesialis Kedokteran Umum</p>
                    <div class="bd-profil__meta">
                        <span><i class="fa-solid fa-id-card"></i> 052057527572</span>
                        <span><i class="fa-solid fa-star"></i> 4.9 Rating</span>
                    </div>
                </div>
                <a href="{{ route('dokter.profil.edit') }}" class="bd-btn-edit">
                    <i class="fa-solid fa-pen"></i> Edit Profil
                </a>
            </div>

            {{-- STATUS PRAKTIK --}}
            <div class="bd-card bd-status">
                <div class="bd-status__head">
                    <span class="bd-status__title">STATUS KEGIATAN</span>
                    <span class="bd-status__pill">● Sedang Praktik</span>
                </div>
                <p class="bd-status__place">Gedung Teknik, Politeknik Negeri Malang</p>
                <hr class="bd-status__divider">
                <div class="bd-status__row">
                    <div><small>Hari</small><strong>Jumat</strong></div>
                    <div><small>Jam</small><strong>12:15 - 14:00</strong></div>
                    <div class="bd-status__pasien">
                        <small>Pasien Hari Ini</small>
                        <strong class="bd-big">05</strong>
                    </div>
                </div>
            </div>

            {{-- JADWAL MINGGUAN --}}
            <div class="bd-card bd-jadwal">
                <div class="bd-jadwal__head">
                    <h3>Jadwal Praktik Mingguan</h3>
                    <span class="bd-jadwal__zone">Zona Waktu: WIB (UTC+7)</span>
                </div>
                <div class="bd-jadwal__days">
                    @foreach($jadwalList as $j)
                    <div class="bd-day
                        @if($j['today']) bd-day--today @endif
                        @if($j['upcoming']) bd-day--upcoming @endif">
                        <span class="bd-day__tgl">{{ $j['tanggal'] }}</span>
                        <span class="bd-day__hari">{{ $j['hari'] }}</span>
                        <span class="bd-day__jam">{{ $j['jam'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- KONTAK --}}
            <div class="bd-card bd-kontak">
                <div class="bd-kontak__item">
                    <i class="fa-regular fa-envelope"></i>
                    <div>
                        <small>Email Klinik</small>
                        <span>satra@gmail.com</span>
                    </div>
                </div>
                <div class="bd-kontak__divider"></div>
                <div class="bd-kontak__item">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <small>No. Kontak</small>
                        <span>+62 8xxxxx</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
</section>

<style>

/* ── LAYOUT ── */
.bd-section   { padding: 30px 24px 60px; background: #f5f7fb; }
.bd-container { max-width: 1280px; margin: 0 auto; padding: 0 16px; }

/* ── STATS ── */
.bd-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}
.bd-stat {
    background: #fff;
    border-radius: 22px;
    padding: 22px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 10px 30px rgba(16,43,87,.07);
    transition: transform .2s;
}
.bd-stat:hover { transform: translateY(-2px); }
.bd-stat__icon {
    width: 52px; height: 52px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.bd-stat--blue   .bd-stat__icon { background:#e7efff; color:#2d5bff; }
.bd-stat--yellow .bd-stat__icon { background:#fff9e0; color:#c8980a; }
.bd-stat--green  .bd-stat__icon { background:#dcfce7; color:#15803d; }
.bd-stat__label {
    display: block;
    font-size: 11px; font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: 4px;
}
.bd-stat__val { font-size: 32px; font-weight: 900; color: #102b57; }
.bd-stat__val small { font-size: 14px; font-weight: 600; color: #94a3b8; }

/* ── MAIN GRID ── */
.bd-main {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 24px;
    align-items: start;
}

/* ── SUBHEAD ── */
.bd-subhead { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.bd-subhead h2 { margin: 0; font-size: 22px; font-weight: 800; color: #102b57; }
.bd-link { color: #102b57; font-size: 13px; font-weight: 700; text-decoration: none; opacity: .7; }
.bd-link:hover { opacity: 1; }

/* ── ANTREAN ── */
.bd-antrean { display: flex; flex-direction: column; gap: 12px; }
.bd-row {
    display: grid;
    grid-template-columns: 36px 1fr auto auto auto;
    align-items: center;
    gap: 16px;
    background: #fff;
    border-radius: 18px;
    padding: 16px 18px;
    box-shadow: 0 4px 16px rgba(16,43,87,.05);
    transition: box-shadow .2s;
}
.bd-row:hover { box-shadow: 0 8px 28px rgba(16,43,87,.1); }
.bd-row--active {border-left: 4px solid #f6c40b; background: #ffffff;}
.bd-row__no { font-size: 15px; font-weight: 800; color: #cbd5e1; }
.bd-row__info { display: flex; align-items: center; gap: 12px; }
.bd-row__info img { width: 44px; height: 44px; border-radius: 12px; object-fit: cover; }
.bd-row__info h4 { margin: 0 0 3px; font-size: 15px; font-weight: 700; color: #102b57; }
.bd-row__info p  { margin: 0; font-size: 12px; color: #94a3b8; }
.bd-row__time { font-size: 13px; font-weight: 700; color: #475569; white-space: nowrap; }
.bd-row__btn {
    width: 32px; height: 32px;
    border-radius: 10px;
    background: #f1f5f9; border: none;
    cursor: pointer; color: #64748b;
    font-size: 12px;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s; text-decoration: none;
}
.bd-row__btn:hover { background: #102b57; color: #fff; }

/* BADGE */
.bd-badge {
    min-width: 92px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .5px;
    white-space: nowrap;
}
.bd-badge--selesai {
    background: #dcfce7;
    color: #15803d;
}

.bd-badge--proses {
    background: #fef3c7;
    color: #d97706;
}

.bd-badge--tunggu {
    background: #f1f5f9;
    color: #64748b;
}

/* ── RIGHT COL ── */
.bd-right { display: flex; flex-direction: column; gap: 18px; }
.bd-card  { background: #fff; border-radius: 22px; padding: 22px; box-shadow: 0 10px 30px rgba(16,43,87,.07); }

/* PROFIL */
.bd-profil { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.bd-profil__img { width: 60px; height: 60px; border-radius: 16px; border: 3px solid #f6c40b; object-fit: cover; flex-shrink: 0; }
.bd-profil__detail { flex: 1; }
.bd-profil__detail h3 { margin: 0 0 4px; font-size: 16px; font-weight: 800; color: #102b57; }
.bd-profil__detail p  { margin: 0 0 8px; font-size: 13px; color: #64748b; }
.bd-profil__meta { display: flex; gap: 14px; flex-wrap: wrap; }
.bd-profil__meta span { font-size: 12px; font-weight: 600; color: #94a3b8; display: flex; align-items: center; gap: 5px; }
.bd-profil__meta i { color: #f6c40b; }
.bd-btn-edit {
    background: #f6c40b; color: #102b57;
    border-radius: 12px; padding: 10px 16px;
    font-size: 13px; font-weight: 700;
    text-decoration: none;
    display: flex; align-items: center; gap: 6px;
    white-space: nowrap;
    transition: transform .2s, box-shadow .2s;
}
.bd-btn-edit:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(246,196,11,.3); }

/* STATUS */
.bd-status { background: #102b57 !important; color: #fff; }
.bd-status__head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.bd-status__title { font-size: 11px; font-weight: 800; letter-spacing: 1px; color: rgba(255,255,255,.5); }
.bd-status__pill { font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 999px; background: rgba(34,197,94,.15); color: #86efac; }
.bd-status__place { margin: 0 0 16px; font-size: 13px; color: rgba(255,255,255,.65); }
.bd-status__divider { border: none; border-top: 1px solid rgba(255,255,255,.1); margin-bottom: 16px; }
.bd-status__row { display: flex; justify-content: space-between; align-items: flex-end; }
.bd-status__row > div { display: flex; flex-direction: column; gap: 4px; }
.bd-status__row small  { font-size: 11px; color: rgba(255,255,255,.5); font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
.bd-status__row strong { font-size: 15px; font-weight: 700; color: #fff; }
.bd-status__pasien { text-align: right; }
.bd-big { font-size: 40px !important; font-weight: 900 !important; color: #f6c40b !important; line-height: 1; }

/* JADWAL */
.bd-jadwal__head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.bd-jadwal__head h3 { margin: 0; font-size: 16px; font-weight: 800; color: #102b57; }
.bd-jadwal__zone { font-size: 11px; color: #94a3b8; font-weight: 600; }
.bd-jadwal__days { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px; scrollbar-width: none; }
.bd-jadwal__days::-webkit-scrollbar { display: none; }
.bd-day {
    flex-shrink: 0;
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    background: #f8fafc; border-radius: 14px;
    padding: 12px 10px; min-width: 72px; text-align: center;
}
.bd-day__tgl  { font-size: 10px; color: #94a3b8; font-weight: 600; white-space: nowrap; }
.bd-day__hari { font-size: 14px; font-weight: 800; color: #102b57; }
.bd-day__jam  { font-size: 10px; font-weight: 700; color: #64748b; white-space: nowrap; }
.bd-day--today .bd-day__tgl,
.bd-day--today .bd-day__hari,
.bd-day--today .bd-day__jam { color: #102b57; }
.bd-day--today { background: #f6c40b; }
.bd-day--upcoming { opacity: .55; }

/* KONTAK */
.bd-kontak { display: flex; align-items: center; }
.bd-kontak__item { flex: 1; display: flex; align-items: center; gap: 12px; }
.bd-kontak__item i { width: 40px; height: 40px; background: #eef4ff; color: #2d5bff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
.bd-kontak__item small { display: block; font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.bd-kontak__item span { font-size: 13px; font-weight: 700; color: #102b57; }
.bd-kontak__divider { width: 1px; height: 40px; background: #e2e8f0; margin: 0 18px; flex-shrink: 0; }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
    .bd-main { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .bd-stats { grid-template-columns: 1fr; }
    .bd-row   { grid-template-columns: 28px 1fr auto; }
    .bd-row__time { display: none; }
}
@media (max-width: 480px) {
    .bd-profil  { flex-direction: column; text-align: center; }
    .bd-profil__meta { justify-content: center; }
    .bd-kontak  { flex-direction: column; gap: 14px; }
    .bd-kontak__divider { width: 100%; height: 1px; margin: 0; }
}

</style>

@endsection