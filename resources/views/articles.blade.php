@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active">Полезные статьи</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="section-title mb-1">ПОЛЕЗНЫЕ СТАТЬИ</h1>
                <p class="text-muted">Советы по уходу, кормлению и выбору товаров для ваших питомцев</p>
            </div>
        </div>

        @if($categories->count() > 0)
        <div class="mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('articles') }}" class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Все статьи
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('articles', ['category' => $cat]) }}" class="btn btn-sm {{ request('category') == $cat ? 'btn-primary' : 'btn-outline-secondary' }}">
                    {{ $cat }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($articles->count() > 0)
        <div class="row">
            @foreach($articles as $article)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="article-card">
                    <div class="article-image">
                        <img src="{{ asset($article->image ?? '/public/img/pet-shampoo.webp') }}" alt="{{ $article->title }}" onerror="this.src='https://via.placeholder.com/400x250/FF8C42/ffffff?text={{ urlencode($article->title) }}'">
                        @if($article->category)
                        <span class="article-category-badge">{{ $article->category }}</span>
                        @endif
                    </div>
                    <div class="article-body">
                        <h5 class="article-title">
                            <a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                        </h5>
                        <p class="article-excerpt">{{ Str::limit($article->excerpt, 120) }}</p>
                        <div class="article-footer">
                            <span class="article-date"><i class="bi bi-calendar3 me-1"></i>{{ date('d.m.Y', strtotime($article->created_at)) }}</span>
                            <a href="{{ route('article.show', $article->slug) }}" class="article-read-more">Читать <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $articles->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-journal-text display-1 text-muted mb-3"></i>
            <h4>Статьи не найдены</h4>
            <p class="text-muted">Скоро здесь появятся новые публикации</p>
        </div>
        @endif
    </div>
</main>

<style>
.article-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0,0,0,0.03);
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.article-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-image img {
    transform: scale(1.05);
}

.article-category-badge {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    color: #fff;
    padding: 0.3rem 0.8rem;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.7rem;
}

.article-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.article-title {
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.article-title a {
    color: var(--dark-color);
    text-decoration: none;
    transition: color 0.2s;
}

.article-title a:hover {
    color: #FF8C42;
}

.article-excerpt {
    color: #666;
    font-size: 0.85rem;
    line-height: 1.5;
    flex: 1;
}

.article-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
    margin-top: auto;
}

.article-date {
    font-size: 0.8rem;
    color: #999;
}

.article-read-more {
    color: #FF8C42;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.2s;
}

.article-read-more:hover {
    color: #e67a30;
    transform: translateX(3px);
}
</style>
@endsection
