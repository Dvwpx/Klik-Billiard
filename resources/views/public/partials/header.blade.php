<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid px-3 px-lg-5">
        <a class="navbar-brand smooth-scroll d-flex align-items-center" href="/">
            <img src="{{ asset('assets/images/logoklik.png') }}" alt="Klik Billiard Logo" class="klik-logo mr-2">
            <span class="brand-text">
                <span class="text-white"></span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link smooth-scroll {{ Request::is('/') ? 'active' : '' }}" href="/">Beranda</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll {{ Request::is('lokasi') ? 'active' : '' }}" href="/lokasi">Lokasi</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll {{ Request::is('fasilitas') ? 'active' : '' }}" href="/fasilitas">Fasilitas</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll {{ Request::is('menu') ? 'active' : '' }}" href="/menu">Menu F&B</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::is('turnamen*') ? 'active' : '' }}" href="{{ route('tournaments.public.index') }}">Turnamen</a></li>
                <li class="nav-item"><a class="nav-link {{ Request::is('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}">News</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
     /* Ukuran logo khusus navbar (kode Anda yang sudah ada) */
    .klik-logo {
        height: 85px;
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
    
    /* ======================================= */
    /* == CSS BARU UNTUK NAVIGASI AKTIF == */
    /* ======================================= */

    /* Memberi warna dan ketebalan berbeda pada link yang aktif */
    .navbar-dark .navbar-nav .nav-link.active {
        color: #00aaff !important; /* Menggunakan warna primer dari komentar Anda */
        font-weight: 700; /* Membuat teks sedikit lebih tebal */
    }

    /* Opsi styling lain (pilih salah satu atau gabungkan) */
    /* Memberi garis bawah pada link yang aktif */
    /*
    .navbar-dark .navbar-nav .nav-link.active {
        color: #ffffff !important;
        border-bottom: 2px solid #00aaff;
        padding-bottom: 5px; // Sesuaikan padding agar garis tidak terlalu mepet
    }
    */
    

    /* Responsive (kode Anda yang sudah ada) */
    @media (max-width: 576px) {
        .klik-logo {
            height: 65px;
        }

        .brand-text {
            font-size: 1.3rem;
        }

        /* Menyesuaikan style aktif di mobile agar lebih jelas */
        .navbar-dark .navbar-nav .nav-link.active {
            background-color: rgba(0, 170, 255, 0.1); /* Memberi sedikit latar belakang */
            border-radius: 5px;
        }
    }
</style>