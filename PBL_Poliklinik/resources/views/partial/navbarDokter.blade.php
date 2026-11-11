<nav class="navbar">

    {{-- LOGO --}}
    <div class="logo">
        <a href="{{ route('dokter.beranda') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
            <span>Poliklinik Polinema</span>
        </a>
    </div>

    {{-- MENU --}}
    <ul class="menu">

        <li>
            <a href="{{ route('dokter.beranda') }}"
               class="{{ request()->routeIs('dokter.beranda') ? 'active' : '' }}">

                Beranda

            </a>
        </li>

        <li>
            <a href="{{ route('dokter.pasien') }}"
               class="{{ request()->routeIs('dokter.pasien*') ? 'active' : '' }}">

                Pasien

            </a>
        </li>

        <li>
            <a href="{{ route('dokter.riwayat') }}"
               class="{{ request()->routeIs('dokter.riwayat') ? 'active' : '' }}">

                Riwayat

            </a>
        </li>

    </ul>

    {{-- RIGHT SECTION --}}
    <div class="nav-right">
        
        <button type="button" class="mobile-menu-btn" onclick="toggleMobileMenu()">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="profile-dropdown">

            {{-- PROFILE BUTTON --}}
            <button type="button"
                    class="profile-trigger"
                    onclick="toggleProfileDropdown()">

                <div class="profile-circle {{ request()->routeIs('dokter.profil*') ? 'active' : '' }}">

                    @if(auth()->user()->foto)

                        <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                             alt="Foto Profil"
                             class="profile-img">

                    @else

                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}

                    @endif

                </div>

                <svg class="dropdown-icon"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 9l-7 7-7-7" />

                </svg>

            </button>

            {{-- DROPDOWN MENU --}}
            <div class="dropdown-menu" id="profileDropdown">

                <a href="{{ route('dokter.profil') }}"
                   class="dropdown-item">

                    Profil Dokter

                </a>

                <form action="{{ route('logout') }}"
                      method="POST">

                    @csrf

                    <button type="submit"
                            class="dropdown-item logout-item">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>

<script>

    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('show');
    }
    
    function toggleMobileMenu() {
        const menu = document.querySelector('.menu');
        menu.classList.toggle('show');
    }

    // CLOSE DROPDOWN WHEN CLICK OUTSIDE
    window.addEventListener('click', function (e) {
        const profileDropdown = document.querySelector('.profile-dropdown');
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const menu = document.querySelector('.menu');

        if (profileDropdown && !profileDropdown.contains(e.target)) {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) dropdown.classList.remove('show');
        }
        
        if (menu && mobileMenuBtn && !menu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
            menu.classList.remove('show');
        }
    });

    // DYNAMIC NAVBAR SCROLL EFFECT
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

</script>


<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 28px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(16, 43, 87, 0.08);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .navbar.scrolled {
        top: 15px;
        left: 4%;
        right: 4%;
        border-radius: 999px;
        padding: 10px 24px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        box-shadow: 0 15px 35px rgba(16, 43, 87, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-bottom: none;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo a {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #102b57;
        font-weight: 800;
        font-size: 15px;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .menu {
        display: flex;
        align-items: center;
        gap: 28px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .menu a {
        position: relative;
        text-decoration: none;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 0;
        transition: color 0.2s ease;
    }

    .menu a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 0;
        height: 3px;
        background: #f6c40b;
        border-radius: 999px;
        transition: width 0.25s ease;
    }

    .menu a:hover {
        color: #102b57;
    }

    .nav-right {
        display: flex;
        align-items: center;
    }


    .profile-dropdown {
        position: relative;
    }

    .profile-trigger {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f6c40b;
        border: none;
        border-radius: 999px;
        padding: 6px 12px 6px 6px;
        cursor: pointer;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .profile-trigger:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(246, 196, 11, 0.25);
    }

    .profile-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #102b57;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        overflow: hidden;
        border: 2px solid white;
        flex-shrink: 0;
    }

    .profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .dropdown-icon {
        width: 18px;
        height: 18px;
        color: #102b57;
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 220px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
        padding: 10px;
        display: none;
        flex-direction: column;
        z-index: 999;
        animation: dropdownFade 0.2s ease;
    }

    .dropdown-menu.show {
        display: flex;
    }

    @keyframes dropdownFade {

        from {
            opacity: 0;
            transform: translateY(-6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    .dropdown-item {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 12px 14px;
        border: none;
        background: transparent;
        border-radius: 12px;
        text-decoration: none;
        color: #1e293b;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition:
            background 0.2s ease,
            color 0.2s ease;
        text-align: left;
    }

    .dropdown-item:hover {
        background: #f1f5f9;
        color: #102b57;
    }

    .logout-item {
        color: #dc2626;
    }

    .logout-item:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    .menu a:hover::after,
    .menu a.active::after {
        width: 100%;
    }

    .menu a.active {
        color: #102b57;
        font-weight: 700;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .profile-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #102b57;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 800;
        font-size: 15px;
        overflow: hidden;
        border: 2px solid transparent;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            border-color 0.2s ease;
        flex-shrink: 0;
    }

    .profile-circle:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(16, 43, 87, 0.18);
    }

    .profile-circle.active {
        border-color: #f6c40b;
    }

    .profile-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .logout-form {
        margin: 0;
    }

    .logout-btn {
        background: #f6c40b;
        color: #102b57;
        padding: 10px 18px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 700;
        font-size: 14px;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            opacity 0.2s ease;
    }

    .logout-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(246, 196, 11, 0.25);
        opacity: 0.96;
    }

    .mobile-menu-btn {
        display: none;
    }

    @media (max-width: 900px) {
        .navbar.scrolled {
            left: 2%;
            right: 2%;
            border-radius: 20px;
        }
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 12px 16px;
            flex-wrap: wrap;
        }

        .navbar.scrolled {
            top: 10px;
            left: 10px;
            right: 10px;
            border-radius: 16px;
        }

        .logo a {
            font-size: 14px;
        }
        
        .logo a span {
            display: none;
        }
        
        .logo-img {
            width: 36px;
            height: 36px;
        }

        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #102b57;
            border: none;
            border-radius: 10px;
            width: 38px;
            height: 38px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .mobile-menu-btn:hover {
            background: #e2e8f0;
        }

        .menu {
            display: none;
            width: 100%;
            flex-direction: column;
            gap: 5px;
            padding-top: 16px;
            border-top: 1px dashed rgba(16,43,87,0.1);
            margin-top: 10px;
        }
        
        .menu.show {
            display: flex;
        }

        .menu a {
            font-size: 14px;
            padding: 10px 14px;
            border-radius: 10px;
            width: 100%;
        }
        
        .menu a::after {
            display: none;
        }
        
        .menu a.active {
            background: #eef4ff;
        }
    }
</style>