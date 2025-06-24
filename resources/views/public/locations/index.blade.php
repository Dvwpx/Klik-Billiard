@extends('layouts.public')

@section('title', 'Daftar Lokasi - Klik Billiard')

@section('content')

{{-- Location Hero & Filter Bar --}}
<section class="location-hero" data-aos="fade-in">
    <div class="container">
        <h1 class="display-4 text-white">Temukan Arena Terbaikmu</h1>
        <p class="lead text-muted">Direktori tempat biliar paling lengkap dan terkurasi.</p>

        <div class="filter-bar mt-5 col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
            {{-- Nanti kita bisa fungsikan filter ini --}}
            <form class="form-inline">
                <input class="form-control flex-grow-1 mr-2" type="search" placeholder="Cari nama lokasi atau kota..." aria-label="Search">
                <button class="btn btn-primary" type="submit">Cari</button>
            </form>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            @forelse ($locations as $location)
            <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <a href="{{ route('locations.public.show', $location->slug) }}" class="text-decoration-none">
                    <div class="card location-card-v2">
                        <div class="img-wrapper">
                            @if($location->featured_image)
                            <img src="{{ asset('storage/' . $location->featured_image) }}" alt="{{ $location->name }}">
                            @else
                            <img src="https://via.placeholder.com/400x500.png?text=Klik+Billiard" alt="Klik Billiard">
                            @endif
                        </div>
                        <div class="card-content">
                            <h5 class="card-title">{{ $location->name }}</h5>
                            <p class="card-text">
                                <i class="ti-location-pin"></i> {{ $location->city }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col text-center">
                <p>Belum ada lokasi yang ditambahkan.</p>
            </div>
            @endforelse
        </div>

        {{-- Link Paginasi --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $locations->links() }}
        </div>
    </div>
</div>
@endsection