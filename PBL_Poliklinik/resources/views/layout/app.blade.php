<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-2.png') }}">
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

    @if(auth()->check() && (!isset($hideNavbar) || !$hideNavbar))

        @if(isset($dokterLayout) && $dokterLayout)

            @include('partial.navbarDokter')

        @else

            @include('partial.navbar')

        @endif

    @endif

    @yield('hero')

    <main>

        @yield('content')

    </main>

    @if(!isset($hideNavbar) || !$hideNavbar)

        @include('partial.footer')

    @endif

</body>

</html>

<style>
    :root {
        --navy: #102b57;
        --yellow: #f6c40b;
        --bg: #f7f7f8;
        --card: #ffffff;
        --soft: #f2f2f4;
        --text: #17315c;
        --muted: #6f7380;
        --footer: #c9cad4;
        --shadow: 0 24px 60px rgba(16, 43, 87, .08);
        --shadow-soft: 0 16px 40px rgba(16, 43, 87, .05);
        --radius: 32px;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
    }

    body {
        margin: 0;
        font-family: 'Inter', system-ui, -apple-system,
            BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--bg);
        color: var(--text);
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        width: 0;
        height: 0;
        display: none;
    }

    /* Consistent Hover and Transition Effects across all pages */
    .card, .service-card, .profile-card, .ep-card {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease !important;
    }
    .card:hover, .service-card:hover, .profile-card:hover, .ep-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(16, 43, 87, 0.08) !important;
    }

    .doctor-item, .riwayat-card, .activity-card, .medical-item {
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease, background-color 0.25s ease !important;
    }
    .doctor-item:hover, .riwayat-card:hover, .activity-card:hover, .medical-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(16, 43, 87, 0.06) !important;
    }

    .btn-save, .ep-btn--save, .btn-emergency, .btn-primary-bukti, .btn-submit-bukti, .btn-confirm-modern, .btn-more-dokter-left, .ep-btn-upload, .ep-btn--cancel, .btn-crop-apply, .btn-crop-cancel, .btn-more-dokter-left, .ep-btn-back {
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, background-color 0.2s ease, opacity 0.2s ease !important;
    }
    .btn-save:hover, .ep-btn--save:hover, .btn-emergency:hover, .btn-primary-bukti:hover, .btn-submit-bukti:hover, .btn-confirm-modern:hover, .ep-btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 43, 87, 0.15) !important;
    }
</style>