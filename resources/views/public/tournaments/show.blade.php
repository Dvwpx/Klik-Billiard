@extends('layouts.public')

@section('title', $tournament->name)

@section('content')

<section class="article-hero" data-aos="fade-in">
    <div class="article-hero-bg" style="background-image: url('{{ $tournament->poster_image ?? 'https://via.placeholder.com/1920x800.png?text=Klik+Billiard' }}');"></div>
    <div class="article-hero-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="article-hero-content text-center" data-aos="fade-up">
                    <p class="tournament-status" style="font-size: 2rem; color: var(--secondary-color);">{{ $tournament->status }}</p>
                    <h1>{{ $tournament->name }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="info-card tournament-details">
                    <h4>Detail Turnamen</h4>
                    <div class="info-item"><i class="ti-calendar"></i><span>{{ \Carbon\Carbon::parse($tournament->start_date)->format('d F Y') }}
                            @if($tournament->end_date) - {{ \Carbon\Carbon::parse($tournament->end_date)->format('d F Y') }}@endif</span></div>
                    <div class="info-item"><i class="ti-location-pin"></i><span>{{ $tournament->location->name ?? 'Akan diumumkan' }}</span></div>
                </div>

                @if($tournament->description)
                <div class="info-card mt-4">
                    <h4>Deskripsi</h4>
                    <div style="white-space: pre-wrap;">{{ $tournament->description }}</div>
                </div>
                @endif
            </div>
            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                <div class="sticky-sidebar">
                    @if($tournament->winner)
                    <div class="winner-card">
                        <h5 class="winner-title">🏆 Champion 🏆</h5>
                        @if($tournament->winner->profile_image)<img src="{{ $tournament->winner->profile_image }}" alt="{{ $tournament->winner->name }}" class="winner-avatar">
                        @else<img src="https://via.placeholder.com/120x120.png?text=🏆" alt="Winner" class="winner-avatar">@endif
                        <h3 class="winner-name">{{ $tournament->winner->name }}</h3>
                        @if($tournament->winner->nickname)<p class="mb-0">"{{ $tournament->winner->nickname }}"</p>@endif
                    </div>
                    @else
                    <div class="info-card">
                        <h4>Pemenang</h4>
                        <p>Pemenang akan diumumkan setelah turnamen selesai.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-5">
            <a href="{{ route('tournaments.public.index') }}" class="btn btn-outline-light"> &laquo; Kembali ke Semua Turnamen</a>
        </div>
    </div>
</div>
@endsection