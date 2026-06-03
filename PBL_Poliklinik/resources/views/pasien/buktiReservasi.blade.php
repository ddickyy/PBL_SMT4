@extends('layout.app')

@section('title', 'Bukti Reservasi')

@section('hero')
@include('partial.hero', [
    'badge' => 'Layanan Kesehatan',
    'title' => "Reservasi\nBerhasil Dibuat",
    'desc' => "Simpan bukti reservasi Anda dan datang sesuai jadwal yang telah ditentukan.",
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])
@endsection

@section('content')

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<section class="bukti-page">
    <div class="bukti-wrap">

    {{-- HEADER --}}
    <div class="section-header">

        <h2 class="section-title">
            Bukti Reservasi
        </h2>

    </div>

    @if(session('success'))
        <div class="alert-success" style="background: #dcfce7; color: #15803d; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(22, 101, 52, 0.05);">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error" style="background: #fee2e2; color: #dc2626; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.05);">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($reservasi))

        <div class="bukti-card">

            {{-- DOKTER --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Dokter
                </span>

                <span class="bukti-value">

                    {{
                        optional(
                            optional(
                                $reservasi->jadwal
                            )->dokter->user
                        )->nama ?? '-'
                    }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- LAYANAN --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Layanan
                </span>

                <span class="bukti-value">

                    {{
                        optional(
                            optional(
                                $reservasi->jadwal
                            )->dokter
                        )->spesialisasi
                            ->nama_spesialisasi ?? '-'
                    }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- TANGGAL --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Tanggal Pemeriksaan
                </span>

                <span class="bukti-value">

                    {{
                        Carbon::parse(
                            $reservasi->tanggal_reservasi
                        )
                        ->locale('id')
                        ->translatedFormat(
                            'l, d F Y'
                        )
                    }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- JAM --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Estimasi Jam
                </span>

                <span class="bukti-value">

                    {{
                        Carbon::parse(
                            $reservasi->estimasi_jam
                        )->format('H:i')
                    }}
                    WIB

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- ANTRIAN --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Nomor Antrian
                </span>

                <span class="bukti-value bukti-antrian">

                    #{{ $reservasi->nomor_antrian }}

                </span>

            </div>

            <div class="bukti-divider"></div>

            {{-- STATUS --}}
            <div class="bukti-row">

                <span class="bukti-label">
                    Status
                </span>

                <span class="status-badge">

                    {{
                        ucfirst(
                            $reservasi->status
                        )
                    }}

                </span>

            </div>

        </div>

        @if(in_array($reservasi->status, ['selesai', 'done']))
            {{-- HASIL PEMERIKSAAN & CATATAN DOKTER --}}
            @if($reservasi->rekamMedis)
                <div class="detail-section-card">
                    <div class="detail-section-header">
                        <i class="fa-solid fa-file-medical detail-icon-medical"></i>
                        <h3>Hasil Pemeriksaan & Catatan Dokter</h3>
                    </div>
                    <div class="detail-section-body">
                        <div class="medical-detail-item">
                            <span class="medical-detail-label">Diagnosis</span>
                            <span class="medical-detail-value">{{ $reservasi->rekamMedis->diagnosis }}</span>
                        </div>
                        <div class="medical-detail-divider"></div>
                        <div class="medical-detail-item column-layout">
                            <span class="medical-detail-label" style="margin-bottom: 6px;">Catatan / Resep Dokter</span>
                            <p class="medical-detail-text">{{ $reservasi->rekamMedis->catatan ?? 'Tidak ada catatan.' }}</p>
                        </div>
                        <div class="medical-detail-divider"></div>
                        <div class="medical-detail-item">
                            <span class="medical-detail-label">Dokter Pemeriksa</span>
                            <span class="medical-detail-value">
                                {{ optional($reservasi->rekamMedis->dokter->user ?? $reservasi->jadwal->dokter->user)->nama }} 
                                @if(optional($reservasi->rekamMedis->dokter->spesialisasi ?? $reservasi->jadwal->dokter->spesialisasi)->nama_spesialisasi)
                                    ({{ optional($reservasi->rekamMedis->dokter->spesialisasi ?? $reservasi->jadwal->dokter->spesialisasi)->nama_spesialisasi }})
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- PENILAIAN PELAYANAN --}}
            <div class="detail-section-card" id="penilaian-section">
                <div class="detail-section-header">
                    <i class="fa-solid fa-star detail-icon-star"></i>
                    <h3>Penilaian Pelayanan</h3>
                </div>
                <div class="detail-section-body">
                    @if($reservasi->penilaian)
                        {{-- TAMPILAN JIKA SUDAH MENILAI --}}
                        <div id="penilaian-view-mode">
                            @if($reservasi->penilaian->kritik)
                                <div class="review-item">
                                    <span class="review-label">Kritik / Masukan</span>
                                    <p class="review-text">"{{ $reservasi->penilaian->kritik }}"</p>
                                </div>
                            @endif
                            @if($reservasi->penilaian->saran)
                                <div class="review-item" style="margin-top: 14px;">
                                    <span class="review-label">Saran Perbaikan</span>
                                    <p class="review-text">"{{ $reservasi->penilaian->saran }}"</p>
                                </div>
                            @endif
                            @if(!$reservasi->penilaian->kritik && !$reservasi->penilaian->saran)
                                <p class="review-empty-text">Ulasan kosong.</p>
                            @endif
                            
                            <button type="button" onclick="toggleEditFeedback(true)" class="btn-secondary-bukti" style="margin-top: 18px; width: 100%;">
                                <i class="fa-solid fa-edit"></i> Edit Penilaian
                            </button>
                        </div>

                        {{-- FORM EDIT PENILAIAN --}}
                        <div id="penilaian-edit-mode" style="display: none;">
                            <form action="{{ route('pasien.penilaian.update', $reservasi->penilaian->id_penilaian) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group-bukti">
                                    <label for="edit_kritik" class="form-label-bukti">Kritik / Masukan Terhadap Pelayanan</label>
                                    <textarea name="kritik" id="edit_kritik" rows="3" class="form-textarea-bukti" placeholder="Tulis kritik atau masukan Anda di sini...">{{ $reservasi->penilaian->kritik }}</textarea>
                                </div>

                                <div class="form-group-bukti" style="margin-top: 14px;">
                                    <label for="edit_saran" class="form-label-bukti">Saran Untuk Peningkatan Pelayanan</label>
                                    <textarea name="saran" id="edit_saran" rows="3" class="form-textarea-bukti" placeholder="Tulis saran Anda di sini...">{{ $reservasi->penilaian->saran }}</textarea>
                                </div>

                                <div class="form-actions-bukti" style="margin-top: 18px; display: flex; gap: 10px;">
                                    <button type="submit" class="btn-save-bukti">Simpan Perubahan</button>
                                    <button type="button" onclick="toggleEditFeedback(false)" class="btn-cancel-edit-bukti">Batal</button>
                                </div>
                            </form>
                        </div>
                    @else
                        {{-- FORM BUAT PENILAIAN BARU --}}
                        <form action="{{ route('pasien.penilaian.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_reservasi" value="{{ $reservasi->id_reservasi }}">

                            <div class="form-group-bukti">
                                <label for="new_kritik" class="form-label-bukti">Kritik / Masukan Terhadap Pelayanan</label>
                                <textarea name="kritik" id="new_kritik" rows="3" class="form-textarea-bukti" placeholder="Tulis kritik atau masukan Anda di sini..."></textarea>
                            </div>

                            <div class="form-group-bukti" style="margin-top: 14px;">
                                <label for="new_saran" class="form-label-bukti">Saran Untuk Peningkatan Pelayanan</label>
                                <textarea name="saran" id="new_saran" rows="3" class="form-textarea-bukti" placeholder="Tulis saran Anda di sini..."></textarea>
                            </div>

                            <button type="submit" class="btn-submit-bukti" style="margin-top: 18px; width: 100%;">
                                Kirim Penilaian
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif

    @else

        {{-- EMPTY --}}
        <div class="empty-box">

            <i class="fa-solid fa-file-circle-xmark"></i>

            <h3>
                Bukti Reservasi Tidak Ditemukan
            </h3>

            <p>
                Data reservasi tidak tersedia
                atau sudah dihapus.
            </p>

        </div>

    @endif


    {{-- BUTTON --}}
    <div class="aksi-grid">
        @if(isset($reservasi) && in_array($reservasi->status, ['menunggu', 'dikonfirmasi']))
            <form action="{{ route('pasien.reservasi.cancel', $reservasi->id_reservasi) }}" method="POST" style="width: 100%; display: block;" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-cancel-bukti">
                    Batalkan Reservasi
                </button>
            </form>
        @endif

        <a href="{{ route('pasien.beranda') }}"
           class="btn-primary-bukti">

            Kembali ke Beranda

        </a>

    </div>

</section>

<style>

    .bukti-page {
        background: #f5f7fb;
        padding: 40px 0 90px;
        min-height: 80vh;
    }

    .bukti-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .section-header {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 900;
        color: #102b57;
        margin: 0;
    }

    .bukti-card {
        background: white;
        border-radius: 24px;
        padding: 34px 38px;
        box-shadow:
            0 10px 34px rgba(16,43,87,.07);

        margin-bottom: 22px;
    }

    .bukti-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 16px 0;
    }

    .bukti-label {
        font-size: .95rem;
        font-weight: 600;
        color: #64748b;
    }

    .bukti-value {
        font-size: .96rem;
        font-weight: 800;
        color: #102b57;
        text-align: right;
    }

    .bukti-divider {
        height: 1px;
        background: #eef2f6;
    }

    .bukti-antrian {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 900;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 14px;
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 800;
    }

    .wa-card {
        background: white;
        border-radius: 22px;
        padding: 22px 28px;
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 28px;

        border-left: 5px solid #facc15;

        box-shadow:
            0 10px 34px rgba(16,43,87,.07);
    }

    .wa-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #facc15;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .wa-icon svg {
        width: 22px;
        height: 22px;
        color: #102b57;
    }

    .wa-title {
        margin: 0 0 4px;
        font-size: .95rem;
        font-weight: 800;
        color: #102b57;
    }

    .wa-desc {
        margin: 0;
        color: #64748b;
        font-size: .88rem;
        line-height: 1.6;
    }

    .aksi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
    }

    .btn-secondary,
    .btn-primary-bukti {

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 16px;

        border-radius: 16px;

        text-decoration: none;

        font-size: .95rem;
        font-weight: 800;

        transition: .25s ease;
    }

    .btn-secondary {
        background: white;
        border: 2px solid #e7ebf2;
        color: #102b57;
    }

    .btn-secondary:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    .btn-primary-bukti {
        background: #102b57;

        color: white;

        box-shadow:
            0 10px 26px rgba(16,43,87,.18);
    }

    .btn-primary-bukti:hover {
        transform: translateY(-2px);
    }

    .btn-cancel-bukti {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 16px;
        border-radius: 16px;
        font-size: .95rem;
        font-weight: 800;
        background: #fee2e2;
        color: #dc2626;
        border: 2px solid #fecaca;
        cursor: pointer;
        transition: .25s ease;
        box-sizing: border-box;
    }

    .btn-cancel-bukti:hover {
        background: #fca5a5;
        border-color: #fca5a5;
        color: white;
        transform: translateY(-2px);
    }

    .empty-box {
        background: white;
        border-radius: 24px;
        padding: 54px 24px;
        text-align: center;
        margin-bottom: 24px;

        box-shadow:
            0 10px 34px rgba(16,43,87,.07);
    }

    .empty-box i {
        font-size: 44px;
        color: #94a3b8;
        margin-bottom: 14px;
    }

    .empty-box h3 {
        margin: 0 0 8px;
        color: #102b57;
    }

    .empty-box p {
        margin: 0;
        color: #64748b;
    }

    @media (max-width: 560px)
    {
        .bukti-wrap {
            padding: 0 16px;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .bukti-card {
            padding: 24px 22px;
        }

        .bukti-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .bukti-value {
            text-align: left;
        }

        .wa-card {
            flex-direction: column;
            padding: 20px;
            gap: 12px;
        }

        .aksi-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ADDITIONAL PREMIUM STYLES FOR COMPLETED RESERVATION SECTIONS */
    .detail-section-card {
        background: white;
        border-radius: 24px;
        padding: 34px 38px;
        box-shadow: 0 10px 34px rgba(16,43,87,.07);
        margin-bottom: 22px;
        border: 1.5px solid #eef0f5;
        box-sizing: border-box;
    }

    .detail-section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        border-bottom: 2px solid #eef2f6;
        padding-bottom: 14px;
    }

    .detail-section-header h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #102b57;
        margin: 0;
    }

    .detail-icon-medical {
        font-size: 20px;
        color: #1d4ed8;
    }

    .detail-icon-star {
        font-size: 20px;
        color: #facc15;
    }

    .medical-detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 12px 0;
    }

    .medical-detail-item.column-layout {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }

    .medical-detail-label {
        font-size: .95rem;
        font-weight: 600;
        color: #64748b;
    }

    .medical-detail-value {
        font-size: .96rem;
        font-weight: 800;
        color: #102b57;
        text-align: right;
    }

    .medical-detail-text {
        margin: 0;
        font-size: .95rem;
        color: #334155;
        line-height: 1.6;
        background: #f8fafc;
        border: 1px solid #eef2f6;
        padding: 14px 18px;
        border-radius: 14px;
        width: 100%;
        box-sizing: border-box;
    }

    .medical-detail-divider {
        height: 1px;
        background: #eef2f6;
    }

    .form-group-bukti {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label-bukti {
        font-size: .9rem;
        font-weight: 700;
        color: #102b57;
    }

    .form-textarea-bukti {
        width: 100%;
        padding: 14px 18px;
        border-radius: 14px;
        border: 1.5px solid #cbd5e1;
        font-family: inherit;
        font-size: .95rem;
        color: #334155;
        resize: vertical;
        box-sizing: border-box;
        transition: all .2s ease;
    }

    .form-textarea-bukti:focus {
        outline: none;
        border-color: #102b57;
        box-shadow: 0 0 0 3px rgba(16,43,87,.08);
    }

    .review-item {
        margin-bottom: 14px;
    }

    .review-label {
        display: block;
        font-size: .85rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .review-text {
        margin: 0;
        font-size: .95rem;
        color: #334155;
        background: #f8fafc;
        border-left: 4px solid #102b57;
        padding: 12px 16px;
        border-radius: 0 12px 12px 0;
        font-style: italic;
    }

    .review-empty-text {
        color: #94a3b8;
        font-size: .9rem;
        font-style: italic;
        margin: 0;
    }

    .btn-submit-bukti {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-radius: 16px;
        font-size: .95rem;
        font-weight: 800;
        background: #102b57;
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 26px rgba(16,43,87,.18);
        transition: all .25s ease;
    }

    .btn-submit-bukti:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(16,43,87,.24);
    }

    .btn-save-bukti {
        flex: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
        border-radius: 14px;
        font-size: .9rem;
        font-weight: 800;
        background: #102b57;
        color: white;
        border: none;
        cursor: pointer;
        transition: all .25s ease;
    }

    .btn-save-bukti:hover {
        background: #0d2247;
        transform: translateY(-2px);
    }

    .btn-cancel-edit-bukti {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
        border-radius: 14px;
        font-size: .9rem;
        font-weight: 800;
        background: #f1f5f9;
        color: #475569;
        border: 1.5px solid #cbd5e1;
        cursor: pointer;
        transition: all .25s ease;
    }

    .btn-cancel-edit-bukti:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-secondary-bukti {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        border-radius: 14px;
        font-size: .9rem;
        font-weight: 800;
        background: white;
        color: #102b57;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        transition: all .25s ease;
    }

    .btn-secondary-bukti:hover {
        border-color: #102b57;
        transform: translateY(-2px);
    }

    @media (max-width: 560px) {
        .detail-section-card {
            padding: 24px 22px;
        }

        .medical-detail-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .medical-detail-value {
            text-align: left;
        }
    }

</style>

<script>
    function toggleEditFeedback(show) {
        const viewMode = document.getElementById('penilaian-view-mode');
        const editMode = document.getElementById('penilaian-edit-mode');
        if (show) {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
        } else {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
        }
    }
</script>

@endsection