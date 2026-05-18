@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active">Акции</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="section-title mb-1">
                    <i class="bi bi-lightning-charge" style="color: #FF6B6B;"></i> АКЦИИ И СКИДКИ
                </h1>
                <p class="text-muted">Специальные предложения и товары со скидкой</p>
            </div>
        </div>

        @if($products->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="promo-banner p-4 rounded-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: linear-gradient(135deg, #FF6B6B, #ee5a24);">
                    <div>
                        <h3 class="fw-bold text-white mb-1">Скидки до 30%!</h3>
                        <p class="text-white mb-0" style="opacity: 0.9;">Торопитесь — предложение ограничено</p>
                    </div>
                    <span class="badge bg-white" style="color: #FF6B6B; font-size: 1rem; padding: 10px 24px;">{{ $products->count() }} товаров</span>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="sale-product-card">
                    @php
                        $discount = round((1 - $product->price / $product->old_price) * 100);
                    @endphp
                    <div class="discount-flag">-{{ $discount }}%</div>
                    <div class="sale-image-wrapper">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/300x300/FF6B6B/ffffff?text={{ urlencode($product->name) }}'">
                    </div>
                    <div class="sale-card-body">
                        <div class="category-label">{{ $product->category }}</div>
                        <h5 class="sale-card-title">
                            <a href="{{ route('product', ['id' => $product->id]) }}">{{ $product->name }}</a>
                        </h5>
                        <div class="sale-price-row">
                            <div class="sale-price">{{ number_format($product->price, 0, '', ' ') }} ₽</div>
                            <div class="old-price">{{ number_format($product->old_price, 0, '', ' ') }} ₽</div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted"><i class="bi bi-heart me-1" style="color: #FF6B6B;"></i>{{ $product->animal_type ?? 'Все' }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-gift display-1 text-muted mb-3"></i>
            <h4>Акций пока нет</h4>
            <p class="text-muted">Следите за обновлениями — скоро появятся новые предложения!</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary mt-2">В КАТАЛОГ</a>
        </div>
        @endif
    </div>
</main>

<style>
.promo-banner {
    position: relative;
    overflow: hidden;
}

.promo-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: rgba(255,255,255,0.05);
    transform: rotate(45deg);
}

.sale-product-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    border: 1px solid rgba(0,0,0,0.03);
}

.sale-product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(255, 107, 107, 0.15);
}

.discount-flag {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #FF6B6B, #ee5a24);
    color: #fff;
    padding: 0.4rem 0.75rem;
    border-radius: 8px;
    font-weight: 800;
    font-size: 0.9rem;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
}

.sale-image-wrapper {
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.sale-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.sale-product-card:hover .sale-image-wrapper img {
    transform: scale(1.05);
}

.sale-card-body {
    padding: 1.25rem;
}

.category-label {
    font-size: 0.7rem;
    color: #2D3436;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.3rem;
}

.sale-card-title {
    font-size: 0.9rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.sale-card-title a {
    color: var(--dark-color);
    text-decoration: none;
}

.sale-card-title a:hover {
    color: #FF8C42;
}

.sale-price-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sale-price {
    font-size: 1.25rem;
    font-weight: 800;
    color: #FF6B6B;
}

.old-price {
    font-size: 0.9rem;
    color: #999;
    text-decoration: line-through;
}
</style>
@endsection
