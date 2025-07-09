@extends('layouts.public')

@section('title', $article->title)

@section('content')

<section class="article-hero" data-aos="fade-in">
    <div class="article-hero-bg" style="background-image: url('{{ $article->featured_image ?? 'https://via.placeholder.com/1920x800.png?text=Klik+Billiard' }}');"></div>
    <div class="article-hero-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="article-hero-content" data-aos="fade-up">
                    <h1>{{ $article->title }}</h1>
                    <div class="meta mt-3">
                        <span>Oleh: {{ $article->user->name }}</span> |
                        <span>Tanggal: {{ $article->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container article-body">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="article-content">
                    {!! $article->content !!}
                </article>
                <hr class="my-5" style="border-color: #333;">
                @if($relatedArticles->count() > 0)
                <section class="related-articles-section" data-aos="fade-up">
                    <h2 class="section-title text-center">ARTIKEL TERKAIT</h2>
                    <div class="row mt-4">
                        @foreach ($relatedArticles as $related)
                        <div class="col-md-4 mb-4">
                            <div class="article-card-v2">
                                <a href="{{ route('blog.show', $related->slug) }}" class="d-block">
                                    <div class="article-card-img-container" style="height: 180px;">
                                        <img src="{{ $related->featured_image ?? 'https://via.placeholder.com/400x250.png?text=Klik+Billiard' }}" alt="{{ $related->title }}">
                                    </div>
                                    <div class="article-card-body">
                                        <h5 class="article-card-title" style="font-size: 1rem;">{{ Str::limit($related->title, 55) }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection