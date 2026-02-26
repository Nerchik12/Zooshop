@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Приветствие -->
    <div class="dashboard-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2">ДОБРО ПОЖАЛОВАТЬ, {{ Auth::user()->name }}!</h1>
                <p class="text-muted">Управляйте своими заказами и настройками аккаунта</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="user-avatar">
                    <div class="avatar-circle">
                        {{ strtoupper(mb_substr(Auth::user()->name, 0, 1, 'UTF-8')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="row mb-5">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon">
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
                <div class="stat-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">{{ number_format($totalSpent, 0, '', ' ') }} ₽</div>
                    <div class="stat-label">Общая сумма</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Основное содержание -->
    <div class="row">
        <!-- Боковое меню -->
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

                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="sidebar-item">
                        <i class="bi bi-box-arrow-right me-3"></i>Выход
                    </a>
                </div>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="col-lg-9">
            <div class="dashboard-content">
                <!-- Последние заказы -->
                <div class="dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">ПОСЛЕДНИЕ ЗАКАЗЫ</h5>
                        <a href="{{ route('orders') }}" class="btn-view-all">
                            Все заказы <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="list-group">
                                @foreach($orders as $order)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Заказ #{{ $order->id }}</h6>
                                        <h6 class="mb-1">В заказе</h6>
                                        <small class="text-muted">{{ $order->created_at}}</small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>{{ $order->total_items ?? 0 }} товаров</small>
                                        <div class="product-name">
                                            @foreach($order->products as $product)
                                        <small>{{ $product->product_name  }} </small>
                                        @endforeach
                                    </div>
                                        <span class="badge {{ $order->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                  @if($order->status == 'active')
                                    <span class="badge bg-success">АКТИВЕН</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-primary">ЗАВЕРШЕН</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-warning">ОЖИДАЕТ</span>
                                @else
                                    <span class="badge bg-secondary">{{ strtoupper($order->status) }}</span>
                                @endif
                                        </span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-cart-x display-6 text-muted mb-3"></i>
                                <p class="text-muted">У вас пока нет заказов</p>
                                <a href="{{ route('catalog') }}" class="btn btn-primary btn-sm">Сделать покупку</a>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection