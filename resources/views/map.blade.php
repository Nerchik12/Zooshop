@extends('layouts.app')

@section('content')
<main>
<!-- Контактная информация -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Информация -->
                <div class="col-lg-4">
    <div class="contact-info-card">
        <h3 class="mb-4">НАШИ КОНТАКТЫ</h3>
        
        <div class="contact-item">
            <div class="contact-icon">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div class="contact-details">
                <h5>АДРЕС</h5>
                <p>Москва, ул. Строителей, 15</p>
                <small>Технопарк "Строймастер", вход со двора</small>
            </div>
        </div>
        
        <div class="contact-item">
            <div class="contact-icon">
                <i class="bi bi-telephone"></i>
            </div>
            <div class="contact-details">
                <h5>ТЕЛЕФОН</h5>
                <p>+7 (495) 765-43-21</p>
            </div>
        </div>
        
        <div class="contact-item">
            <div class="contact-icon">
                <i class="bi bi-envelope"></i>
            </div>
            <div class="contact-details">
                <h5>EMAIL</h5>
                <p>info@stroi-magazin.ru</p>
                <p>zakaz@stroi-magazin.ru</p>
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
</div>

                <!-- Карта -->
                <div class="col-lg-8">
    <div class="map-card">
        <div class="map-wrapper">
            <iframe src="https://yandex.ru/map-widget/v1/?um=constructor&ll=37.617634%2C55.755773&z=17&pt=37.617634%2C55.755773" 
                    width="100%" 
                    height="400" 
                    frameborder="0">
            </iframe>
        </div>
        
        <div class="map-info mt-4">
            <h5 class="mb-3">АДРЕС: ТЕХНОПАРК "СТРОЙМАСТЕР"</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="transport-item">
                        <p>Москва, ул. Строителей, 15</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="transport-item">
                        <i class="bi bi-subway text-primary"></i>
                        <p>Метро. "Технопарк", 5 мин пешком</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="transport-item">
                        <p>Автобусы 15, 32, 47 до ост. "Технопарк"</p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-light border">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        <strong>Режим работы:</strong> Пн-Пт 9:00-20:00, Сб-Вс 10:00-18:00
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
@endsection