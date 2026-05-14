@extends('layout.app')

@php
    $dokterLayout = true;
@endphp

@section('content')

@php
$jadwalList = [
    ['tanggal'=>'2 Mei 2026',  'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>false, 'upcoming'=>false],
    ['tanggal'=>'9 Mei 2026',  'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>false, 'upcoming'=>false],
    ['tanggal'=>'16 Mei 2026', 'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>true,  'upcoming'=>false],
    ['tanggal'=>'23 Mei 2026', 'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>false, 'upcoming'=>false],
    ['tanggal'=>'30 Mei 2026', 'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>false, 'upcoming'=>false],
    ['tanggal'=>'6 Jun 2026',  'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>false, 'upcoming'=>true],
    ['tanggal'=>'13 Jun 2026', 'hari'=>'Jum', 'jam'=>'12:15 - 14:00', 'today'=>false, 'upcoming'=>true],
];
@endphp

<section class="pf-section">
<div class="pf-container">

    {{-- TOP PROFILE CARD --}}
    <div class="pf-hero-card">

        {{-- LEFT: FOTO --}}
        <div class="pf-hero-img">
            <img src="https://ui-avatars.com/api/?name=Satra+Wiyanto&background=102b57&color=fff&size=200" alt="dr. Satra Wiyanto">
            <span class="pf-online-badge">● DOKTER UMUM</span>
        </div>

        {{-- CENTER: INFO --}}
        <div class="pf-hero-info">
            <h1>dr. dr. Satra Wiyanto, MARS</h1>
            <p class="pf-spesialis">Spesialis Kedokteran Umum</p>

            <div class="pf-meta-grid">
                <div class="pf-meta-item">
                    <small>NOMOR INDUK PEGAWAI</small>
                    <strong>052057527572</strong>
                </div>
                <div class="pf-meta-item">
                    <small>Lama Praktik</small>
                    <strong>12 Tahun</strong>
                </div>
                <div class="pf-meta-item">
                    <small>Pasien Ditangani</small>
                    <strong>256</strong>
                </div>
            </div>

            <div class="pf-hero-actions">
                <a href="{{ route('dokter.profil.edit') }}" class="pf-btn pf-btn--yellow">
                    <i class="fa-solid fa-pen"></i> Edit Profil
                </a>
                <a href="{{ route('dokter.beranda') }}" class="pf-btn pf-btn--outline">
                    <i class="fa-solid fa-share-nodes"></i> Bagikan Jadwal
                </a>
            </div>
        </div>

        {{-- RIGHT: STATUS --}}
        <div class="pf-status-mini">
            <span class="pf-sm-label">STATUS KEGIATAN</span>
            <h3>Sedang Praktik</h3>
            <p>Gedung Teknik, Politeknik Negeri Malang</p>
            <div class="pf-sm-divider"></div>
            <small>Pasien Hari Ini</small>
            <span class="pf-sm-num">05</span>
            <span class="pf-sm-unit">Pasien</span>
        </div>

    </div>

    {{-- BODY GRID --}}
    <div class="pf-body">

        {{-- LEFT: BIOGRAFI + JADWAL + KONTAK --}}
        <div class="pf-body-left">

            {{-- BIOGRAFI --}}
            <div class="pf-card">
                <h3 class="pf-card__title">Biografi Profesional</h3>
                <blockquote class="pf-quote">
                    "Berkomitmen untuk memberikan layanan kesehatan primer yang holistik dan berkelanjutan bagi seluruh civitas akademika Polinema. Mengutamakan pencegahan diri dan edukasi pasien sebagai pilar utama kesehatan."
                </blockquote>

                <div class="pf-edu-grid">
                    <div class="pf-edu-item">
                        <small>PENDIDIKAN</small>
                        <strong>Universitas Brawijaya</strong>
                    </div>
                    <div class="pf-edu-item">
                        <small>SPESIALISASI</small>
                        <strong>Spesialis dokter umum</strong>
                    </div>
                </div>
            </div>

            {{-- JADWAL MINGGUAN --}}
            <div class="pf-card">
                <div class="pf-jadwal-head">
                    <h3 class="pf-card__title" style="margin:0">Jadwal Praktik Mingguan</h3>
                    <span class="pf-jadwal-zone">Zona Waktu: WIB (UTC+7)</span>
                </div>
                <div class="pf-jadwal-days">
                    @foreach($jadwalList as $j)
                    <div class="pf-day
                        @if($j['today']) pf-day--today @endif
                        @if($j['upcoming']) pf-day--upcoming @endif">
                        <span class="pf-day__tgl">{{ $j['tanggal'] }}</span>
                        <span class="pf-day__hari">{{ $j['hari'] }}</span>
                        <span class="pf-day__jam">{{ $j['jam'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- KONTAK --}}
            <div class="pf-card pf-kontak">
                <div class="pf-kontak-item">
                    <div class="pf-kontak-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <small>Alamat Email</small>
                        <span>satra.gmail.com</span>
                    </div>
                </div>
                <div class="pf-kontak-divider"></div>
                <div class="pf-kontak-item">
                    <div class="pf-kontak-icon"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <small>No. Kontak</small>
                        <span>+62 8xxxxx</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: STATS MINI --}}
        <div class="pf-body-right">

            <div class="pf-stats-card">
                <h3 class="pf-card__title">Statistik Singkat</h3>
                <div class="pf-stats-list">
                    <div class="pf-stat-row">
                        <div class="pf-stat-row__icon blue"><i class="fa-solid fa-users"></i></div>
                        <div class="pf-stat-row__body">
                            <span>Total Pasien</span>
                            <strong>256</strong>
                        </div>
                    </div>
                    <div class="pf-stat-row">
                        <div class="pf-stat-row__icon yellow"><i class="fa-solid fa-star"></i></div>
                        <div class="pf-stat-row__body">
                            <span>Rating</span>
                            <strong>4.9 / 5.0</strong>
                        </div>
                    </div>
                    <div class="pf-stat-row">
                        <div class="pf-stat-row__icon green"><i class="fa-solid fa-calendar-check"></i></div>
                        <div class="pf-stat-row__body">
                            <span>Jadwal Aktif</span>
                            <strong>1 / Minggu</strong>
                        </div>
                    </div>
                    <div class="pf-stat-row">
                        <div class="pf-stat-row__icon red"><i class="fa-solid fa-clock"></i></div>
                        <div class="pf-stat-row__body">
                            <span>Rata-rata Konsultasi</span>
                            <strong>26 Menit</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pf-quick-card">
                <h3 class="pf-card__title">Aksi Cepat</h3>
                <div class="pf-quick-list">
                    <a href="{{ route('dokter.pasien') }}" class="pf-quick-item">
                        <i class="fa-solid fa-users"></i>
                        <span>Daftar Pasien</span>
                        <i class="fa-solid fa-chevron-right pf-quick-arrow"></i>
                    </a>
                    <a href="{{ route('dokter.riwayat') }}" class="pf-quick-item">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Riwayat Reservasi</span>
                        <i class="fa-solid fa-chevron-right pf-quick-arrow"></i>
                    </a>
                    <a href="{{ route('dokter.profil.edit') }}" class="pf-quick-item">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Edit Profil</span>
                        <i class="fa-solid fa-chevron-right pf-quick-arrow"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
</section>

<style>

.pf-section   { padding: 110px 24px 60px; background: #f5f7fb; }
.pf-container { max-width: 1200px; margin: 0 auto; padding: 0 16px; }

/* HERO CARD */
.pf-hero-card {
    display: grid;
    grid-template-columns: 220px 1fr 260px;
    gap: 28px;
    align-items: start;
    background: #fff;
    border-radius: 28px;
    padding: 32px;
    box-shadow: 0 20px 50px rgba(16,43,87,.08);
    margin-bottom: 28px;
}

.pf-hero-img { position: relative; }
.pf-hero-img img {
    width: 100%; aspect-ratio: 1;
    border-radius: 22px; object-fit: cover;
    border: 4px solid #f6c40b;
}
.pf-online-badge {
    position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
    background: #102b57; color: #f6c40b;
    padding: 5px 12px; border-radius: 999px;
    font-size: 10px; font-weight: 800; white-space: nowrap;
}

.pf-hero-info h1 { margin: 0 0 6px; font-size: 26px; font-weight: 900; color: #102b57; line-height: 1.2; }
.pf-spesialis { margin: 0 0 20px; color: #64748b; font-size: 14px; }
.pf-meta-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 14px; margin-bottom: 22px;
}
.pf-meta-item { display: flex; flex-direction: column; gap: 4px; }
.pf-meta-item small { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; }
.pf-meta-item strong { font-size: 15px; font-weight: 800; color: #102b57; }

.pf-hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.pf-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 20px; border-radius: 12px;
    font-size: 13px; font-weight: 700;
    text-decoration: none; cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}
.pf-btn:hover { transform: translateY(-1px); }
.pf-btn--yellow { background: #f6c40b; color: #102b57; }
.pf-btn--yellow:hover { box-shadow: 0 6px 18px rgba(246,196,11,.35); }
.pf-btn--outline { background: #fff; color: #102b57; border: 1.5px solid #e2e8f0; }
.pf-btn--outline:hover { box-shadow: 0 6px 18px rgba(16,43,87,.1); }

/* STATUS MINI */
.pf-status-mini {
    background: #102b57;
    border-radius: 22px;
    padding: 24px;
    color: #fff;
    display: flex; flex-direction: column; gap: 4px;
}
.pf-sm-label { font-size: 10px; font-weight: 800; letter-spacing: 1px; color: rgba(255,255,255,.5); text-transform: uppercase; margin-bottom: 6px; }
.pf-status-mini h3 { margin: 0 0 4px; font-size: 18px; font-weight: 800; color: #fff; }
.pf-status-mini p  { margin: 0; font-size: 12px; color: rgba(255,255,255,.65); }
.pf-sm-divider { border: none; border-top: 1px solid rgba(255,255,255,.1); margin: 16px 0 10px; }
.pf-status-mini small { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .4px; }
.pf-sm-num { font-size: 52px; font-weight: 900; color: #f6c40b; line-height: 1; margin-top: 4px; }
.pf-sm-unit { font-size: 12px; color: rgba(255,255,255,.7); font-weight: 600; }

/* BODY */
.pf-body { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: start; }
.pf-body-left  { display: flex; flex-direction: column; gap: 20px; }
.pf-body-right { display: flex; flex-direction: column; gap: 20px; }

.pf-card {
    background: #fff; border-radius: 22px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(16,43,87,.07);
}
.pf-card__title { margin: 0 0 18px; font-size: 17px; font-weight: 800; color: #102b57; }

.pf-quote {
    margin: 0 0 20px;
    padding: 16px 20px;
    background: #f8fafc;
    border-left: 4px solid #f6c40b;
    border-radius: 0 12px 12px 0;
    font-size: 14px; color: #475569; line-height: 1.7;
    font-style: italic;
}
.pf-edu-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
.pf-edu-item {
    display: flex; flex-direction: column; gap: 4px;
    background: #f8fafc; border-radius: 14px; padding: 14px 16px;
}
.pf-edu-item small { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; }
.pf-edu-item strong { font-size: 14px; font-weight: 700; color: #102b57; }

/* JADWAL */
.pf-jadwal-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.pf-jadwal-zone { font-size: 11px; color: #94a3b8; font-weight: 600; }
.pf-jadwal-days { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px; scrollbar-width: none; }
.pf-jadwal-days::-webkit-scrollbar { display: none; }
.pf-day {
    flex-shrink: 0;
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    background: #f8fafc; border-radius: 14px;
    padding: 12px 10px; min-width: 72px; text-align: center;
}
.pf-day__tgl  { font-size: 10px; color: #94a3b8; font-weight: 600; white-space: nowrap; }
.pf-day__hari { font-size: 14px; font-weight: 800; color: #102b57; }
.pf-day__jam  { font-size: 10px; font-weight: 700; color: #64748b; white-space: nowrap; }
.pf-day--today { background: #f6c40b; }
.pf-day--today .pf-day__tgl,
.pf-day--today .pf-day__hari,
.pf-day--today .pf-day__jam { color: #102b57; }
.pf-day--upcoming { opacity: .55; }

/* KONTAK */
.pf-kontak { display: flex; align-items: center; gap: 0; }
.pf-kontak-item { flex: 1; display: flex; align-items: center; gap: 12px; }
.pf-kontak-icon {
    width: 40px; height: 40px; background: #eef4ff; color: #2d5bff;
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.pf-kontak-item small { display: block; font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.pf-kontak-item span  { font-size: 13px; font-weight: 700; color: #102b57; }
.pf-kontak-divider { width: 1px; height: 40px; background: #e2e8f0; margin: 0 18px; flex-shrink: 0; }

/* STATS CARD */
.pf-stats-card { background: #fff; border-radius: 22px; padding: 24px; box-shadow: 0 10px 30px rgba(16,43,87,.07); }
.pf-stats-list { display: flex; flex-direction: column; gap: 14px; }
.pf-stat-row { display: flex; align-items: center; gap: 14px; background: #f8fafc; border-radius: 14px; padding: 14px 16px; }
.pf-stat-row__icon {
    width: 42px; height: 42px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.pf-stat-row__icon.blue   { background: #e7efff; color: #2d5bff; }
.pf-stat-row__icon.yellow { background: #fff9e0; color: #c8980a; }
.pf-stat-row__icon.green  { background: #dcfce7; color: #15803d; }
.pf-stat-row__icon.red    { background: #fee2e2; color: #dc2626; }
.pf-stat-row__body { display: flex; flex-direction: column; gap: 2px; }
.pf-stat-row__body span   { font-size: 12px; color: #94a3b8; font-weight: 500; }
.pf-stat-row__body strong { font-size: 15px; font-weight: 800; color: #102b57; }

/* QUICK CARD */
.pf-quick-card { background: #fff; border-radius: 22px; padding: 24px; box-shadow: 0 10px 30px rgba(16,43,87,.07); }
.pf-quick-list { display: flex; flex-direction: column; gap: 8px; }
.pf-quick-item {
    display: flex; align-items: center; gap: 12px;
    background: #f8fafc; border-radius: 14px; padding: 14px 16px;
    text-decoration: none; color: #102b57;
    font-size: 14px; font-weight: 600;
    transition: background .2s;
}
.pf-quick-item:hover { background: #eef4ff; }
.pf-quick-item > i:first-child { width: 20px; color: #2d5bff; font-size: 16px; text-align: center; }
.pf-quick-arrow { margin-left: auto; font-size: 12px; color: #94a3b8; }

/* RESPONSIVE */
@media (max-width: 1100px) {
    .pf-hero-card { grid-template-columns: 180px 1fr; }
    .pf-status-mini { grid-column: 1 / -1; flex-direction: row; gap: 20px; align-items: center; }
    .pf-sm-divider  { width: 1px; height: 40px; margin: 0; }
    .pf-body { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .pf-hero-card { grid-template-columns: 1fr; }
    .pf-hero-img img { max-width: 160px; }
    .pf-meta-grid { grid-template-columns: repeat(2, 1fr); }
    .pf-edu-grid  { grid-template-columns: 1fr; }
    .pf-kontak    { flex-direction: column; gap: 14px; }
    .pf-kontak-divider { width: 100%; height: 1px; margin: 0; }
    .pf-status-mini { flex-direction: column; align-items: flex-start; }
}

</style>

@endsection