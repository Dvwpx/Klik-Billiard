@extends('layouts.public')

@section('title', $location->name . ' - Klik Billiard')

@section('content')

{{-- Location Detail Hero --}}
<section class="location-detail-hero" data-aos="fade-in">
    <div class="hero-bg" style="background-image: url('{{ $location->featured_image ? asset('storage/' . $location->featured_image) : 'https://via.placeholder.com/1920x800.png?text=Klik+Billiard' }}');"></div>
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
            <h1>{{ $location->name }}</h1>
            <p class="location-city"><i class="ti-location-pin"></i>{{ $location->city }}</p>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            {{-- Kolom Kiri - Deskripsi --}}
            <div class="col-lg-7" data-aos="fade-right">
                <div class="description-box">
                    <h2>Tentang Lokasi</h2>
                    <p style="white-space: pre-wrap;">{{ $location->description }}</p>

                    <h2 class="mt-5">Fasilitas Unggulan</h2>
                    {{-- Nanti bagian ini akan kita isi dengan data fasilitas yang terhubung ke lokasi ini --}}
                    <p class="text-muted"><i>Fitur daftar fasilitas di lokasi ini akan segera hadir.</i></p>
                </div>
            </div>

            {{-- Kolom Kanan - Info & Peta (Sticky) --}}
            <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                <div class="sticky-sidebar">
                    <div class="info-card">
                        <h4>Informasi Kontak</h4>
                        <div class="info-item">
                            <i class="ti-map-alt"></i>
                            <span>{{ $location->address }}</span>
                        </div>
                        @if($location->phone_number)
                        <div class="info-item">
                            <i class="ti-mobile"></i>
                            <span>{{ $location->phone_number }}</span>
                        </div>
                        @endif
                        <div class="info-item">
                            <i class="ti-info-alt"></i>
                            <span>Status: <span class="badge badge-success">{{ $location->status }}</span></span>
                        </div>
                    </div>
                    <div class="info-card">
                    {{-- KONDISI IF YANG DIPERBAIKI --}}
                    <h4>Peta Lokasi</h4>
                    @if(is_numeric($location->latitude) && is_numeric($location->longitude))
                    <div id="map" style="height: 300px; width: 100%;"></div>
                    @else
                    <p>Koordinat peta tidak valid atau tidak tersedia.</p>
                    @endif
                </div>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <a href="{{ route('locations.public.index') }}" class="btn btn-outline-light"> &laquo; Kembali ke Semua Lokasi</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(is_numeric($location->latitude) && is_numeric($location->longitude))
<script>
    // FUNGSI INI MEMASTIKAN SCRIPT PETA DIJALANKAN SETELAH SEMUA HALAMAN SIAP
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi peta dan atur view ke koordinat lokasi dengan zoom 15
        var lat = {{ $location->latitude }};
        var lng = {{ $location->longitude }};
        var map = L.map('map').setView([lat, lng], 15);

        // Tambahkan layer tile dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Tambahkan marker (penanda) di lokasi
        var marker = L.marker([lat, lng]).addTo(map);

        // Tambahkan popup pada marker
        marker.bindPopup("<b>{{ $location->name }}</b>").openPopup();
    });
</script>
@endif
@endpush