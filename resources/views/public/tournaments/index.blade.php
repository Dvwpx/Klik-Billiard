@extends('layouts.public')

@section('title', 'Riwayat Turnamen - Klik Billiard')

@section('content')

<section class="page-header-v2" data-aos="fade-in">
    <div class="container">
        <h1>Riwayat & Jadwal Turnamen</h1>
        <p class="lead text-muted">Lihat semua event turnamen yang telah dan akan diselenggarakan.</p>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            @forelse ($tournaments as $tournament)
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <a href="{{ route('tournaments.public.show', $tournament->slug) }}" class="text-decoration-none">
                    <div class="tournament-card" style="height: 400px;">
                        <div class="card-bg-container">
                            <img src="{{ $tournament->poster_image ? asset('storage/' . $tournament->poster_image) : 'https://via.placeholder.com/400x500.png?text=Event' }}" alt="{{ $tournament->name }}">
                        </div>
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <p class="tournament-status">{{ $tournament->status }}</p>
                            <h4 class="tournament-name">{{ $tournament->name }}</h4>
                            <p class="tournament-date">{{ \Carbon\Carbon::parse($tournament->start_date)->format('d F Y') }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col text-center">
                <p>Belum ada data turnamen.</p>
            </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $tournaments->links() }}
        </div>
    </div>
</div>
@endsection