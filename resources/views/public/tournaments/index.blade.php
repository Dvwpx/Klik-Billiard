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
                    <div class="tournament-card">
<div class="tournament-image" style="background-image: url('{{ $tournament->poster_image ?? 'https://via.placeholder.com/400x500.png?text=Event' }}');"></div>
                        <div class="tournament-overlay"></div>
                        <div class="tournament-content">
                            <span class="tournament-status status-{{ strtolower(str_replace(' ', '-', $tournament->status)) }}">{{ $tournament->status }}</span>
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

<style>
    .tournament-card {
        position: relative;
        height: 400px;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .tournament-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .tournament-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .tournament-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        z-index: 1;
    }

    .tournament-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 25px;
        z-index: 2;
        color: white;
    }

    .tournament-status {
        display: inline-block;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    /* Status: Akan Datang */
    .tournament-status.status-akan-datang {
        background: red;
    }

    /* Status: Sedang Berlangsung */
    .tournament-status.status-sedang-berlangsung {
        background: orange;
    }

    /* Status: Sudah Selesai */
    .tournament-status.status-sudah-selesai,
    .tournament-status.status-selesai {
        background: #16ff24ba;
    }

    /* Status: Registrasi Dibuka */
    .tournament-status.status-registrasi-dibuka {
        background: linear-gradient(45deg, #f39c12, #e67e22);
    }

    /* Status: Registrasi Ditutup */
    .tournament-status.status-registrasi-ditutup {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
    }

    /* Fallback untuk status lainnya */
    .tournament-status {
        background: linear-gradient(45deg, #ff6b6b, #ee5a24);
    }

    .tournament-name {
        color: white;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 8px;
        line-height: 1.3;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .tournament-date {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .tournament-card {
            height: 300px;
        }

        .tournament-content {
            padding: 20px;
        }

        .tournament-name {
            font-size: 1.1rem;
        }

        .tournament-date {
            font-size: 0.9rem;
        }
    }
</style>

@endsection