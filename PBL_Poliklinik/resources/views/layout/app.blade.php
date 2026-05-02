<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
</head>

<body>

    @if (!isset($hideNavbar))
        @include('partial.navbar')
    @endif

    @yield('hero')

    <main>
        @yield('content')
    </main>

    @if (!isset($hideNavbar))
        @include('partial.footer')
    @endif
</body>

</html>