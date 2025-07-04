<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid px-3 px-lg-5">
        <a class="navbar-brand smooth-scroll d-flex align-items-center" href="/">
            <img src="{{ asset('assets/images/logoklik.png') }}" alt="Klik Billiard Logo" class="klik-logo mr-2">
            <span class="brand-text">
                <span class="text-white">BILLIARD</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link smooth-scroll" href="/">Beranda</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll" href="/lokasi/citra-raya">Lokasi</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll" href="/fasilitas">Fasilitas</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll" href="/menu">Menu F&B</a></li>
                {{-- Link ke Halaman Terpisah --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('tournaments.public.index') }}">Turnamen</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Artikel</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Ukuran logo khusus navbar */
    .klik-logo {
        height: 55px;
        width: auto;
        object-fit: contain;
        transition: all 0.3s ease-in-out;
    }

    .brand-text {
        font-size: 1.8rem;
        font-weight: 700;
        letter-spacing: 3px;
    }

    .text-white {
        color: #ffffff !important;
    }

    .text-primary {
        color: #00aaff !important;
        /* Bisa kamu ganti ke biru lain sesuai brand */
    }

    /* Responsive */
    @media (max-width: 576px) {
        .klik-logo {
            height: 42px;
        }

        .brand-text {
            font-size: 1.3rem;
        }
    }
</style>