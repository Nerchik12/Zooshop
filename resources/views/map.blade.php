@extends('layouts.app')

@section('content')
<main>
    <section class="py-5">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Контакты</li>
                </ol>
            </nav>

            <h1 class="section-title mb-5">КОНТАКТЫ</h1>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="contact-info-card">
                        <h3 class="mb-4">НАШИ КОНТАКТЫ</h3>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h5>АДРЕС</h5>
                                <p>Москва, ул. Зоологическая, 15</p>
                                <small>ТЦ "Зоомир", 1-й этаж</small>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-details">
                                <h5>ТЕЛЕФОН</h5>
                                <p>+7 (495) 765-43-21</p>
                                <small>Ежедневно с 9:00 до 20:00</small>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h5>EMAIL</h5>
                                <p>info@zoomagazin.ru</p>
                                <p>zakaz@zoomagazin.ru</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h5>РЕЖИМ РАБОТЫ</h5>
                                <p>Пн-Пт: 9:00 - 20:00</p>
                                <p>Сб-Вс: 10:00 - 18:00</p>
                                <small class="text-muted">Магазин и пункт выдачи</small>
                            </div>
                        </div>
                    </div>

                    <div class="contact-social-card mt-4">
                        <h5 class="mb-3">МЫ В СОЦСЕТЯХ</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#" class="social-circle" style="background: #25D366;"><i class="bi bi-whatsapp"></i></a>
                            <a href="#" class="social-circle" style="background: #0088cc;"><i class="bi bi-telegram"></i></a>
                            <a href="#" class="social-circle" style="background: #E4405F;"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-circle" style="background: #FF0000;"><i class="bi bi-youtube"></i></a>
                            <a href="#" class="social-circle" style="background: #7289DA;"><i class="bi bi-chat-dots"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="map-card">
                        <div class="map-wrapper">
                            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor&ll=37.617634%2C55.755773&z=17&pt=37.617634%2C55.755773" 
                                    width="100%" 
                                    height="400" 
                                    frameborder="0"
                                    style="border-radius: 12px;">
                            </iframe>
                        </div>
                        
                        <div class="map-info mt-4">
                            <h5 class="mb-3">АДРЕС: ТЦ "ЗООМИР"</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="transport-item">
                                        <i class="bi bi-geo-alt" style="color: #FF8C42;"></i>
                                        <span>Москва, ул. Зоологическая, 15</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="transport-item">
                                        <i class="bi bi-subway" style="color: #FF8C42;"></i>
                                        <span>Метро "Зоопарк", 5 мин пешком</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="transport-item">
                                        <i class="bi bi-bus-front" style="color: #FF8C42;"></i>
                                        <span>Автобусы 15, 32, 47 до ост. "Зоомир"</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</main>

<style>
.contact-info-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.03);
}

.contact-info-card h3 {
    font-weight: 700;
    color: var(--dark-color);
    font-size: 1.3rem;
}

.contact-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.contact-item:last-child {
    border-bottom: none;
}

.contact-icon {
    width: 50px;
    height: 50px;
    min-width: 50px;
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #FF8C42;
}

.contact-details h5 {
    font-size: 0.8rem;
    font-weight: 700;
    color: #999;
    margin-bottom: 0.3rem;
    letter-spacing: 1px;
}

.contact-details p {
    margin-bottom: 0.15rem;
    color: var(--dark-color);
    font-weight: 500;
}

.contact-details small {
    color: #888;
}

.contact-social-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.03);
}

.contact-social-card h5 {
    font-weight: 700;
    color: var(--dark-color);
}

.social-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.2rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-circle:hover {
    transform: scale(1.15);
    color: #fff;
}

.map-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.03);
}

.map-card h5 {
    font-weight: 700;
    color: var(--dark-color);
}

.transport-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #555;
}


</style>
@endsection
