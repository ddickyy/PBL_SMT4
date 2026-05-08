@extends('layout.app')

@section('title', 'Beri Penilaian')

@section('hero')

@include('partial.hero', [
    'badge' => 'Layanan Kesehatan Kampus',
    'title' => 'Penilaian <br><span style="color:#facc15;">Konsultasi Medis</span>',
    'desc' => 'Berikan ulasan objektif mengenai layanan yang Anda terima dari dokter kami. Partisipasi Anda dalam mengisi survei kepuasan ini sangat membantu dalam memantau kualitas layanan kesehatan di poliklinik.',
    'buttonText' => null,
    'bg' => asset('images/poliklinik.jpg')
])

@endsection

@section('content')

<section class="penilaian-page">

    <div class="penilaian-container">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))

            <div class="alert-success">

                <i class="fa-solid fa-circle-check"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif

        {{-- ALERT ERROR --}}
        @if($errors->any())

            <div class="alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>

                    <strong>
                        Terjadi kesalahan:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        @endif

        {{-- FORM --}}
        <div class="penilaian-card">

            <form
                action="{{ route('pasien.penilaian.store') }}"
                method="POST"
            >

                @csrf

                {{-- RESERVASI --}}
                @if(isset($reservasi) && optional($reservasi)->id)

                    <input
                        type="hidden"
                        name="reservasi_id"
                        value="{{ $reservasi->id }}"
                    >

                @endif

                {{-- KRITIK --}}
                <div class="form-group">

                    <label for="kritik">
                        KRITIK
                    </label>

                    <textarea
                        id="kritik"
                        name="kritik"
                        placeholder="Apa yang perlu kami perbaiki hari ini?"
                    >{{ old('kritik') }}</textarea>

                </div>

                {{-- SARAN --}}
                <div class="form-group">

                    <label for="saran">
                        SARAN
                    </label>

                    <textarea
                        id="saran"
                        name="saran"
                        placeholder="Ide atau harapan Anda untuk layanan kami ke depan..."
                    >{{ old('saran') }}</textarea>

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="btn-submit"
                >

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
        width: 100%;
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

    .penilaian-card {
        background: white;
        border-radius: 28px;
        padding: 34px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
        margin-bottom: 40px;
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

    .section-heading {
        margin-bottom: 24px;
    }

    .section-heading h2 {
        margin: 0 0 8px;
        font-size: 32px;
        font-weight: 900;
        color: #102b57;
    }

    .section-heading p {
        margin: 0;
        color: #64748b;
    }

    @media (max-width: 768px) {

        .penilaian-page {
            padding: 20px 14px 60px;
        }

        .penilaian-card {
            padding: 24px;
        }

        .section-heading h2 {
            font-size: 26px;
        }

        .history-card {
            padding: 22px;
        }

        .history-top {
            align-items: flex-start;
        }

    }

</style>

@endsection