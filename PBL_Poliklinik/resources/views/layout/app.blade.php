<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>
</head>

<body>

    @if(!isset($hideNavbar) || !$hideNavbar)
        @include('partial.navbar')
    @endif

    @yield('hero')

    <main>
        @yield('content')
    </main>

    @if (!isset($hideNavbar) || !$hideNavbar)
        @include('partial.footer')
    @endif
</body>

</html>