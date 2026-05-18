@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Каталог</a></li>
                <li class="breadcrumb-item active">{{ $product[0]->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image mb-4">
                        <img src="{{ asset($product[0]->image) }}" 
                             class="img-fluid rounded" 
                             alt="{{ $product[0]->name }}"
                             id="mainImage"
                             onerror="this.src='https://via.placeholder.com/500x500/FF8C42/ffffff?text={{ urlencode($product[0]->name) }}'">
                    </div>
                    <div class="col-lg-12">
                        <div class="product-description-box">
                            <div class="col-12">
                                <div class="product-description">
                                    <h3 class="mb-4">ОПИСАНИЕ ТОВАРА</h3>
                                    <div class="description-content">
                                        <p>{{ $product[0]->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="product-info">
                    <div class="product-badges mb-3">
                        @if($product[0]->in_stock > 0)
                            <span class="badge bg-success me-2">В НАЛИЧИИ</span>
                        @else
                            <span class="badge bg-danger me-2">ПОД ЗАКАЗ</span>
                        @endif
                        <span class="badge" style="background: #20B2AA;">{{ $product[0]->category }}</span>
                        @if($product[0]->animal_type)
                            <span class="badge" style="background: #FF8C42;">{{ $product[0]->animal_type }}</span>
                        @endif
                    </div>

                    <h1 class="product-title mb-3">{{ $product[0]->name }}</h1>
                    
                    <div class="model mb-3">
                        <span class="text-muted">Модель:</span>
                        <strong>{{ $product[0]->model }}</strong>
                    </div>

                    <div class="price-section mb-4">
                        <div class="price">{{ number_format($product[0]->price, 0, '', ' ') }} ₽</div>
                    </div>

                    <div class="specs-card mb-4">
                        <h5 class="mb-3">ХАРАКТЕРИСТИКИ</h5>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <strong>Страна:</strong> {{ $product[0]->country }}
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Год:</strong> {{ $product[0]->year }}
                            </div>
                            <div class="col-6 mb-2">
                                <strong>В наличии:</strong> {{ $product[0]->in_stock }} шт.
                            </div>
                            <div class="col-6 mb-2">
                                <strong>Категория:</strong> {{ $product[0]->category }}
                            </div>
                            @if($product[0]->animal_type)
                            <div class="col-6 mb-2">
                                <strong>Для:</strong> {{ $product[0]->animal_type }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="add-to-cart-card">
                        <div class="mb-4">
                            <label class="form-label">КОЛИЧЕСТВО:</label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" 
                                       class="quantity-input" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product[0]->in_stock }}">
                                <button type="button" class="quantity-btn" onclick="changeQuantity(1)">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted">Доступно: {{ $product[0]->in_stock }} шт.</small>
                        </div>

                        <div class="d-grid gap-3">
                            @if($product[0]->in_stock > 0)
                                <form method="POST" action="{{ route('add_buscket') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product[0]->id }}">
                                    <input type="hidden" name="quantity" id="quantityValue" value="1">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-cart-plus me-2"></i>ДОБАВИТЬ В КОРЗИНУ
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="bi bi-cart-x me-2"></i>НЕТ В НАЛИЧИИ
                                </button>
                            @endif
                            <a href="{{ route('catalog') }}" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>ВЕРНУТЬСЯ В КАТАЛОГ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                @if(session('success'))
                    <div class="notification-success mb-3">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="notification-error mb-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="col-lg-12">
                <div class="reviews-header-section mb-4">
                    <h3 class="reviews-main-title">Отзывы покупателей</h3>
                    
                    @if($reviews->count() > 0)
                        <div class="reviews-summary-box">
                            <span class="reviews-total-count">
                                {{ $reviews->count() }} {{ trans_choice('отзыв|отзыва|отзывов', $reviews->count()) }}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="reviews-sidebar">
                    <div class="reviews-list">
                        @forelse($reviews as $review)
                            <div class="review-item mb-3">
                                <div class="review-header">
                                    <div class="user-avatar-small">
                                        {{ mb_strtoupper(mb_substr($review->user_name, 0, 1, 'UTF-8'), 'UTF-8') }}
                                    </div>
                                    <div class="user-info">
                                        <h6 class="user-name-small mb-0">{{ $review->user_name }}</h6>
                                        <div class="review-rating-small">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <span class="star-filled-small">★</span>
                                                @else
                                                    <span class="star-empty-small">☆</span>
                                                @endif
                                            @endfor
                                            <span class="rating-value-small">{{ $review->rating }}/5</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="review-text-small mt-2 mb-2">{{ Str::limit($review->review_text, 80) }}</p>
                                <div class="review-footer-small">
                                    <span class="review-date-small">{{ $review->created_at }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="no-reviews-small">
                                <i class="bi bi-chat-square-text"></i>
                                <p>Пока нет отзывов</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @auth
                        <div class="text-center mt-4">
                            <button type="button" class="open-review-form-btn" id="openReviewFormBtn">
                                <i class="bi bi-pencil-square me-2"></i>Оставить отзыв
                            </button>
                        </div>
                        
                        <div class="review-form-sidebar mt-3" id="reviewFormSidebar" style="display: none;">
                            <form action="{{ route('product.review', $product[0]->id) }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label-sm">Оценка *</label>
                                    <div class="stars-sidebar">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" 
                                                   name="rating" 
                                                   id="sidebarStar{{ $i }}" 
                                                   value="{{ $i }}" 
                                                   class="star-radio-sidebar"
                                                   required>
                                            <label for="sidebarStar{{ $i }}" class="star-label-sidebar">★</label>
                                        @endfor
                                    </div>
                                    <div class="rating-text-sidebar">
                                        <span id="sidebarRatingText">Выберите оценку</span>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="review_text" class="form-label-sm">Текст отзыва *</label>
                                    <textarea class="form-control form-control-sm" 
                                              id="review_text_sidebar" 
                                              name="review_text" 
                                              rows="3" 
                                              required
                                              placeholder="Ваш отзыв..."></textarea>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="closeReviewFormSidebar">
                                        Отмена
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Отправить
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="auth-notice-small mt-3">
                            <a href="{{ route('login') }}" class="login-link-small">Войдите</a>, чтобы оставить отзыв
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="specifications-card">
                    <h3 class="mb-4">ТЕХНИЧЕСКИЕ ХАРАКТЕРИСТИКИ</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="30%"><strong>Производитель</strong></td>
                                    <td>{{ $product[0]->country }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Год выпуска</strong></td>
                                    <td>{{ $product[0]->year }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Модель</strong></td>
                                    <td>{{ $product[0]->model }}</td>
                                </tr>
                                @if($product[0]->animal_type)
                                <tr>
                                    <td><strong>Для животных</strong></td>
                                    <td>{{ $product[0]->animal_type }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Вес</strong></td>
                                    <td>Стандартный</td>
                                </tr>
                                <tr>
                                    <td><strong>Материал</strong></td>
                                    <td>Высококачественный</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.product-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--dark-color);
}

.price-section .price {
    font-size: 2.5rem;
    font-weight: 900;
    color: #FF8C42;
}

.specs-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.specs-card h5 {
    color: var(--dark-color);
    font-weight: 700;
}

.add-to-cart-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0;
    max-width: 150px;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    background: #f0f0f0;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
}

.quantity-btn:first-child {
    border-radius: 8px 0 0 8px;
}

.quantity-btn:last-child {
    border-radius: 0 8px 8px 0;
}

.quantity-btn:hover {
    background: #FF8C42;
    color: #fff;
    border-color: #FF8C42;
}

.quantity-input {
    width: 60px;
    height: 40px;
    text-align: center;
    border: 1px solid #ddd;
    border-left: none;
    border-right: none;
    font-weight: 700;
    font-size: 1rem;
}

.quantity-input:focus {
    outline: none;
    border-color: #FF8C42;
}

.product-description-box {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.product-description h3 {
    font-weight: 700;
    color: var(--dark-color);
}

.description-content {
    color: #555;
    line-height: 1.8;
}

.specifications-card {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.specifications-card h3 {
    font-weight: 700;
    color: var(--dark-color);
}

.table tbody td {
    padding: 1rem;
    border-color: #f0f0f0;
}

.notification-success {
    background: #d4edda;
    color: #155724;
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
}

.notification-error {
    background: #f8d7da;
    color: #721c24;
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
}

.reviews-header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.reviews-main-title {
    font-weight: 700;
    color: var(--dark-color);
}

.review-item {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.review-header {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar-small {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
}

.star-filled-small {
    color: #f39c12;
}

.star-empty-small {
    color: #ddd;
}

.open-review-form-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.open-review-form-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
}

.stars-sidebar {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 4px;
}

.star-radio-sidebar {
    display: none;
}

.star-label-sidebar {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.star-radio-sidebar:checked ~ .star-label-sidebar,
.star-label-sidebar:hover,
.star-label-sidebar:hover ~ .star-label-sidebar {
    color: #f39c12;
}

.main-image img {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
</style>

<script>
function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    let value = parseInt(input.value);

    value += change;

    if (value < 1) value = 1;
    if (value > max) value = max;

    input.value = value;
    document.getElementById('quantityValue').value = value;
}

const quantityInput = document.getElementById('quantity');
if (quantityInput) {
    quantityInput.addEventListener('input', function() {
        let value = parseInt(this.value);
        const max = parseInt(this.max);
        if (value < 1) value = 1;
        if (value > max) value = max;
        this.value = value;
        document.getElementById('quantityValue').value = value;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('openReviewFormBtn');
    const closeBtn = document.getElementById('closeReviewFormSidebar');
    const reviewForm = document.getElementById('reviewFormSidebar');
    
    if (openBtn && reviewForm) {
        openBtn.addEventListener('click', function() {
            reviewForm.style.display = 'block';
            openBtn.style.display = 'none';
        });
    }
    
    if (closeBtn && reviewForm && openBtn) {
        closeBtn.addEventListener('click', function() {
            reviewForm.style.display = 'none';
            openBtn.style.display = 'block';
        });
    }
    
    const sidebarStars = document.querySelectorAll('.star-radio-sidebar');
    const sidebarRatingText = document.getElementById('sidebarRatingText');
    
    if (sidebarStars.length > 0 && sidebarRatingText) {
        const ratingTexts = {
            1: "Ужасно",
            2: "Плохо",
            3: "Нормально",
            4: "Хорошо",
            5: "Отлично"
        };
        
        sidebarStars.forEach(star => {
            star.addEventListener('change', function() {
                const rating = this.value;
                sidebarRatingText.textContent = ratingTexts[rating] + ` (${rating}/5)`;
            });
        });
    }
});
</script>
@endsection
