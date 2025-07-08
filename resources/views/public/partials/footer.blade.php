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
                    <a href="https://www.instagram.com/klik.billiard.official/" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@klik.billiard.academy" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.youtube.com/@klikbilliardacademy" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
                <ul class="footer-links">
                    <li><a href="mailto:beelklik@gmail.com">beelklik@gmail.com</a></li>
                    <li><a href="https://wa.me/6282177715551" target="_blank">+62 821-7771-5551</a></li>
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

<style>
    /* ===================================================================
   FINAL FOOTER RESPONSIVE FIX
   =================================================================== */

    @media (max-width: 991.98px) {

        /* Aturan untuk Tablet */
        .main-footer .footer-links,
        .main-footer .social-icons {
            text-align: left;
            /* Buat semua rata tengah */
            justify-content: center;
            /* Untuk social icons */
        }

        .main-footer .footer-links ul {
            display: inline-block;
            /* Trik agar list bisa di-tengah */
            text-align: left;
            /* Tapi teks di dalamnya tetap rata kiri */
        }

        .main-footer .footer-about {
            text-align: center;
            /* Rata tengah untuk footer about */
        }
    }

    @media (max-width: 767.98px) {

        /* Aturan khusus untuk HP */
        .main-footer {
            padding: 3rem 0 1rem 0;
            /* Kurangi padding atas-bawah di HP */
        }

        .main-footer .col-lg-5,
        .main-footer .col-lg-3,
        .main-footer .col-lg-4 {
            /* Beri jarak bawah yang konsisten antar kolom saat di-stack */
            margin-bottom: 2.5rem;
        }

        .footer-bottom {
            flex-direction: column;
        }
    }
</style>