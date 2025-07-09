@extends('layouts.public')

@section('title', $location->name . ' - Detail & Galeri')

@section('content')

{{-- Hero Section dengan gambar utama lokasi --}}
<section class="article-hero" data-aos="fade-in">
<div class="article-hero-bg" style="background-image: url('{{ $location->featured_image ? $location->featured_image : 'https://via.placeholder.com/1920x800.png?text=Klik+Billiard' }}');"></div>
    <div class="article-hero-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="article-hero-content" data-aos="fade-up">
                    <p class="subtitle" style="color: var(--secondary-color); font-weight: 700; letter-spacing: 2px;">Lokasi Kami</p>
                    <h1>{{ $location->address }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container location-detail-body">
        <div class="row">
            {{-- Kolom Kiri - Deskripsi & Peta --}}
            <div class="col-lg-7" data-aos="fade-right">
    <h2 class="location-detail-title">Lokasi Kami</h2>
    <p class="location-detail-address">{{ $location->address }}, {{ $location->city }}</p>
    <hr style="border-color: #444;">
    <div class="article-content">
        <p>{{ $location->description }}</p>
    </div>
</div>

{{-- Kolom Kanan - Peta (Ganti dari Fasilitas) --}}
<div class="col-lg-5" data-aos="fade-left" data-aos-delay="100">
    <div class="sticky-sidebar">
        <div class="info-card">
            <h4>Peta Lokasi</h4>
            @if(is_numeric($location->latitude) && is_numeric($location->longitude))
            <div id="map-detail" style="height: 400px; border-radius: 15px; border: 1px solid var(--border-color);"></div>
            @else
            <p class="text-muted">Koordinat lokasi tidak tersedia.</p>
            @endif
        </div>
    </div>
</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Script untuk Peta di Halaman Detail --}}
@if(is_numeric($location->latitude) && is_numeric($location->longitude))
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var lat = {{ $location->latitude }};
        var lng = {{ $location->longitude }};
        var map = L.map('map-detail', {center: [lat, lng], zoom: 17, scrollWheelZoom: false});
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '© OpenStreetMap'}).addTo(map);
        var marker = L.marker([lat, lng]).addTo(map).bindPopup("<b>{{ $location->name }}</b>").openPopup();
    });
</script>
@endif
@endpush