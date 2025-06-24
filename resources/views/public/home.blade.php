@extends('layouts.public')

@section('title', 'Klik Billiard - Portal Biliar No. 1 Indonesia')

@section('content')

{{-- Hero Section dengan YouTube Background --}}
<section class="hero-section-video">
    {{-- Ganti tag <video> dengan div ini --}}
    <div id="youtube-player" class="hero-video-bg"></div>

    <div class="hero-overlay"></div>
    <div class="hero-content text-center">
        <h1 data-aos="fade-down">SATU STICK, SEJUTA CERITA</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="200">Temukan arena, pelajari teknik, dan jadilah bagian dari komunitas biliar terbesar di Indonesia.</p>
        <div data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('locations.public.index') }}" class="btn btn-primary btn-lg">Cari Lokasi Terdekat</a>
        </div>
    </div>
</section>

{{-- Konten Utama dengan Latar Belakang Gelap --}}
<div class="main-content">
    <div class="container py-5">
        {{-- Bagian "Terbaru dari Blog" --}}
        <section id="latest-articles" class="py-5 text-center">
            <h2 class="section-title" data-aos="fade-up">TERBARU DARI BLOG</h2>
            <div class="row mt-4">
                @forelse ($latestArticles as $article)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="article-card-v2">
                        <a href="{{ route('blog.show', $article->slug) }}" class="d-block">
                            <div class="article-card-img-container">
                                @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                @else
                                <img src="https://via.placeholder.com/400x250.png?text=Klik+Billiard" alt="Klik Billiard">
                                @endif
                                <div class="article-card-category">{{ $article->created_at->format('d M') }}</div>
                            </div>
                            <div class="article-card-body">
                                <h5 class="article-card-title">{{ $article->title }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col">
                    <p>Belum ada artikel.</p>
                </div>
                @endforelse
            </div>
        </section>
        <section class="booking-section text-center" id=booking data-aos="zoom-in">
            <div class="container">
                <h2 class="section-title">BOOKING MEJA SEKARANG</h2>
                <p class="lead text-muted mb-4">Jangan sampai kehabisan tempat! Amankan meja Anda untuk pengalaman bermain terbaik.</p>

                @php
                $phoneNumber = '6285180904344'; // GANTI DENGAN NOMOR WA ANDA
                $message = "Halo Klik Billiard, saya tertarik untuk booking meja. Mohon informasinya.";
                @endphp

                <a href="https://wa.me/{{ $phoneNumber }}?text={{ urlencode($message) }}" target="_blank" class="btn btn-whatsapp btn-lg">
                    <i class="fab fa-whatsapp"></i> Booking via WhatsApp
                </a>
            </div>
        </section>

        {{-- Bagian lain akan kita tambahkan di sini --}}

    </div>
</div>
@endsection