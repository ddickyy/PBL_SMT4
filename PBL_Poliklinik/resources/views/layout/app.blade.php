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

    @if(!isset($hideNavbar) || !$hideNavbar)

        @include('partial.navbar')

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
</style>
```