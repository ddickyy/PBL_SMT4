{{-- <nav class="navbar">
    <div class="logo">
        <a href="{{ route('pasien.beranda') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <span>Poliklinik Polinema</span>
        </a>
    </div>

    <ul class="menu">
        <li>
            <a href="{{ route('pasien.beranda') }}" class="{{ request()->routeIs('pasien.beranda') ? 'active' : '' }}">
                Beranda
            </a>
        </li>

        <li>
            <a href="{{ route('pasien.reservasi') }}"
                class="{{ request()->routeIs('pasien.reservasi') ? 'active' : '' }}">
                Reservasi
            </a>
        </li>

        <li>
            <a href="{{ route('pasien.riwayat') }}" class="{{ request()->routeIs('pasien.riwayat') ? 'active' : '' }}">
                Riwayat
            </a>
        </li>

        <li>
            <a href="{{ route('pasien.profil.show') }}"
                class="{{ request()->routeIs('pasien.profil.show') ? 'active' : '' }}">
                Profil
            </a>
        </li>
    </ul>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav> --}}

<nav class="navbar">
    <div class="logo">
        <a href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <span>Poliklinik Polinema</span>
        </a>
    </div>

    <ul class="menu">
        <li>
            <a href="{{ route('beranda') }}"
                class="{{ request()->routeIs('beranda') ? 'active' : '' }}">
                Beranda
            </a>
        </li>

        <li>
            <a href="/preview-reservasi"
                class="{{ request()->is('preview-reservasi') ? 'active' : '' }}">
                Reservasi
            </a>
        </li>

        <li>
            <a href="/preview-riwayat"
                class="{{ request()->is('preview-riwayat') ? 'active' : '' }}">
                Riwayat
            </a>
        </li>

        <li>
            <a href="{{ route('profil.show') }}"
                class="{{ request()->routeIs('profil.show') ? 'active' : '' }}">
                Profil
            </a>
        </li>
    </ul>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav>

<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background: #f5f5f5;
        border-radius: 12px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .menu {
        display: flex;
        gap: 30px;
        list-style: none;
    }

    .menu a {
        text-decoration: none;
        color: #2c3e50;
        position: relative;
        font-weight: 500;
    }

    .menu a.active {
        color: #1e3a8a;
    }

    .menu a.active::after {
        content: '';
        display: block;
        height: 3px;
        background: gold;
        margin-top: 5px;
        border-radius: 2px;
    }

    .menu a:hover {
        color: #132b5c;
    }

    .menu a:hover::after {
        width: 100%;
        transform: translateY(+5px);
    }

    .menu a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 4px;
        background: #facc15;
        border-radius: 999px;
        transition: width .3s ease;
    }

    .logout button {
        background: #1e3a8a;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
    }

    .logout button:hover {
        background: #132b5c;
        transform-box: fill-box;
        transform: translateY(-2px);
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #1e293b;
        font-weight: bold;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
</style>