@extends('layouts.public')

@section('title', 'Menu Makanan & Minuman - Klik Billiard')

@section('content')

{{-- Page Header v2 --}}
<section class="page-header-v2">
    <div class="container" data-aos="fade-up">
        <h1>Our Signature Menu</h1>
        <p class="lead text-muted">Dibuat dengan bahan-bahan terbaik untuk menemani permainan Anda.</p>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        {{-- Looping untuk setiap kategori --}}
        @forelse ($groupedMenuItems as $category => $items)
        <section class="menu-section" data-aos="fade-up">
            <h2 class="menu-category-title-v2">{{ $category }}</h2>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    {{-- Looping untuk setiap item di dalam kategori --}}
                    @foreach ($items as $item)
                    <div class="menu-list-item-v2">
                        {{-- KOLOM GAMBAR (BARU) --}}
                        @if($item->image)
                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="menu-item-image">
                        @endif

                        {{-- KOLOM UTAMA (NAMA, GARIS, HARGA) --}}
                        <div class="menu-item-main" style="{{ !$item->image ? 'width: 100%;' : '' }}">
                            <div class="details">
                                <p class="name">{{ $item->name }}</p>
                                <p class="description">{{ $item->description }}</p>
                            </div>
                            <div class="line"></div>
                            <div class="price">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @empty
        <div class="col text-center py-5">
            <p>Menu belum tersedia. Silakan cek kembali nanti.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection