<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-2.png') }}">
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css" />
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Poppins', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }
    </style>
    <style>
        /* Override Tailwind Preflight resets to preserve existing custom CSS */
        h1 { font-size: 2em; font-weight: bold; }
        h2 { font-size: 1.5em; font-weight: bold; }
        h3 { font-size: 1.17em; font-weight: bold; }
        h4 { font-size: 1em; font-weight: bold; }
        h5 { font-size: 0.83em; font-weight: bold; }
        h6 { font-size: 0.67em; font-weight: bold; }
        p { margin: 0; }
        a { color: inherit; text-decoration: inherit; }
        ul, ol { list-style: none; margin: 0; padding: 0; }
        img, svg, video, canvas, audio, iframe, embed, object { display: revert; vertical-align: revert; }
        img, video { max-width: revert; height: revert; }
        button, input, select, optgroup, textarea {
            font-family: inherit;
            background-color: revert;
            border-radius: revert;
            opacity: revert;
        }
        *, ::before, ::after { border-style: revert; border-width: revert; }
    </style>

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

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({
            once: true, // Animasi hanya berjalan sekali saat di-scroll
            duration: 1200, // Durasi animasi lebih lambat (1200ms) agar terasa sangat smooth
            easing: 'ease-out-quart', // Easing yang lebih lembut di akhir animasi
            offset: 40, // Mulai animasi sedikit lebih awal
        });

        // NProgress Configuration
        NProgress.configure({ showSpinner: false, speed: 400, minimum: 0.1 });
        
        document.addEventListener('click', function(e) {
            let target = e.target.closest('a');
            if (target && target.href && !target.href.includes('#') && target.target !== '_blank' && target.hostname === window.location.hostname) {
                NProgress.start();
            }
        });
        
        document.addEventListener('submit', function() {
            NProgress.start();
        });
        
        window.addEventListener('load', function() {
            NProgress.done();
        });
        
        NProgress.start();
        document.addEventListener('DOMContentLoaded', function() {
            NProgress.done();
        });

        // SweetAlert2 Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif
    </script>

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
        font-family: 'Poppins', system-ui, -apple-system,
            BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--bg);
        color: var(--text);
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        display: block;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .alert-success {
        display: none !important;
    }

    #nprogress .bar {
        background: #f6c40b !important;
        height: 4px !important;
    }
    #nprogress .peg {
        box-shadow: 0 0 10px #f6c40b, 0 0 5px #f6c40b !important;
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