@extends('layouts.public')

@section('title', 'Blog - Klik Billiard')

@section('content')

<section class="page-header-v2" data-aos="fade-in">
    <div class="container">
        <h1>Blog & Artikel</h1>
        <p class="lead text-muted">Panduan, tips & trik, serta berita terbaru dari dunia biliar.</p>
    </div>
</section>

<div class="main-content">
    <div class="container py-5">
        <div class="row">
            @forelse ($articles as $article)
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="article-card-v2">
                    <a href="{{ route('blog.show', $article->slug) }}" class="d-block">
                        <div class="article-card-img-container">
                            @if($article->featured_image)
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                            @else
                            <img src="https://via.placeholder.com/400x250.png?text=Klik+Billiard" alt="Klik Billiard">
                            @endif
                            <div class="article-card-category">{{ $article->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="article-card-body">
                            <h5 class="article-card-title">{{ $article->title }}</h5>
                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col text-center">
                <p>Belum ada artikel yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection