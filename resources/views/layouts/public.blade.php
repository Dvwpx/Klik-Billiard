<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klik Billiard - Jelajahi Dunia Biliar Indonesia')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    {{-- Leaflet Maps CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    {{-- Animate On Scroll (AOS) CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">


    {{-- FILE CSS KUSTOM KITA --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    @include('public.partials.header')

    <main role="main">
        @yield('content')
    </main>

    @include('public.partials.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Leaflet Maps JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    {{-- Animate On Scroll (AOS) JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{-- Inisialisasi AOS --}}
    <script>
        AOS.init({
            duration: 800, // durasi animasi
            once: true // animasi hanya terjadi sekali
        });
    </script>

    <script>
        // 1. Script ini akan memuat YouTube IFrame Player API secara asynchronous.
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('youtube-player', {
                // GANTI 'VIDEO_ID' DENGAN ID VIDEO YOUTUBE ANDA
                videoId: 'LzWeSyZulWk',
                playerVars: {
                    'autoplay': 1, // Mainkan otomatis
                    'controls': 0, // Sembunyikan kontrol player
                    'rel': 0, // Jangan tampilkan video terkait
                    'showinfo': 0, // Sembunyikan judul video
                    'mute': 1, // Wajib mute untuk autoplay di browser modern
                    'loop': 1, // Ulangi video
                    'playlist': 'LzWeSyZulWk' // Diperlukan untuk loop
                },
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        // 3. API akan memanggil fungsi ini saat player siap.
        function onPlayerReady(event) {
            event.target.playVideo();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.querySelector('.back-to-top-btn');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) { // Tampilkan tombol setelah scroll 300px
                    backToTopButton.classList.add('visible');
                } else {
                    backToTopButton.classList.remove('visible');
                }
            });
        });
    </script>

    @stack('scripts')
    <div class="sticky-buttons">
        {{-- Tombol WhatsApp --}}
        @php
        $phoneNumber = '6281234567890'; // GANTI DENGAN NOMOR WA ANDA
        $message = "Halo Klik Billiard, saya tertarik untuk booking meja.";
        @endphp
        {{-- Tombol Back to Top --}}
        <a href="#hero" class="sticky-btn back-to-top-btn smooth-scroll">
            <i class="ti-arrow-up"></i>
        </a>
        <a href="https://wa.me/{{ $phoneNumber }}?text={{ urlencode($message) }}" target="_blank" class="sticky-btn whatsapp-btn">
            {{-- Ikon bola biliar --}}
            <img src="{{ asset('assets/images/bola8.png') }}" alt="Icon" style="width: 32px; height: 32px; margin-left: 10px;">
            <span class="booking-text">BOOKING NOW</span>
        </a>


    </div>
</body>

</html>