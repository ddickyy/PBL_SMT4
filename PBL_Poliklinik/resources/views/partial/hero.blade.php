@props([
    'badge' => 'Layanan Kesehatan Mahasiswa',
    'title' => 'Solusi Kesehatan Terpadu di Kampus Anda',
    'desc' => 'Kami menyediakan layanan kesehatan yang profesional dan terintegrasi di lingkungan kampus untuk mendukung kebutuhan kesehatan Anda.',
    'buttonText' => null,
    'buttonLink' => '#',
    'bg' => asset('images/poliklinik.jpg')
])

<section class="hero-section">
    <div class="hero" style="background-image: url('{{ $bg }}');">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <span class="hero-badge">{{ $badge }}</span>

            <h1>{{ $title }}</h1>

            <p>{{ $desc }}</p>

            @if($buttonText)
                <a href="{{ $buttonLink }}" class="hero-btn">
                    {{ $buttonText }} →
                </a>
            @endif
        </div>
    </div>
</section>

<style>
    .hero-section {
        padding: 24px;
        background: #f3f4f6;
        padding-top: 120px;
    }

    .hero {
        position: relative;
        width: 100%;
        min-height: 580px;
        border-radius: 30px;
        overflow: hidden;
        display: flex;
        align-items: center;
        background-size: cover;
        background-position: center;
        box-shadow: 0 24px 60px rgba(16, 43, 87, 0.15);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                90deg,
                rgba(16, 43, 87, 0.92) 0%,
                rgba(16, 43, 87, 0.86) 30%,
                rgba(16, 43, 87, 0.70) 58%,
                rgba(16, 43, 87, 0.30) 100%
            );
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 720px;
        color: #ffffff;
        padding: 64px 72px;
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .hero-badge {
        display: inline-block;
        background: #f6c40b;
        color: #102b57;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.03em;
        margin-bottom: 22px;
    }

    .hero h1 {
        font-size: clamp(2.5rem, 4vw, 4.1rem);
        font-weight: 800;
        line-height: 1.08;
        margin: 0 0 18px;
        letter-spacing: -0.03em;
    }

    .hero p {
        font-size: 1.02rem;
        color: rgba(255, 255, 255, 0.82);
        line-height: 1.75;
        margin: 0 0 30px;
        max-width: 620px;
    }

    .hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f6c40b;
        color: #102b57;
        padding: 14px 24px;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(246, 196, 11, 0.28);
        transition: all 0.25s ease;
    }

    .hero-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(246, 196, 11, 0.38);
    }

    @media (max-width: 1024px) {
        .hero-section {
            padding: 18px;
        }

        .hero {
            min-height: 520px;
            border-radius: 24px;
        }

        .hero-content {
            padding: 52px 42px;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 14px;
        }

        .hero {
            min-height: 460px;
            border-radius: 20px;
        }

        .hero-content {
            padding: 34px 24px;
            max-width: 100%;
        }

        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 0.95rem;
        }
    }
</style>