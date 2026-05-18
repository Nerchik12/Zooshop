<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - @yield('title', 'ЗООМАГАЗИН')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #FF8C42;
            --primary-light: #ffa366;
            --primary-dark: #e67a30;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: #f5f6fa;
            min-height: 100vh;
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(135deg, #2D3436 0%, #1a1a2e 100%);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 800;
            margin: 0;
            font-size: 1.3rem;
        }

        .sidebar-brand small {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(255, 140, 66, 0.3), rgba(255, 107, 107, 0.2));
            color: #fff;
            border-left-color: #FF8C42;
        }

        .sidebar-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .admin-topbar {
            background: #fff;
            padding: 0.75rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-wrap: nowrap;
        }

        .admin-topbar h5 {
            margin: 0;
            font-weight: 700;
            color: #1a1a1a;
            white-space: nowrap;
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: nowrap;
        }

        .admin-cart-btn {
            position: relative;
            width: 42px;
            height: 42px;
            background: rgba(255, 140, 66, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .admin-cart-btn:hover {
            background: rgba(255, 140, 66, 0.2);
            transform: translateY(-2px);
        }

        .admin-cart-btn i {
            font-size: 20px;
            color: #FF8C42;
        }

        .admin-cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .admin-logout-btn {
            width: 42px;
            height: 42px;
            background: rgba(231, 76, 60, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .admin-logout-btn:hover {
            background: rgba(231, 76, 60, 0.2);
            transform: translateY(-2px);
        }

        .admin-logout-btn i {
            font-size: 20px;
            color: #e74c3c;
        }

        .admin-user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #FF8C42, #FF6B6B);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        
        .admin-user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .admin-user-name {
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }
        
        .admin-user-role {
            color: #666;
            font-size: 0.7rem;
            white-space: nowrap;
        }

        .admin-content {
            padding: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.purple,
        .stat-icon.green {
            background: linear-gradient(135deg, #FF8C42, #FF6B6B);
            color: #fff;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #20B2AA, #17a589);
            color: #fff;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: #fff;
        }

        .stat-info h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0;
            color: #1a1a1a;
        }

        .stat-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .admin-table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .admin-table thead {
            background: linear-gradient(135deg, #FF8C42, #FF6B6B);
            color: #fff;
        }

        .admin-table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .admin-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f0f0f0;
        }

        .admin-table tbody tr:hover {
            background: #f8f9fa;
        }

        .btn-purple {
            background: linear-gradient(135deg, #FF8C42, #FF6B6B);
            color: #fff;
            border: none;
        }

        .btn-purple:hover {
            background: linear-gradient(135deg, #e67a30, #e74c3c);
            color: #fff;
        }

        .btn-outline-purple {
            background: transparent;
            border: 2px solid #FF8C42;
            color: #FF8C42;
        }

        .btn-outline-purple:hover {
            background: #FF8C42;
            color: #fff;
        }

        .badge-purple {
            background: linear-gradient(135deg, #FF8C42, #FF6B6B);
            color: #fff;
        }

        .badge-green {
            background: linear-gradient(135deg, #20B2AA, #17a589);
            color: #fff;
        }

        .badge-blue {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
        }

        .badge-orange {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: #fff;
        }

        .badge-red {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.mobile-open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <h4><i class="bi bi-shield-lock me-2"></i>АДМИНКА</h4>
            <small>Панель управления</small>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.index') }}" class="sidebar-item {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Обзор</span>
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Пользователи</span>
            </a>
            <a href="{{ route('admin.reviews') }}" class="sidebar-item {{ request()->routeIs('admin.reviews') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text"></i>
                <span>Отзывы</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-bag"></i>
                <span>Заказы</span>
            </a>
            <a href="{{ route('admin.products') }}" class="sidebar-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <i class="bi bi-box"></i>
                <span>Все товары</span>
            </a>
            <a href="{{ route('admin.promocodes') }}" class="sidebar-item {{ request()->routeIs('admin.promocodes') || request()->routeIs('admin.promocodes.create') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i>
                <span>Промокоды</span>
            </a>
            <hr class="mx-3 my-2" style="border-color: rgba(255,255,255,0.1);">
            <a href="{{ route('add_product') }}" class="sidebar-item {{ request()->routeIs('add_product') ? 'active' : '' }}" style="background: rgba(255, 140, 66, 0.2); border-left-color: #FF8C42;">
                <i class="bi bi-plus-circle"></i>
                <span>Добавить товар</span>
            </a>
            <a href="/" class="sidebar-item">
                <i class="bi bi-house"></i>
                <span>На сайт</span>
            </a>
            <a href="{{ route('logout') }}" class="sidebar-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Выйти</span>
            </a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <h5>@yield('page-title', 'Панель управления')</h5>

            <div class="admin-user-menu">
                <a href="{{ route('cart') }}" class="admin-cart-btn" title="Корзина">
                    <i class="bi bi-cart3"></i>
                    <span class="admin-cart-badge">{{ $cartCount ?? 0 }}</span>
                </a>
                
                <div class="d-none d-md-flex align-items-center gap-2">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="admin-user-info">
                        <div class="admin-user-name">{{ Auth::user()->name }}</div>
                        <div class="admin-user-role">{{ Auth::user()->role_name }}</div>
                    </div>
                </div>
                
                <a href="{{ route('logout') }}" class="admin-logout-btn" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   title="Выйти">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
