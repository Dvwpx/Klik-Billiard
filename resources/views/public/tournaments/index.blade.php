@extends('layouts.public')

@section('title', 'Riwayat Turnamen - Klik Billiard')

@section('content')

{{-- Page Header v2 --}}
<section class="page-header-v2">
    <div class="container" data-aos="fade-up">
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
                    <div class="card tournament-card">
                        @if($tournament->poster_image)
                        <img src="{{ asset('storage/' . $tournament->poster_image) }}" class="card-bg" alt="{{ $tournament->name }}">
                        @else
                        <img src="https://via.placeholder.com/400x500.png?text=Event" class="card-bg" alt="Poster Turnamen">
                        @endif
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

        {{-- Link Paginasi --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $tournaments->links() }}
        </div>
    </div>
</div>
@endsection