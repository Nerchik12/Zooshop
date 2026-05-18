@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('articles') }}">Полезные статьи</a></li>
                <li class="breadcrumb-item active">{{ $article->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <article class="article-detail">
                    @if($article->image)
                    <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="img-fluid rounded-4 mb-4 w-100" style="max-height: 400px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/800x400/FF8C42/ffffff?text={{ urlencode($article->title) }}'">
                    @endif

                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if($article->category)
                        <span class="badge" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B); font-size: 0.8rem; padding: 6px 14px;">{{ $article->category }}</span>
                        @endif
                        <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i>{{ date('d.m.Y', strtotime($article->created_at)) }}</span>
                    </div>

                    <h1 class="fw-bold mb-4" style="color: var(--dark-color); font-size: 1.8rem;">{{ $article->title }}</h1>

                    <div class="article-content" style="font-size: 1rem; line-height: 1.8; color: #444;">
                        {!! $article->body !!}
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-card mb-4">
                    <div class="sidebar-card-header">
                        <h5>ДРУГИЕ СТАТЬИ</h5>
                    </div>
                    <div class="sidebar-card-body">
                        @foreach($recentArticles as $recent)
                        <a href="{{ route('article.show', $recent->slug) }}" class="recent-article-item">
                            <div class="recent-article-title">{{ $recent->title }}</div>
                            <small class="text-muted">{{ date('d.m.Y', strtotime($recent->created_at)) }}</small>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-card">
                    <div class="sidebar-card-header" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B);">
                        <h5 style="color: #fff;">НУЖНА ПОМОЩЬ?</h5>
                    </div>
                    <div class="sidebar-card-body text-center">
                        <p class="text-muted small">Наши консультанты помогут с выбором</p>
                        <a href="tel:84957654321" class="btn" style="background: linear-gradient(135deg, #20B2AA, #17a589); color: #fff; border-radius: 50px; padding: 10px 24px; font-weight: 600; font-size: 0.85rem;">
                            <i class="bi bi-telephone me-2"></i>+7 (495) 765-43-21
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.article-detail {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.article-content h3 {
    font-weight: 700;
    color: var(--dark-color);
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-size: 1.25rem;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content ul, .article-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.sidebar-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.sidebar-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f0f0f0;
}

.sidebar-card-header h5 {
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
    font-size: 0.9rem;
}

.sidebar-card-body {
    padding: 1rem 1.25rem;
}

.recent-article-item {
    display: block;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f5f5f5;
    text-decoration: none;
    transition: all 0.2s;
}

.recent-article-item:last-child {
    border-bottom: none;
}

.recent-article-item:hover {
    padding-left: 5px;
}

.recent-article-title {
    font-weight: 600;
    color: var(--dark-color);
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
    transition: color 0.2s;
}

.recent-article-item:hover .recent-article-title {
    color: #FF8C42;
}
</style>
@endsection
