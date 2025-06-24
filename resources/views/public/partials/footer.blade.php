<footer class="main-footer">
    <div class="container">
        <div class="row">

            {{-- Kolom 1: Tentang & Sosial Media --}}
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0" data-aos="fade-up">
                <div class="footer-about">
                    <a href="{{ route('home') }}" class="footer-logo">KLIK<span>BILLIARD</span></a>
                    <p class="footer-tagline">Portal informasi, komunitas, dan direktori dunia biliar terlengkap di Indonesia.</p>
                    <div class="social-icons mt-4">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            {{-- Kolom 2: Link Cepat --}}
            <div class="col-6 col-lg-2 col-md-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <h5 class="footer-title">Navigasi</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('locations.public.index') }}">Lokasi</a></li>
                    <li><a href="{{ route('tournaments.public.index') }}">Turnamen</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Link Lainnya --}}
            <div class="col-6 col-lg-3 col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                <h5 class="footer-title">Info</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('facilities.public.index') }}">Fasilitas</a></li>
                    <li><a href="{{ route('menu.public.index') }}">Menu F&B</a></li>
                    <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                </ul>
            </div>

            {{-- Kolom 4: Kontak --}}
            <div class="col-12 col-lg-3 col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                <h5 class="footer-title">Hubungi Kami</h5>
                <ul class="footer-links">
                    <li><a href="mailto:info@klikbilliard.com">info@klikbilliard.com</a></li>
                    <li><a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>
<div class="footer-bottom">
    {{-- ... (kode footer-bottom tidak berubah) ... --}}
</div>