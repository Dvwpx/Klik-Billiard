@extends('layouts.public')

@section('title', 'Fasilitas & Peralatan - Klik Billiard')

@section('content')

{{-- Page Header v2 --}}
<section class="page-header-v2 mb-4">
    <div class="container" data-aos="fade-up">
        <h1>Fasilitas & Peralatan</h1>
        <p class="lead text-muted">Kami hanya menyediakan yang terbaik untuk pengalaman bermain Anda.</p>
    </div>
</section>

{{-- Bagian Fasilitas Umum (Desain Baru) --}}
<section class="amenities-list-section pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
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
</section>

<div class="main-content">
    <section class="equipment-showcase py-5">
        <div class="container">
            <h2 class="text-center text-white mb-5" data-aos="fade-up">Peralatan Dan Perlengkapan</h2>

            @forelse ($facilities as $index => $facility)
            <div class="row align-items-center mb-5 flex-lg-row{{ $index % 2 == 1 ? '-reverse' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                {{-- Gambar --}}
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="equipment-image-wrapper rounded overflow-hidden shadow">
                        @if($facility->image)
                        <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="img-fluid equipment-image">
                        @else
                        <img src="https://via.placeholder.com/800x500?text=Gambar+Peralatan" alt="Image" class="img-fluid equipment-image">
                        @endif
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="col-lg-6 text-white">
                    <h3 class="equipment-title">{{ $facility->name }}</h3>
                    <p class="text-muted">{{ $facility->category }}</p>
                    <p class="equipment-description mt-3">Peralatan ini digunakan untuk menunjang permainan billiard secara profesional. Detail tambahan bisa dimasukkan di sini sesuai kebutuhan Anda.</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">Belum ada data peralatan yang ditampilkan.</p>
            @endforelse
        </div>
    </section>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>