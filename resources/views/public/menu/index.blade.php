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

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #1a1a1a;
        color: white;
        margin: 0;
        padding: 20px;
    }

    .menu-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .menu-title {
        text-align: center;
        font-size: 2.5rem;
        color: #d4af37;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .menu-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
        padding: 15px;
        background-color: #2a2a2a;
        border-radius: 10px;
        gap: 15px;
    }

    .menu-item-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .menu-item-main {
        display: flex;
        flex: 1;
        align-items: flex-start;
        gap: 15px;
        min-width: 0;
        /* Penting untuk memungkinkan flex item menyusut */
    }

    .details {
        flex: 1;
        min-width: 0;
        /* Penting untuk text wrapping */
        bottom: 43px;
        position: relative;
    }

    .name {
        font-size: 1.3rem;
        font-weight: bold;
        margin: 0 0 8px 0;
        color: white;
    }

    .description {
        font-size: 0.95rem;
        color: #cccccc;
        margin: 0;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .line {
        width: 2px;
        height: 60px;
        background-color: #555;
        flex-shrink: 0;
    }

    .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #d4af37;
        white-space: nowrap;
        flex-shrink: 0;
        min-width: 100px;
        text-align: right;
    }

    /* Responsive design untuk mobile */
    @media (max-width: 768px) {
        .menu-item-main {
            flex-direction: column;
            gap: 10px;
        }

        .line {
            display: none;
        }

        .price {
            text-align: left;
            align-self: flex-start;
        }
    }

    /* /*details price dll */
      @media (max-width: 767.98px) {

        .details {
            bottom: 10px;
        }
    }

    /* Large screens (1200px and up) */
    @media (min-width: 1200px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 1.4rem;
        }
    }

    /* Medium screens (992px to 1199px) */
    @media (max-width: 1199.98px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 1.2rem;
        }
    }

    /* Small screens (768px to 991px) - Tablet Portrait */
    @media (max-width: 991.98px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 1.1rem;
            margin-left: 0.5rem;
        }

        /* Adjust menu item layout for tablet */
        .menu-list-item-v2,
        .menu-item-final {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .menu-list-item-v2 .menu-item-main,
        .menu-item-final .details-wrapper {
            width: 100%;
            justify-content: space-between;
        }

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            margin-left: 0;
            align-self: flex-end;
        }
    }

    /* Extra small screens (576px to 767px) - Mobile Landscape */
    @media (max-width: 767.98px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 1rem;
            font-weight: 600;
        }

        /* Stack layout untuk mobile */
        .menu-list-item-v2,
        .menu-item-final {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 1rem;
            background: var(--dark-grey);
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .menu-list-item-v2 .menu-item-image,
        .menu-item-final .menu-item-image {
            width: 100%;
            height: 150px;
            border-radius: 8px;
            object-fit: cover;
        }

        .menu-list-item-v2 .menu-item-main,
        .menu-item-final .details-wrapper {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            text-align: center;
            padding: 8px 7;
            background: rgba(247, 184, 1, 0.1);
            border-radius: 10px;
            border: 1px solid var(--secondary-color);
            margin-left: 0;
        }
    }

    /* Small mobile screens (480px to 575px) */
    @media (max-width: 575.98px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 0.95rem;
            padding: 10px 0;
        }

        .menu-list-item-v2 .menu-item-image,
        .menu-item-final .menu-item-image {
            height: 120px;
        }

        /* Full width card style untuk mobile kecil */
        .menu-list-item-v2,
        .menu-item-final {
            margin-left: -15px;
            margin-right: -15px;
            border-radius: 2rem;
            border-left: none;
            border-right: none;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }
    }

    /* Extra small mobile screens (375px to 479px) */
    @media (max-width: 479.98px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 0.9rem;
            padding: 8px 0;
        }

        .menu-list-item-v2 .details .name,
        .menu-item-final .name {
            font-size: 1rem;
        }

        .menu-list-item-v2 .details .description,
        .menu-item-final .description {
            font-size: 0.85rem;
        }

        .menu-list-item-v2 .menu-item-image,
        .menu-item-final .menu-item-image {
            height: 100px;
        }
    }

    /* Very small screens (320px to 374px) */
    @media (max-width: 374.98px) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            font-size: 0.85rem;
            padding: 6px 0;
        }

        .menu-list-item-v2 .details .name,
        .menu-item-final .name {
            font-size: 0.95rem;
        }

        .menu-list-item-v2 .details .description,
        .menu-item-final .description {
            font-size: 0.8rem;
        }

        .menu-list-item-v2,
        .menu-item-final {
            padding: 0.75rem;
            gap: 10px;
        }

        .menu-list-item-v2 .menu-item-image,
        .menu-item-final .menu-item-image {
            height: 80px;
        }
    }

    /* ===================================================================
   RESPONSIVE UNTUK PRICE DI CARD LAINNYA
   =================================================================== */

    /* Tournament card price responsive */
    .tournament-card .tournament-price {
        font-family: var(--heading-font);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    @media (max-width: 767.98px) {
        .tournament-card .tournament-price {
            font-size: 1rem;
        }
    }

    @media (max-width: 479.98px) {
        .tournament-card .tournament-price {
            font-size: 0.9rem;
        }
    }

    /* Location card price responsive */
    .location-card-price {
        font-family: var(--heading-font);
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--secondary-color);
    }

    @media (max-width: 767.98px) {
        .location-card-price {
            font-size: 1rem;
        }
    }

    @media (max-width: 479.98px) {
        .location-card-price {
            font-size: 0.9rem;
        }
    }

    /* ===================================================================
   UTILITIES UNTUK PRICE FORMATTING
   =================================================================== */

    /* Price highlight effect */
    .price-highlight {
        animation: priceGlow 2s ease-in-out infinite alternate;
    }

    @keyframes priceGlow {
        from {
            text-shadow: 0 0 5px rgba(247, 184, 1, 0.5);
        }

        to {
            text-shadow: 0 0 15px rgba(247, 184, 1, 0.8);
        }
    }

    /* Price with currency symbol */
    .price-with-currency::before {
        content: "Rp ";
        font-size: 0.9em;
        opacity: 0.8;
    }

    /* Discount price styling */
    .price-original {
        text-decoration: line-through;
        color: var(--text-color);
        font-size: 0.9em;
        opacity: 0.7;
    }

    .price-discounted {
        color: #ff4757;
        font-weight: 800;
    }

    /* Price badge untuk mobile */
    @media (max-width: 767.98px) {
        .price-badge {
            display: inline-block;
            background: linear-gradient(45deg, var(--secondary-color), #ffc72c);
            color: #000;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 700;
            box-shadow: 0 2px 10px rgba(247, 184, 1, 0.3);
        }
    }

    /* ===================================================================
   DARK MODE ADJUSTMENTS UNTUK PRICE
   =================================================================== */

    @media (prefers-color-scheme: dark) {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            color: var(--secondary-color);
            text-shadow: 0 0 10px rgba(247, 184, 1, 0.3);
        }
    }

    /* ===================================================================
   PRINT STYLES UNTUK PRICE
   =================================================================== */

    @media print {

        .menu-list-item-v2 .price,
        .menu-item-final .price {
            color: #000 !important;
            background: transparent !important;
            border: 1px solid #000 !important;
            font-size: 12pt !important;
        }
</style>