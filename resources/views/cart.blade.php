@extends('layouts.app')

@section('content')
<main>
    <div class="container py-5">
        <div class="cart-header mb-5">
            <h1 class="section-title">
                <i class="bi bi-cart3 me-3"></i>КОРЗИНА
            </h1>
            <p class="text-muted">Товары в вашей корзине</p>
        </div>

        @if($cart->count() == 0)
            <div class="empty-cart text-center py-5">
                <div class="empty-icon mb-4">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                </div>
                <h3 class="mb-3">КОРЗИНА ПУСТА</h3>
                <p class="text-muted mb-4">Добавьте товары из каталога, чтобы сделать заказ</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>ПЕРЕЙТИ В КАТАЛОГ
                </a>
            </div>
        @else
            <div class="row">
                <div class="col-xl-8">
                    <div class="cart-items-card mb-4">
                        <div class="cart-items-header p-4">
                            <h5 class="mb-0">ТОВАРЫ В КОРЗИНЕ ({{ $cart->count() }})</h5>
                        </div>
                        <div class="cart-items-body p-0">
                            @foreach($cart as $item)
                            <div class="cart-item-row">
                                <div class="row align-items-center">
                                    <div class="col-4 col-md-2">
                                        <div class="cart-item-image">
                                            <img src="{{ asset($item->image) }}"
                                                 alt="{{ $item->name }}"
                                                 class="img-fluid rounded"
                                                 onerror="this.src='https://via.placeholder.com/150x150/FF8C42/ffffff?text={{ urlencode($item->name) }}'">
                                        </div>
                                    </div>

                                    <div class="col-8 col-md-4">
                                        <h6 class="cart-item-name mb-1">
                                            <a href="{{ route('product', ['id' => $item->product_id]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </h6>
                                        <p class="text-muted small mb-1">{{ $item->model }}</p>
                                        @if($item->in_stock > 0)
                                            <span class="badge" style="background: #20B2AA;">В наличии</span>
                                        @else
                                            <span class="badge bg-secondary">Нет в наличии</span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mt-3 mt-md-0">
                                        <div class="quantity-controls-modern">
                                            @if($item->count > 1)
                                                <form method="POST" action="{{ route('update.quantity') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="cart_id" value="{{ $item->cart_id }}">
                                                    <input type="hidden" name="count" value="{{ $item->count - 1 }}">
                                                    <button type="submit" class="quantity-btn-modern">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('remove') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="cart_id" value="{{ $item->cart_id }}">
                                                    <button type="submit" class="quantity-btn-modern btn-remove-modern" title="Удалить товар">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <span class="quantity-display">{{ $item->count }} шт.</span>

                                            <form method="POST" action="{{ route('update.quantity') }}" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{ $item->cart_id }}">
                                                <input type="hidden" name="count" value="{{ $item->count + 1 }}">
                                                <button type="submit" class="quantity-btn-modern" {{ $item->count >= $item->in_stock ? 'disabled' : '' }}>
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-3 mt-md-0 text-md-end">
                                        <div class="cart-item-total">
                                            <div class="total-price">{{ number_format($item->price * $item->count, 0, '', ' ') }} ₽</div>
                                            @if($item->count > 1)
                                                <small class="text-muted">{{ number_format($item->price, 0, '', ' ') }} ₽ × {{ $item->count }} шт.</small>
                                            @else
                                                <small class="text-muted">{{ number_format($item->price, 0, '', ' ') }} ₽</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="cart-actions-modern">
                        <a href="{{ route('catalog') }}" class="btn btn-outline-primary-modern">
                            <i class="bi bi-arrow-left me-2"></i>ПРОДОЛЖИТЬ ПОКУПКИ
                        </a>
                        <form method="POST" action="{{ route('remove_add') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger-modern">
                                <i class="bi bi-trash me-2"></i>ОЧИСТИТЬ КОРЗИНУ
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="order-summary-card-modern">
                        <div class="summary-header">
                            <h5 class="mb-0">ИТОГИ ЗАКАЗА</h5>
                        </div>
                        <div class="summary-body">
                            @php
                                $subtotal = 0;
                                $totalItems = 0;
                                foreach($cart as $item) {
                                    $subtotal += $item->price * $item->count;
                                    $totalItems += $item->count;
                                }
                                $promoDiscount = session('promo_discount');
                                $promoType = session('promo_type');
                                $discountAmount = 0;
                                if ($promoDiscount && $promoType) {
                                    if ($promoType == 'percent') {
                                        $discountAmount = $subtotal * $promoDiscount / 100;
                                    } else {
                                        $discountAmount = min($promoDiscount, $subtotal);
                                    }
                                }
                                $finalTotal = $subtotal - $discountAmount;
                            @endphp

                            <div class="summary-row">
                                <span>Товары ({{ $totalItems }} шт.)</span>
                                <span>{{ number_format($subtotal, 0, '', ' ') }} ₽</span>
                            </div>

                            <div class="summary-row">
                                <span>Доставка</span>
                                <span class="text-success">БЕСПЛАТНО</span>
                            </div>

                            @if($discountAmount > 0)
                            <div class="summary-row">
                                <span style="color: #FF6B6B;">Скидка по промокоду</span>
                                <span style="color: #FF6B6B; font-weight: 600;">-{{ number_format($discountAmount, 0, '', ' ') }} ₽</span>
                            </div>
                            @endif

                            <div class="summary-divider"></div>

                            <div class="summary-total-row">
                                <span>ИТОГО:</span>
                                <span class="total-amount">{{ number_format(max($finalTotal, 0), 0, '', ' ') }} ₽</span>
                            </div>
                        </div>

                        <div class="summary-footer">
                            <a href="{{ route('add_order') }}" class="btn btn-checkout-modern">
                                ОФОРМИТЬ ЗАКАЗ
                            </a>
                        </div>

                        <div class="promo-section p-3 border-top">
                            <form method="GET" action="{{ route('cart') }}" class="promo-form">
                                <label class="form-label small fw-bold">ПРОМОКОД</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="promo" placeholder="Введите код" value="{{ request('promo') }}">
                                    <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B); color: #fff; border: none; font-weight: 600;">Применить</button>
                                </div>
                                @if(session('promo_error'))
                                    <small class="text-danger mt-1 d-block">{{ session('promo_error') }}</small>
                                @endif
                                @if(session('promo_discount'))
                                    <small class="text-success mt-1 d-block"><i class="bi bi-check-circle me-1"></i>Скидка {{ session('promo_discount') }}{{ session('promo_type') == 'percent' ? '%' : ' ₽' }}</small>
                                @endif
                            </form>
                        </div>

                        <div class="order-info-modern">
                            <div class="info-item-modern">
                                <i class="bi bi-shield-check" style="color: #20B2AA;"></i>
                                <span>Безопасная оплата</span>
                            </div>
                            <div class="info-item-modern">
                                <i class="bi bi-arrow-counterclockwise" style="color: #FF8C42;"></i>
                                <span>Возврат в течение 30 дней</span>
                            </div>
                            <div class="info-item-modern">
                                <i class="bi bi-headset" style="color: #20B2AA;"></i>
                                <span>Поддержка 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>

<style>
.cart-header .section-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--dark-color);
}

.cart-items-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
}

.cart-items-header {
    border-bottom: 1px solid #f0f0f0;
}

.cart-items-header h5 {
    font-weight: 700;
    color: var(--dark-color);
}

.cart-item-row {
    padding: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
}

.cart-item-row:last-child {
    border-bottom: none;
}

.cart-item-row:hover {
    background: #FFF8F0;
}

.cart-item-name a {
    color: var(--dark-color);
    text-decoration: none;
    font-weight: 600;
}

.cart-item-name a:hover {
    color: #FF8C42;
}

.quantity-controls-modern {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 4px;
}

.quantity-btn-modern {
    width: 32px;
    height: 32px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: #333;
}

.quantity-btn-modern:hover {
    background: #FF8C42;
    color: #fff;
    border-color: #FF8C42;
}

.quantity-btn-modern:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-remove-modern:hover {
    background: #e74c3c !important;
    color: #fff !important;
    border-color: #e74c3c !important;
}

.quantity-display {
    font-weight: 700;
    font-size: 0.95rem;
    min-width: 50px;
    text-align: center;
    color: var(--dark-color);
}

.total-price {
    font-size: 1.25rem;
    font-weight: 800;
    color: #FF8C42;
}

.cart-actions-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.order-summary-card-modern {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    position: sticky;
    top: 90px;
}

.summary-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.summary-header h5 {
    font-weight: 700;
    color: var(--dark-color);
}

.summary-body {
    padding: 1.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    color: #555;
}

.summary-divider {
    height: 1px;
    background: #e0e0e0;
    margin: 1rem 0;
}

.summary-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--dark-color);
}

.total-amount {
    color: #FF8C42;
    font-size: 1.5rem;
    font-weight: 900;
}

.summary-footer {
    padding: 0 1.5rem 1.5rem;
}

.btn-checkout-modern {
    display: block;
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    color: #fff;
    text-align: center;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-checkout-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 140, 66, 0.4);
    color: #fff;
}

.order-info-modern {
    padding: 0 1.5rem 1.5rem;
}

.info-item-modern {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    color: #666;
}

.btn-outline-primary-modern {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    border: 2px solid #FF8C42;
    color: #FF8C42;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-outline-primary-modern:hover {
    background: #FF8C42;
    color: #fff;
}

.btn-outline-danger-modern {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    border: 2px solid #e74c3c;
    color: #e74c3c;
    border-radius: 8px;
    background: transparent;
    font-weight: 600;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-outline-danger-modern:hover {
    background: #e74c3c;
    color: #fff;
}

.cart-item-image img {
    width: 100%;
    max-width: 100px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}
</style>
@endsection
