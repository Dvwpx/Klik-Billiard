@extends('layouts.public')

@section('title', 'Fasilitas & Peralatan - Klik Billiard')

@section('content')

{{-- Page Header v2 --}}
<section class="page-header-v2">
    <div class="container" data-aos="fade-up">
        <h1>Fasilitas & Peralatan</h1>
        <p class="lead text-muted">Kami hanya menyediakan yang terbaik untuk pengalaman bermain Anda.</p>
    </div>
</section>

{{-- Bagian Fasilitas Umum (Desain Baru) --}}
<section class="amenities-list-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <ul class="amenities-list">
                    @foreach($amenities as $amenity)
                    <li class="amenity-list-item">
                        <i class="ti-check-box"></i>
                        <span>{{ $amenity }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        {{-- Bagian Katalog Peralatan --}}
        <div class="catalog-section">
            <h2 class="catalog-title" data-aos="fade-up">Katalog Peralatan</h2>

            {{-- Tombol Filter Kategori --}}
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-12 text-center mb-5">
                    <div class="nav filter-pills">
                        <a href="{{ route('facilities.public.index') }}" class="nav-link {{ request()->routeIs('facilities.public.index') ? 'active' : '' }}">Semua</a>
                        @foreach ($categories as $cat)
                        <a href="{{ route('facilities.public.byCategory', $cat->category) }}" class="nav-link {{ (isset($category) && $category == $cat->category) ? 'active' : '' }}">{{ $cat->category }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse ($facilities as $facility)
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                    <div class="card facility-card h-100">
                        <div class="facility-card-img-container">
                            @if($facility->image)
                            <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}">
                            @else
                            <img src="https://via.placeholder.com/100x100.png?text=Icon" alt="Icon">
                            @endif
                        </div>
                        <h5 class="facility-card-title mt-3">{{ $facility->name }}</h5>
                        <p class="facility-card-category">{{ $facility->category }}</p>
                    </div>
                </div>
                @empty
                <div class="col text-center">
                    <p>
                        @isset($category)
                        Belum ada peralatan dalam kategori <strong>{{ $category }}</strong>.
                        @else
                        Belum ada data peralatan yang ditambahkan.
                        @endisset
                    </p>
                </div>
                @endforelse
            </div>

            {{-- Link Paginasi --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $facilities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection