@extends('layouts.app')

@section('content')
<main>
    <section class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">О нас</li>
                </ol>
            </nav>

            <div class="row mb-5">
                <div class="col-lg-6">
                    <h1 class="section-title mb-4">О ЗООМАГАЗИНЕ</h1>
                    <p class="lead" style="color: #FF8C42; font-weight: 600;">Забота о ваших питомцах — наша главная миссия!</p>
                    <p>ЗООМАГАЗИН — это современный интернет-магазин товаров для животных, основанный в 2024 году. Мы объединили любовь к питомцам и профессиональный подход к подбору качественных товаров.</p>
                    <p>В нашем ассортименте — только проверенные бренды кормов, сертифицированные игрушки, надёжные аксессуары и эффективные средства ухода. Каждый товар проходит тщательный отбор, чтобы быть безопасным и полезным для вашего любимца.</p>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400/FF8C42/ffffff?text=О+нас" class="img-fluid rounded-4 shadow" alt="О магазине" style="width: 100%; object-fit: cover; height: 350px;">
                </div>
            </div>

            <div class="row mb-5 g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="about-stat-card">
                        <div class="about-stat-icon" style="background: linear-gradient(135deg, #FF8C42, #FF6B6B);">
                            <i class="bi bi-heart"></i>
                        </div>
                        <div class="about-stat-number">500+</div>
                        <div class="about-stat-label">Счастливых питомцев</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="about-stat-card">
                        <div class="about-stat-icon" style="background: linear-gradient(135deg, #20B2AA, #17a589);">
                            <i class="bi bi-box"></i>
                        </div>
                        <div class="about-stat-number">1000+</div>
                        <div class="about-stat-label">Товаров в каталоге</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="about-stat-card">
                        <div class="about-stat-icon" style="background: linear-gradient(135deg, #f39c12, #f1c40f);">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="about-stat-number">24ч</div>
                        <div class="about-stat-label">Быстрая доставка</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="about-stat-card">
                        <div class="about-stat-icon" style="background: linear-gradient(135deg, #FF6B6B, #ee5a24);">
                            <i class="bi bi-star"></i>
                        </div>
                        <div class="about-stat-number">4.9</div>
                        <div class="about-stat-label">Рейтинг магазина</div>
                    </div>
                </div>
            </div>

            <div class="row mb-5 g-4">
                <div class="col-lg-4">
                    <div class="about-feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4>Только качество</h4>
                        <p>Мы работаем напрямую с официальными поставщиками и производителями. Каждый товар имеет сертификаты качества.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-hand-thumbs-up"></i>
                        </div>
                        <h4>Экспертный подход</h4>
                        <p>Наши консультанты — опытные ветеринары и зоопсихологи. Мы поможем подобрать идеальный рацион и аксессуары.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>
                        <h4>Лёгкий возврат</h4>
                        <p>Если товар не подошёл — вернём его без лишних вопросов в течение 30 дней. Забота о вас так же важна, как и о питомцах.</p>
                    </div>
                </div>
            </div>

            <div class="about-mission-card p-5 rounded-4 text-center" style="background: linear-gradient(135deg, #FFF3E0, #FFE0B2);">
                <h2 class="fw-bold mb-3" style="color: var(--dark-color);">НАША МИССИЯ</h2>
                <p class="mb-0" style="font-size: 1.15rem; color: #555; max-width: 700px; margin: 0 auto;">
                    Мы стремимся сделать жизнь домашних животных счастливее и здоровее, предоставляя владельцам доступ к лучшим товарам и экспертной информации. Каждый питомец заслуживает любви и качественной заботы!
                </p>
            </div>
        </div>
    </section>
</main>

<style>
.about-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.03);
}

.about-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.about-stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: #fff;
    margin: 0 auto 1rem;
}

.about-stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--dark-color);
}

.about-stat-label {
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
    margin-top: 0.25rem;
}

.about-feature-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.03);
}

.about-feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.feature-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    margin-bottom: 1rem;
}

.about-feature-card h4 {
    font-weight: 700;
    margin-bottom: 0.75rem;
    color: var(--dark-color);
}

.about-feature-card p {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.6;
}
</style>
@endsection
