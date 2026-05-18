@extends('layouts.app')

@section('content')

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form-card">
                        <div class="text-center mb-5">
                            <h2 class="section-title mb-3">ОСТАВЬТЕ ОТЗЫВ О НАШЕМ МАГАЗИНЕ</h2>
                            <p class="text-muted">Ваше мнение помогает нам становиться лучше каждый день</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('sendReview') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Ваше имя *</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           required
                                           placeholder="Иван Иванов">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Телефон *</label>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           required
                                           placeholder="+7 (999) 999-99-99">
                                </div>
                                
                                <div class="col-12">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           required
                                           placeholder="example@mail.ru">
                                </div>
                                
                                <div class="col-12">
                                    <label for="message" class="form-label">Сообщение</label>
                                    <textarea class="form-control" 
                                              id="message" 
                                              name="message" 
                                              rows="5"
                                              placeholder="Опишите ваш вопрос или предложение..."></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg py-3">
                                            <i class="bi bi-send me-2"></i>ОТПРАВИТЬ ОТЗЫВ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
