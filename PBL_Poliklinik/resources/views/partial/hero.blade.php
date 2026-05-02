<section class="hero">

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <span class="hero-badge">
            {{ $badge ?? 'Layanan Kesehatan Mahasiswa' }}
        </span>

        <h1>
            {{ $title ?? 'Judul Default' }}
        </h1>

        <p>
            {{ $desc ?? 'Deskripsi default hero section' }}
        </p>

        @if(isset($buttonText))
            <a href="{{ $buttonLink ?? '#' }}" class="hero-btn">
                {{ $buttonText }} →
            </a>
        @endif
    </div>

</section>
<style>
    .hero {
        position: relative;
        height: 90vh;
        background-image: url('/images/poliklinik.jpg');
        background-size: cover;
        background-position: center;
        border-radius: 20px;
        display: flex;
        align-items: center;
        padding: 60px;
        overflow: hidden;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(10, 30, 70, 0.75);
    }

    .hero-content {
        position: relative;
        color: white;
        max-width: 600px;
        z-index: 2;
    }

    .hero-badge {
        display: inline-block;
        background: #facc15;
        color: #1e293b;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 14px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .hero h1 {
        font-size: 56px;
        font-weight: bold;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .hero p {
        color: #cbd5f5;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .hero-btn {
        display: inline-block;
        background: #facc15;
        color: #1e293b;
        padding: 14px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
    }
</style>