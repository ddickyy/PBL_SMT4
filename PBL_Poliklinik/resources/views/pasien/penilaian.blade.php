@extends('layout.app')

@section('title', 'Beri Penilaian')

@section('hero')
@include('partial.hero', [
    'badge' => 'Layanan Kesehatan Kampus',
    'title' => 'Penilaian <br><span style="color:#facc15;">Konsultasi Medis</span>',
    'desc' => 'Berikan ulasan objektif mengenai layanan yang Anda terima dari dokter kami. Partisipasi Anda sangat membantu dalam meningkatkan kualitas layanan kesehatan poliklinik.',
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])
@endsection

@section('content')

<section class="penilaian-page">
    <div class="penilaian-container">
        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(isset($reservasi))
            <div class="reservation-info">
                <div class="reservation-header">
                    <div class="doctor-avatar">
                        @if(optional(optional($reservasi->jadwal)->dokter->user)->foto)
                            <img src="{{ asset('storage/' . $reservasi->jadwal->dokter->user->foto) }}"
                                 alt="Foto Dokter">
                        @else
                            <div class="profile-initials">
                                {{ strtoupper(substr(optional(optional($reservasi->jadwal)->dokter->user)->nama ?? 'D', 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3>{{ optional(optional($reservasi->jadwal)->dokter->user)->nama ?? 'Dokter' }}</h3>
                        <p>{{ optional(optional($reservasi->jadwal)->dokter)->spesialisasi->nama_spesialisasi ?? '-' }}</p>
                    </div>
                </div>

                <div class="reservation-detail">
                    <div class="detail-item">
                        <span>Tanggal Reservasi</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('d F Y') }}
                        </strong>
                    </div>

                    <div class="detail-item">
                        <span>Nomor Antrian</span>
                        <strong>#{{ $reservasi->nomor_antrian }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Status</span>
                        <strong class="status-badge">
                            {{ ucfirst($reservasi->status) }}
                        </strong>
                    </div>
                </div>
            </div>
        @endif

        <div class="penilaian-card">
            <form action="{{ route('pasien.penilaian.store') }}"
                  method="POST">
                @csrf

                @if(isset($reservasi) && $reservasi->id_reservasi)
                    <input type="hidden"
                           name="id_reservasi"
                           value="{{ $reservasi->id_reservasi }}">
                @endif

                <div class="form-group">
                    <label for="kritik">
                        KRITIK
                    </label>

                    <textarea id="kritik"
                              name="kritik"
                              placeholder="Apa yang perlu kami perbaiki hari ini?">{{ old('kritik') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="saran">
                        SARAN
                    </label>
                    <textarea id="saran"
                              name="saran"
                              placeholder="Ide atau harapan Anda untuk layanan kami ke depan...">{{ old('saran') }}</textarea>
                </div>

                <button type="submit"
                        class="btn-submit">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Penilaian
                </button>
            </form>
        </div>
    </div>
</section>

<style>
    * {
        box-sizing: border-box;
    }

    .penilaian-page {
        padding: 30px 24px 70px;
        background: #f5f7fb;
    }

    .penilaian-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border-radius: 18px;
        padding: 18px 22px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .alert-error ul {
        margin: 8px 0 0;
        padding-left: 18px;
    }

    .reservation-info {
        background: white;
        border-radius: 28px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
    }

    .reservation-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
    }

    .doctor-avatar {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: #102b57;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 24px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 6px 16px rgba(16, 43, 87, 0.12);
    }

    .doctor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #102b57;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        width: 100%;
        height: 100%;
        font-size: 24px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .reservation-header h3 {
        margin: 0 0 4px;
        color: #102b57;
        font-size: 24px;
        font-weight: 900;
    }

    .reservation-header p {
        margin: 0;
        color: #64748b;
    }

    .reservation-detail {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .detail-item {
        background: #f8fafc;
        border-radius: 16px;
        padding: 18px;
    }

    .detail-item span {
        display: block;
        margin-bottom: 8px;
        font-size: 12px;
        color: #64748b;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .detail-item strong {
        color: #102b57;
        font-size: 16px;
        font-weight: 800;
    }

    .status-badge {
        color: #1d4ed8 !important;
    }

    .penilaian-card {
        background: white;
        border-radius: 28px;
        padding: 34px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
    }

    .form-group {
        margin-bottom: 28px;
    }

    .form-group label {
        display: block;
        margin-bottom: 12px;
        font-size: 13px;
        font-weight: 800;
        color: #102b57;
        letter-spacing: .08em;
    }

    .form-group textarea {
        width: 100%;
        min-height: 140px;
        border: none;
        outline: none;
        resize: vertical;
        background: #f8fafc;
        border-radius: 18px;
        padding: 20px;
        font-size: 15px;
        color: #102b57;
        line-height: 1.8;
        font-family: inherit;
        transition: .25s ease;
    }

    .form-group textarea:focus {
        background: #eef4ff;
        box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
    }

    .form-group textarea::placeholder {
        color: #94a3b8;
    }

    .btn-submit {
        width: 100%;
        border: none;
        background: #facc15;
        color: #102b57;
        padding: 18px;
        border-radius: 18px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        transition: .25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit:hover {
        background: #eab308;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {

        .penilaian-page {
            padding: 20px 14px 60px;
        }

        .penilaian-container {
            padding: 0;
        }

        .reservation-detail {
            grid-template-columns: 1fr;
        }

        .reservation-header {
            align-items: flex-start;
        }

        .penilaian-card,
        .reservation-info {
            padding: 24px;
        }
    }
</style>
@endsection