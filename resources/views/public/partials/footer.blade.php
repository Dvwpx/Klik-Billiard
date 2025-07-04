<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 mb-4 mb-lg-0" data-aos="fade-up">
                <div class="footer-about">
                    <a href="#hero" class="footer-logo smooth-scroll">KLIK<span>BILLIARD</span></a>
                    <p class="footer-tagline">Portal informasi, komunitas, dan direktori dunia biliar terlengkap di Indonesia.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <h5 class="footer-title">Jelajahi</h5>
                <ul class="footer-links">
                    <li><a class="smooth-scroll" href="#locations">Lokasi</a></li>
                    <li><a href="{{ route('tournaments.public.index') }}">Turnamen</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a class="smooth-scroll" href="#about">Tentang</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                <h5 class="footer-title">Ikuti & Hubungi Kami</h5>
                <div class="social-icons mb-3">
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                <ul class="footer-links">
                    <li><a href="mailto:info@klikbilliard.com">info@klikbilliard.com</a></li>
                    <li><a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="footer-bottom">
    <div class="container text-center">
        <span>&copy; {{ date('Y') }} Klik Billiard.</span>
    </div>
</div>