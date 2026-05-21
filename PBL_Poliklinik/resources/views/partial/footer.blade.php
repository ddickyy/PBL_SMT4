<footer class="footer">
    <div class="footer-container">

        {{-- LEFT --}}
        <div class="footer-left">
            <h2>Poliklinik Politeknik Negeri Malang</h2>
            <p>
                Memberikan solusi kesehatan modern bagi mahasiswa dan seluruh
                sivitas akademika dengan standar profesional tinggi.
            </p>

            <div class="social-icons">
                <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                <a href="#"><i class="fa-regular fa-envelope"></i></a>
                <a href="#"><i class="fa-solid fa-phone"></i></a>
            </div>
        </div>

        {{-- NAVIGASI --}}
        <div class="footer-links">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="{{ route('pasien.beranda') }}">Beranda</a></li>
                <li><a href="{{ route('pasien.reservasi.index') }}">Reservasi</a></li>
                <li><a href="{{ route('pasien.riwayat') }}">Riwayat</a></li>
                <li><a href="{{ route('pasien.profil.show') }}">Profil</a></li>
            </ul>
        </div>

        {{-- BANTUAN --}}
        <div class="footer-links">
            <h4>Bantuan</h4>
            <ul>
                <li><a href="#">Pusat Bantuan</a></li>
                <li><a href="#">Syarat & Ketentuan</a></li>
                <li><a href="#">Kebijakan Privasi</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </div>

    </div>

    {{-- BOTTOM --}}
    <div class="footer-bottom">
        © 2026 POLIKLINIK POLINEMA • SISTEM RESERVASI POLIKLINIK POLINEMA
    </div>
</footer>

<style>
    .footer {
        background: #e5e7eb;
        padding: 60px 40px 20px;
        color: #1e293b;
    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .footer-left {
        max-width: 400px;
    }

    .footer-left h2 {
        font-size: 22px;
        margin-bottom: 15px;
    }

    .footer-left p {
        color: #64748b;
        line-height: 1.6;
    }

    .social-icons {
        margin-top: 20px;
        display: flex;
        gap: 15px;
    }

    .social-icons a {
        width: 45px;
        height: 45px;
        background: #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1e293b;
        font-size: 18px;
        transition: 0.3s;
    }

    .social-icons a:hover {
        background: #1e3a8a;
        color: white;
    }

    .footer-links h4 {
        margin-bottom: 15px;
        font-size: 18px;
    }

    .footer-links ul {
        list-style: none;
        padding: 0;
    }

    .footer-links ul li {
        margin-bottom: 10px;
    }

    .footer-links ul li a {
        text-decoration: none;
        color: #475569;
        transition: 0.3s;
    }

    .footer-links ul li a:hover {
        color: #1e3a8a;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #cbd5e1;
        font-size: 14px;
        color: #475569;
    }
</style>