@extends('layouts.public')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KLIK BILLIARD</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logoklik.png') }}">
    <!-- CSS lainnya -->
</head>

@section('content')

{{-- 1. Hero Section (Video YouTube) --}}
<section id="hero" class="hero-section-video">
    <div id="youtube-player" class="hero-video-bg"></div>
</section>

<div class="main-content">
    {{-- 2. Seksi Tentang Kami (About) --}}
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title" data-aos="fade-up">Selamat Datang di Klik Billiard</h2>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">
                        Kami adalah detak jantung komunitas biliar di Indonesia. Tempat di mana para pemula menemukan panduan, para master berbagi ilmu, dan semua pecinta biliar menemukan rumah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Seksi Galeri Promo --}}
<section id="promo" class="section-padding">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="section-title" data-aos="fade-up">Promo & Penawaran Spesial</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            @forelse ($activePromos as $promo)
            <div class="col-lg-4 col-md-6 col-12 mb-4 promo-item" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <a href="{{ $promo->link_url ?? '#' }}"
                   target="_blank"
                   class="promo-gallery-card"
                   aria-label="Promo {{ $promo->title }}">
                    <div class="promo-image-container">
                        <img src="{{ $promo->banner_image }}"
                             alt="{{ $promo->title }}"
                             loading="lazy"
                             decoding="async"
                             class="promo-image">
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Saat ini belum ada promo spesial. Cek kembali nanti!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
    
    {{-- 3. Seksi Lokasi --}}
    <section id="locations" class="location-showcase-split">
        @if($featuredLocation)
        <div class="row align-items-center">
            {{-- Kolom Kiri - Peta --}}
            <div class="col-lg-7" data-aos="fade-in">
                @if(is_numeric($featuredLocation->latitude) && is_numeric($featuredLocation->longitude))
                <div id="map-showcase" class="location-map-panel"></div>
                @else
                {{-- Fallback dengan gambar jika tidak ada koordinat --}}
                <div class="location-map-panel" style="background: url('{{ $featuredLocation->featured_image ? asset('storage/' . $featuredLocation->featured_image) : '' }}') no-repeat center center; background-size: cover;"></div>
                @endif
            </div>

            {{-- Kolom Kanan - Informasi --}}
            <div class="col-lg-5" data-aos="fade-left">
                <div class="location-info-side">
                    <p class="subtitle">Lokasi & Kontak</p>
                    <h2 class="title">{{ $featuredLocation->name }}</h2>
                    <p class="address">{{ $featuredLocation->address }}, {{ $featuredLocation->city }}</p>

                    <div class="info-grid">
                        <div class="info-item">
                            <i class="ti-timer"></i>
                            <div>
                                <strong>Jam Buka</strong><br>
                                <span>Setiap Hari, 10:00 - 02:00 WIB</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="ti-mobile"></i>
                            <div>
                                <strong>Reservasi via WhatsApp</strong><br>
                                <span>{{ $featuredLocation->phone_number }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ $featuredLocation->map_url }}" class="btn btn-primary mt-3" style="width: fit-content;" target="_blank" rel="noopener">
                        Navigasi Lokasi
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="container section-padding text-center">
            <h2 class="section-title">LOKASI KAMI</h2>
            <p class="text-muted">Informasi lokasi akan segera ditampilkan. Silakan tambahkan data lokasi di Admin Panel.</p>
        </div>
        @endif
    </section>

    {{-- 4. Seksi Fasilitas --}}
    <section id="fasilitas" class="section-padding bg-dark-grey">
        <div class="container">

            {{-- Bagian Fasilitas Umum --}}
            <div data-aos="fade-up">
                <h2 class="section-title">FASILITAS STANDAR KAMI</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <ul class="amenities-list">
                            @foreach($amenities as $amenity)
                            <li class="amenity-list-item">
                                <i class="{{ $amenity['icon'] }}"></i>
                                <span>{{ $amenity['name'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <hr style="border-color: var(--border-color); margin: 5rem 0;">

            {{-- Bagian Showcase Peralatan --}}
            <div data-aos="fade-up">
                <div class="row text-center">
                    <div class="col-lg-8 mx-auto">
                        <h2 class="section-title">Peralatan Kelas Profesional</h2>
                        <p class="lead text-muted mb-5">
                            Pengalaman bermain terbaik dimulai dari peralatan terbaik. Kami hanya menyediakan produk berkualitas dan terpercaya.
                        </p>
                    </div>
                </div>

                {{-- Looping untuk setiap item peralatan --}}
                @forelse ($showcaseFacilities as $facility)
                <div class="equipment-split-item" data-aos="fade-up">
                    <div class="row no-gutters">

                        {{-- Logic untuk layout zig-zag --}}
                        @if($loop->iteration % 2 == 1)
                        {{-- Ganjil: Teks Kiri, Gambar Kanan --}}
                        <div class="col-lg-6">
                            <div class="equipment-split-content">
                                <p class="category">{{ $facility->category }}</p>
                                <h3 class="name">{{ $facility->name }}</h3>
                                <p class="description">{{ $facility->description }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="equipment-split-image">
                                @if($facility->image)
                                <img src="{{ $facility->image }}" alt="{{ $facility->name }}">
                                @else
                                <img src="https://via.placeholder.com/400x400.png?text=Image" alt="Image">
                                @endif
                            </div>
                        </div>
                        @else
                        {{-- Genap: Gambar Kiri, Teks Kanan --}}
                        <div class="col-lg-6 order-lg-2">
                            <div class="equipment-split-content">
                                <p class="category">{{ $facility->category }}</p>
                                <h3 class="name">{{ $facility->name }}</h3>
                                <p class="description">{{ $facility->description }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 order-lg-1">
                            <div class="equipment-split-image">
                                @if($facility->image)
                                <img src="{{ $facility->image }}" alt="{{ $facility->name }}">
                                @else
                                <img src="https://via.placeholder.com/400x400.png?text=Image" alt="Image">
                                @endif
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                @empty
                <div class="col text-center">
                    <p>Belum ada data peralatan untuk ditampilkan.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>


    {{-- 5. Seksi Menu F&B --}}
    <section id="menu" class="section-padding">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h2 class="section-title" data-aos="fade-up">MENU F&B</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-right">
                    <h3 class="menu-column-title">Makanan</h3>
                    <div class="mt-4">
                        @forelse ($foodItems as $item)
                        <div class="menu-item-final">
                            @if($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="menu-item-image">
                            @endif
                            <div class="details-wrapper">
                                <div class="details">
                                    <h5 class="name">{{ $item->name }}</h5>
                                    <p class="description">{{ $item->description }}</p>
                                </div>
                                <h5 class="price">Rp{{ number_format($item->price) }}</h5>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-muted">Menu makanan akan segera hadir.</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="100">
                    <h3 class="menu-column-title">Minuman</h3>
                    <div class="mt-4">
                        @forelse ($drinkItems as $item)
                        <div class="menu-item-final">
                            @if($item->image)
                            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="menu-item-image">
                            @endif
                            <div class="details-wrapper">
                                <div class="details">
                                    <h5 class="name">{{ $item->name }}</h5>
                                    <p class="description">{{ $item->description }}</p>
                                </div>
                                <h5 class="price">Rp{{ number_format($item->price) }}</h5>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-muted">Menu minuman akan segera hadir.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. Seksi Turnamen --}}
<section id="turnamen" class="section-padding">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">TURNAMEN TERKINI</h2>
        <p class="text-center text-muted lead mb-5" data-aos="fade-up" data-aos-delay="100">Ikuti perkembangan event-event paling bergengsi.</p>
        <div class="row">
            @foreach ($recentTournaments as $tournament)
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 2) * 100 }}">
                <a href="{{ route('tournaments.public.show', $tournament->slug) }}" class="text-decoration-none">
                    <div class="tournament-card">
                        <div class="tournament-image" style="background-image: url('{{ $tournament->poster_image ?? 'https://via.placeholder.com/400x300.png?text=Event' }}');"></div>
                        <div class="tournament-overlay"></div>
                        <div class="tournament-content">
                            <span class="tournament-status status-{{ strtolower(str_replace(' ', '-', $tournament->status)) }}">{{ $tournament->status }}</span>
                            <h4 class="tournament-name">{{ Str::limit($tournament->name, 40) }}</h4>
                            <p class="tournament-date">{{ \Carbon\Carbon::parse($tournament->start_date)->format('d F Y') }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('tournaments.public.index') }}" class="btn btn-primary">Lihat Semua Turnamen</a>
        </div>
    </div>
</section>

    {{-- 7. Seksi Blog --}}
    <section id="blog" class="py-5 bg-dark-grey">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">ARTIKEL TERBARU</h2>
            <div class="row mt-4">
                @foreach ($latestArticles as $article)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="article-card-v2">
                        <a href="{{ route('blog.show', $article->slug) }}" class="d-block">
                            <div class="article-card-img-container">
                                <img src="{{ $article->featured_image ?? 'https://via.placeholder.com/400x250.png?text=Klik+Billiard' }}" alt="{{ $article->title }}">
                                <div class="article-card-category">{{ $article->created_at->format('d M') }}</div>
                            </div>
                            <div class="article-card-body">
                                <h5 class="article-card-title">{{ $article->title }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('blog.index') }}" class="btn btn-primary">Lihat Semua Artikel</a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
{{-- Script Peta untuk Showcase Lokasi --}}
@if(isset($featuredLocation) && is_numeric($featuredLocation->latitude) && is_numeric($featuredLocation->longitude))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var lat = {{ $featuredLocation->latitude }};
        var lng = {{ $featuredLocation->longitude }};
        // Pastikan menargetkan ID 'map-showcase'
        var map = L.map('map-showcase', {
            center: [lat, lng],
            zoom: 17,
            scrollWheelZoom: false
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        var marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("<b>{{ $featuredLocation->name }}</b>").openPopup();
    });
</script>
@endif


<style>
.tournament-card {
    position: relative;
    height: 300px;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.tournament-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.tournament-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.tournament-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
    z-index: 1;
}

.tournament-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
    z-index: 2;
    color: white;
}

.tournament-status {
    display: inline-block;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Status: Akan Datang */
.tournament-status.status-akan-datang {
    background: red;
}

/* Status: Sedang Berlangsung */
.tournament-status.status-sedang-berlangsung {
    background: orange;
}

/* Status: Sudah Selesai */
.tournament-status.status-selesai {
    background: #16ff24ba;
}

/* Status: Registrasi Dibuka */
.tournament-status.status-registrasi-dibuka {
    background: #13a81c;
}

/* Status: Registrasi Ditutup */
.tournament-status.status-registrasi-ditutup {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
}

/* Fallback untuk status lainnya */
.tournament-status {
    background: #16ff24c9;
}

.tournament-name {
    color: white;
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.tournament-date {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 0;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .tournament-card {
        height: 250px;
    }
    
    .tournament-content {
        padding: 20px;
    }
    
    .tournament-name {
        font-size: 1.1rem;
    }
    
    .tournament-date {
        font-size: 0.9rem;
    }
}
/* --- Perbaikan Tampilan Mobile untuk Galeri Promo --- */

/* Atur kontainer gambar agar memiliki rasio aspek yang konsisten */
.promo-image-container {
    position: relative;
    width: 100%;
    /* Atur rasio aspek di sini. Contoh: 1 / 1 untuk kotak, 4 / 3, atau 16 / 9.
       Padding-top dengan persen adalah trik lama untuk rasio aspek.
       Misal: padding-top: 100% untuk rasio 1:1 (persegi).
       Sesuaikan nilainya sesuai desain yang Anda inginkan. */
    padding-top: 125%; /* Contoh untuk gambar yang sedikit lebih tinggi dari lebarnya */
    overflow: hidden;
    border-radius: 8px; /* Opsional: untuk sudut yang melengkung */
    background-color: #f0f0f0; /* Warna placeholder saat gambar loading */
}

/* Jadikan gambar mengisi seluruh kontainer */
.promo-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    /* Properti kunci untuk mengatasi gambar terpotong */
    object-fit: cover; /* Memastikan gambar menutupi area tanpa merusak rasio aspek */
    object-position: center; /* Memusatkan gambar di dalam kontainer */
}

/* Kita bisa juga menggunakan media query jika ingin aturan ini HANYA berlaku di mobile */
@media (max-width: 767px) {
    .promo-image-container {
        /* Anda bisa mengubah rasio aspek khusus untuk mobile jika perlu */
        /* padding-top: 125%; */
    }
}


</style>