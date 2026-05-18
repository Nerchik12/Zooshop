@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2" style="color: var(--dark-color);">СНОВА ЗДЕСЬ, {{ Auth::user()->name }}!</h1>
                <p class="text-muted">Ваш личный кабинет в ЗООМАГАЗИНЕ</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="user-avatar">
                    <div class="avatar-circle" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B);">
                        {{ strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B);">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $totalOrders }}</div>
                    <div class="stat-label">Всего заказов</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f39c12, #f1c40f);">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $processingOrders }}</div>
                    <div class="stat-label">В обработке</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #20B2AA, #17a589);">
                    <i class="bi bi-check2-all"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ $completedOrders }}</div>
                    <div class="stat-label">Завершено</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #FF6B6B, #ee5a24);">
                    <i class="bi bi-currency-ruble"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ number_format($totalSpent, 0, '', ' ') }} ₽</div>
                    <div class="stat-label">Потрачено всего</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="dashboard-sidebar">
                <div class="sidebar-header">
                    <h5>МЕНЮ</h5>
                </div>
                <div class="sidebar-menu">
                    <a href="{{ route('home') }}" class="sidebar-item active">
                        <i class="bi bi-speedometer2 me-3"></i>Обзор
                    </a>
                    <a href="{{ route('orders') }}" class="sidebar-item">
                        <i class="bi bi-cart me-3"></i>Мои заказы
                    </a>
                    <a href="{{ route('catalog') }}" class="sidebar-item">
                        <i class="bi bi-shop me-3"></i>Каталог
                    </a>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="sidebar-item">
                        <i class="bi bi-box-arrow-right me-3"></i>Выход
                    </a>
                </div>
            </div>

            <div class="profile-card mt-4">
                <div class="profile-card-body">
                    <h6><i class="bi bi-person-circle me-2" style="color: #FF8C42;"></i>ПРОФИЛЬ</h6>
                    <div class="profile-info">
                        <div class="profile-row">
                            <span class="profile-label">Имя</span>
                            <span class="profile-value">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="profile-row">
                            <span class="profile-label">Телефон</span>
                            <span class="profile-value">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="dashboard-content">
                <div class="dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2" style="color: #FF8C42;"></i>ПОСЛЕДНИЕ ЗАКАЗЫ</h5>
                        @if($orders->count() > 0)
                        <a href="{{ route('orders') }}" class="btn-view-all">
                            Все заказы <i class="bi bi-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            @foreach($orders->take(4) as $order)
                            <div class="order-row">
                                <div class="row align-items-center">
                                    <div class="col-lg-2 col-4">
                                        <div class="fw-bold" style="color: var(--dark-color);">#{{ $order->id }}</div>
                                    </div>
                                    <div class="col-lg-3 col-4">
                                        <div class="text-muted small">{{ date('d.m.Y H:i', strtotime($order->created_at)) }}</div>
                                    </div>
                                    <div class="col-lg-3 col-4">
                                        @foreach($order->products->take(2) as $product)
                                        <div class="order-product-name text-truncate small">{{ $product->product_name }}</div>
                                        @endforeach
                                        @if($order->products->count() > 2)
                                        <div class="text-muted small">+ ещё {{ $order->products->count() - 2 }}</div>
                                        @endif
                                    </div>
                                    <div class="col-lg-2 d-none d-lg-block">
                                        <div class="fw-bold" style="color: #FF8C42;">{{ number_format($order->order_total, 0, '', ' ') }} ₽</div>
                                    </div>
                                    <div class="col-lg-2 col-12 mt-2 mt-lg-0">
                                        @if($order->status == 'active')
                                            <span class="status-badge status-active">АКТИВЕН</span>
                                        @elseif($order->status == 'completed')
                                            <span class="status-badge status-completed">ЗАВЕРШЕН</span>
                                        @elseif($order->status == 'pending')
                                            <span class="status-badge status-pending">ОЖИДАЕТ</span>
                                        @else
                                            <span class="status-badge status-cancelled">{{ strtoupper($order->status) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-cart-x" style="font-size: 3rem; color: #ddd;"></i>
                                </div>
                                <p class="text-muted mb-3">У вас пока нет заказов</p>
                                <a href="{{ route('catalog') }}" class="btn" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B); color: #fff; border: none; padding: 10px 30px; border-radius: 50px; font-weight: 700;">
                                    <i class="bi bi-cart me-2"></i>Сделать покупку
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                @if($orders->count() > 0)
                <div class="dashboard-card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-lightning-charge me-2" style="color: #FF8C42;"></i>БЫСТРЫЕ ДЕЙСТВИЯ</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('catalog') }}" class="quick-action-card">
                                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B);">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <span>Найти товары</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('orders') }}" class="quick-action-card">
                                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #20B2AA, #17a589);">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <span>Мои заказы</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('catalog') }}" class="quick-action-card">
                                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #FF6B6B, #ee5a24);">
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <span>Популярное</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
}

.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.03);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    flex-shrink: 0;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--dark-color);
    line-height: 1.2;
}

.stat-label {
    color: #666;
    font-size: 0.85rem;
    font-weight: 500;
}

.dashboard-sidebar {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.03);
}

.sidebar-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    color: #fff;
}

.sidebar-header h5 {
    margin: 0;
    font-weight: 700;
    letter-spacing: 1px;
}

.sidebar-item {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: #555;
    text-decoration: none;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    font-weight: 500;
}

.sidebar-item:hover {
    background: #FFF3E0;
    color: #FF8C42;
    padding-left: 1.8rem;
}

.sidebar-item.active {
    background: #FFF3E0;
    color: #FF8C42;
    border-left-color: #FF8C42;
    font-weight: 700;
}

.dashboard-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.03);
}

.dashboard-card .card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    background: #fafafa;
}

.dashboard-card .card-header h5 {
    font-weight: 700;
    color: var(--dark-color);
}

.btn-view-all {
    color: #FF8C42;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.85rem;
    transition: all 0.2s;
}

.btn-view-all:hover {
    color: #e67a30;
    transform: translateX(3px);
}

.order-row {
    padding: 1rem 0;
    border-bottom: 1px solid #f5f5f5;
    transition: background 0.2s;
}

.order-row:last-child {
    border-bottom: none;
}

.order-row:hover {
    background: #FFFAF5;
    margin: 0 -1.5rem;
    padding: 1rem 1.5rem;
    border-radius: 8px;
}

.order-product-name {
    color: #555;
    font-size: 0.85rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.75rem;
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

.profile-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    border: 1px solid rgba(0,0,0,0.03);
}

.profile-card-body {
    padding: 1.25rem 1.5rem;
}

.profile-card-body h6 {
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f0f0f0;
}

.profile-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.4rem 0;
}

.profile-label {
    font-size: 0.82rem;
    color: #888;
    font-weight: 500;
}

.profile-value {
    font-size: 0.85rem;
    color: var(--dark-color);
    font-weight: 600;
    text-align: right;
}

.quick-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 1.5rem;
    background: #fafafa;
    border-radius: 12px;
    text-decoration: none;
    color: var(--dark-color);
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.quick-action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    color: var(--dark-color);
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #fff;
}
</style>
@endsection
