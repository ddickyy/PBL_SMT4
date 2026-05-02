<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>

    @include('partial.navbar')

    @yield('hero')

    <main>
        @yield('content')
    </main>

    @include('partial.footer')
</body>
</html>