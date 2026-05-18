@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item active">Каталог</li>
            </ol>
        </nav>

        <h1 class="section-title mb-4">КАТАЛОГ ТОВАРОВ</h1>

        <div class="filter-card mb-5">
            <form method="GET" action="{{ route('catalog') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text"
                               class="form-control"
                               name="name"
                               placeholder="Поиск товара..."
                               value="{{ request('name') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <select class="form-select" name="category">
                            <option value="">Все категории</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}"
                                        {{ request('category') == $cat->name ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select class="form-select" name="animal_type">
                            <option value="">Все животные</option>
                            @foreach($animalTypes as $type)
                                <option value="{{ $type }}"
                                        {{ request('animal_type') == $type ? 'selected' : '' }}>
                                    @if($type == 'Все')
                                        Все виды
                                    @else
                                        {{ $type }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select class="form-select" name="sort">
                            <option value="popular" {{ request('sort') == 'popular' || !request('sort') ? 'selected' : '' }}>По популярности</option>
                            <option value="novelty" {{ request('sort') == 'novelty' ? 'selected' : '' }}>По новизне</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Название: А-Я</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Название: Я-А</option>
                            <option value="in_stock_desc" {{ request('sort') == 'in_stock_desc' ? 'selected' : '' }}>По наличию</option>
                        </select>
                    </div>
                    
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
                
                <div class="row g-3 mt-2 pt-3 border-top">
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" name="brand">
                            <option value="">Все бренды</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" name="age">
                            <option value="">Любой возраст</option>
                            @foreach($ages as $age)
                                <option value="{{ $age }}" {{ request('age') == $age ? 'selected' : '' }}>{{ $age }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> ФИЛЬТР
                        </button>
                    </div>
                </div>
                
                <div class="row g-3 mt-2 pt-3 border-top">
                    <div class="col-md-3">
                        <label class="form-label small">Мин. цена (₽)</label>
                        <input type="number" class="form-control form-control-sm" name="min_price" 
                               placeholder="От" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Макс. цена (₽)</label>
                        <input type="number" class="form-control form-control-sm" name="max_price" 
                               placeholder="До" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">&nbsp;</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="in_stock" value="1" 
                                   id="inStockCheck" {{ request('in_stock') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="inStockCheck">
                                Только в наличии
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <a href="{{ route('catalog') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="bi bi-x-circle"></i> СБРОСИТЬ
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Найдено товаров: <strong>{{ $products->count() }}</strong>
                @if(request('category'))
                    <span class="ms-2 badge" style="background: #20B2AA;">{{ request('category') }}</span>
                @endif
                @if(request('animal_type'))
                    <span class="ms-2 badge" style="background: #FF8C42;">{{ request('animal_type') }}</span>
                @endif
                @if(request('name'))
                    <span class="ms-2 badge bg-secondary">Поиск: {{ request('name') }}</span>
                @endif
            </div>
        </div>
        @endif

        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card-wrapper">
                        <div class="product-card">
                            @if($product->in_stock > 0)
                                <span class="badge-in-stock">В НАЛИЧИИ</span>
                            @else
                                <span class="badge-out-stock">ПОД ЗАКАЗ</span>
                            @endif

                            <div class="product-image-wrapper">
                                <img src="{{ asset($product->image) }}"
                                     class="product-img"
                                     alt="{{ $product->name }}"
                                     onerror="this.src='https://via.placeholder.com/300x300/FF8C42/ffffff?text={{ urlencode($product->name) }}'">
                            </div>

                            <div class="card-body">
                                <div class="category-label">{{ $product->category }}</div>
                                @if($product->animal_type)
                                    <span class="animal-type-badge">
                                        <i class="bi bi-heart"></i> {{ $product->animal_type }}
                                    </span>
                                @endif
                                <h5 class="card-title">
                                    <a href="{{ route('product', ['id' => $product->id]) }}" class="product-title-link">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                <div class="specs">
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $product->country }}
                                    </small>
                                </div>
                                <div class="price-section mt-3">
                                    <div class="price">{{ number_format($product->price, 0, '', ' ') }} ₽</div>
                                    @if($product->in_stock > 0)
                                        <button type="button" class="btn-add-to-cart" 
                                                data-product-id="{{ $product->id }}"
                                                title="Добавить в корзину">
                                            <i class="bi bi-cart-plus"></i>
                                            <span>В корзину</span>
                                        </button>
                                    @else
                                        <button class="btn-not-available" disabled>
                                            <i class="bi bi-x-circle"></i>
                                            <span>Нет в наличии</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($product->in_stock > 0)
                        <form method="POST" action="{{ route('add_buscket') }}" class="add-to-cart-form-hidden" id="form-{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h4>Товары не найдены</h4>
                <p class="text-muted">Попробуйте изменить параметры поиска</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary">СБРОСИТЬ ФИЛЬТРЫ</a>
            </div>
        @endif
    </div>
</main>

<style>
.animal-type-badge {
    display: inline-block;
    background: #FFF3E0;
    color: #FF8C42;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 4px;
    margin-bottom: 0.3rem;
}

.animal-type-badge i {
    font-size: 0.65rem;
}

.product-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(255, 140, 66, 0.15);
}

.product-image-wrapper {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
    background: #f8f9fa;
}

.product-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

.badge-in-stock {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #20B2AA, #17a589);
    color: #fff;
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.7rem;
    z-index: 10;
    text-transform: uppercase;
}

.badge-out-stock {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: #fff;
    padding: 0.4rem 0.75rem;
    border-radius: 6px;
    font-weight: 700;
    font-size: 0.7rem;
    z-index: 10;
    text-transform: uppercase;
}

.card-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.category-label {
    font-size: 0.75rem;
    color: #2D3436;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.3rem;
}

.card-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.product-title-link {
    color: #1a1a1a;
    text-decoration: none;
}

.price {
    font-size: 1.25rem;
    font-weight: 800;
    color: #FF8C42;
}

.btn-add-to-cart {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-add-to-cart:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(255, 140, 66, 0.4);
}

.btn-not-available {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #e0e0e0;
    border: none;
    border-radius: 8px;
    color: #999;
    cursor: not-allowed;
    font-weight: 600;
    font-size: 0.85rem;
}

.price-section {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
}

.filter-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.form-control:focus, .form-select:focus {
    border-color: #FF8C42;
    box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            const form = document.getElementById('form-' + productId);
            const originalContent = this.innerHTML;
            
            this.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Добавляем...</span>';
            this.disabled = true;
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('success', data.message);
                    this.innerHTML = '<i class="bi bi-check-circle"></i><span>Добавлено!</span>';
                    this.style.background = 'linear-gradient(135deg, #20B2AA, #17a589)';
                    
                    updateCartBadge();
                    
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.style.background = '';
                        this.disabled = false;
                    }, 700);
                } else {
                    showNotification('error', data.message);
                    this.innerHTML = originalContent;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'Произошла ошибка при добавлении в корзину');
                this.innerHTML = originalContent;
                this.disabled = false;
            });
        });
    });
    
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.btn-add-to-cart')) {
                const titleLink = this.querySelector('.product-title-link');
                if (titleLink) {
                    window.location.href = titleLink.href;
                }
            }
        });
    });
    
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `toast-notification toast-${type}`;
        notification.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    function updateCartBadge() {
        fetch('/api/cart/count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.cart-badge');
                if (badge) {
                    badge.textContent = data.count;
                }
            })
            .catch(error => console.error('Error updating cart badge:', error));
    }
});
</script>

<style>
.toast-notification {
    position: fixed;
    top: 80px;
    right: 20px;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 9999;
    transform: translateX(120%);
    transition: transform 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.toast-notification.show {
    transform: translateX(0);
}

.toast-success {
    background: linear-gradient(135deg, #20B2AA, #17a589);
}

.toast-error {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.toast-notification i {
    font-size: 1.3rem;
}
</style>
@endsection
