@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold mb-1" style="color: var(--dark-color); font-size: 2rem;">
                <i class="bi bi-box-seam me-2" style="color: #FF8C42;"></i>МОИ ЗАКАЗЫ
            </h1>
            <p class="text-muted mb-0">История покупок в ЗООМАГАЗИНЕ</p>
        </div>
        <a href="{{ route('catalog') }}" class="btn" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B); color: #fff; border: none; padding: 10px 24px; border-radius: 50px; font-weight: 700; font-size: 0.85rem;">
            <i class="bi bi-plus-lg me-2"></i>Новый заказ
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="empty-state text-center py-5">
            <div class="empty-state-icon mb-4">
                <i class="bi bi-box" style="font-size: 4rem; color: #e0e0e0;"></i>
            </div>
            <h3 class="fw-bold mb-2" style="color: var(--dark-color);">ЗАКАЗОВ ПОКА НЕТ</h3>
            <p class="text-muted mb-4">Вы ещё ничего не заказали. Самое время выбрать что-то для вашего питомца!</p>
            <a href="{{ route('catalog') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B); color: #fff; border: none; padding: 14px 40px; border-radius: 50px; font-weight: 700;">
                <i class="bi bi-cart me-2"></i>В КАТАЛОГ
            </a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
            <div class="order-card mb-4">
                <div class="order-card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-2 col-4">
                            <div class="order-number">
                                <i class="bi bi-hash"></i> {{ $order->id }}
                            </div>
                        </div>
                        <div class="col-lg-3 col-4">
                            <div class="order-date">
                                <i class="bi bi-calendar3"></i>
                                {{ date('d.m.Y', strtotime($order->created_at)) }}
                            </div>
                            <div class="order-time text-muted small">
                                {{ date('H:i', strtotime($order->created_at)) }}
                            </div>
                        </div>
                        <div class="col-lg-3 col-4">
                            @if($order->status == 'active')
                                <span class="status-badge status-active">
                                    <i class="bi bi-check-circle-fill me-1"></i>АКТИВЕН
                                </span>
                            @elseif($order->status == 'completed')
                                <span class="status-badge status-completed">
                                    <i class="bi bi-check-circle-fill me-1"></i>ЗАВЕРШЕН
                                </span>
                            @elseif($order->status == 'pending')
                                <span class="status-badge status-pending">
                                    <i class="bi bi-clock-fill me-1"></i>ОЖИДАЕТ
                                </span>
                            @else
                                <span class="status-badge status-cancelled">
                                    <i class="bi bi-x-circle-fill me-1"></i>{{ strtoupper($order->status) }}
                                </span>
                            @endif
                        </div>
                        <div class="col-lg-4 d-none d-lg-block text-end">
                            <div class="order-total-header">
                                <span class="text-muted small">Сумма заказа:</span>
                                <strong>{{ number_format($order->order_total, 0, '', ' ') }} ₽</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card-body">
                    @if($order->products->isNotEmpty())
                        <div class="order-items">
                            @foreach($order->products as $product)
                            <div class="order-item">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-7">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="order-item-icon" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2);">
                                                <i class="bi bi-bag" style="color: #FF8C42;"></i>
                                            </div>
                                            <div>
                                                <div class="order-item-name">{{ $product->product_name }}</div>
                                                <div class="order-item-sku small text-muted">Арт. #{{ $loop->parent->iteration }}{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-5">
                                        <div class="order-item-quantity">
                                            {{ $product->quantity }} шт × {{ number_format($product->unit_price, 0, '', ' ') }} ₽
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-none d-lg-block text-end">
                                        <div class="order-item-total">
                                            {{ number_format($product->item_total, 0, '', ' ') }} ₽
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <span class="text-muted"><i class="bi bi-exclamation-circle me-2"></i>Товары не найдены</span>
                        </div>
                    @endif

                    <div class="order-card-footer">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="order-info-text">
                                    <i class="bi bi-info-circle"></i>
                                    <span>Менеджер свяжется с вами для подтверждения</span>
                                </div>
                            </div>
                            <div class="col-lg-6 text-lg-end mt-2 mt-lg-0">
                                <div class="order-actions">
                                    <span class="me-3 d-inline-block">
                                        <strong>Итого:</strong>
                                        <span style="color: #FF8C42; font-size: 1.1rem;">{{ number_format($order->order_total, 0, '', ' ') }} ₽</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.empty-state-icon i {
    opacity: 0.5;
}

.order-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.03);
    transition: all 0.3s ease;
}

.order-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
}

.order-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    background: linear-gradient(135deg, #FFFAF5, #FFF3E0);
}

.order-number {
    font-weight: 800;
    color: var(--dark-color);
    font-size: 1.1rem;
}

.order-date {
    color: #555;
    font-size: 0.9rem;
    font-weight: 500;
}

.order-time {
    font-size: 0.8rem;
}

.order-total-header strong {
    color: #FF8C42;
    font-size: 1.1rem;
    margin-left: 5px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.78rem;
    letter-spacing: 0.5px;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-completed {
    background: #cce5ff;
    color: #004085;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.order-card-body {
    padding: 0.5rem 0;
}

.order-item {
    padding: 0.85rem 1.5rem;
    border-bottom: 1px solid #f5f5f5;
    transition: background 0.2s;
}

.order-item:last-child {
    border-bottom: none;
}

.order-item:hover {
    background: #FFFAF5;
}

.order-item-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.order-item-name {
    font-weight: 600;
    color: var(--dark-color);
    font-size: 0.9rem;
}

.order-item-sku {
    font-size: 0.75rem;
}

.order-item-quantity {
    color: #666;
    font-size: 0.85rem;
}

.order-item-total {
    font-weight: 700;
    color: #FF8C42;
    font-size: 0.95rem;
}

.order-card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
}

.order-info-text {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    color: #666;
}

.order-info-text i {
    color: #20B2AA;
    font-size: 1rem;
}

.order-actions strong {
    color: var(--dark-color);
}

.empty-state-icon {
    position: relative;
    display: inline-block;
}
</style>
@endsection
