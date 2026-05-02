<nav class="navbar">
    <div class="logo">
        <a href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <span>Poliklinik Polinema</span>
        </a>
    </div>

    <ul class="menu">
        <li>
            <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">
                Beranda
            </a>
        </li>

        <li>
            <a href="{{ route('reservasi') }}" class="{{ request()->routeIs('reservasi') ? 'active' : '' }}">
                Reservasi
            </a>
        </li>

        <li>
            <a href="{{ route('riwayat') }}" class="{{ request()->routeIs('riwayat') ? 'active' : '' }}">
                Riwayat
            </a>
        </li>

        <li>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">
                Profil
            </a>
        </li>

        <li>
            <a href="{{ route('jadwal') }}" class="{{ request()->routeIs('jadwal') ? 'active' : '' }}">
                Jadwal
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

    .logout button {
        background: #1e3a8a;
        color: white;
        padding: 8px 18px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
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