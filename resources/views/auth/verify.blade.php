@extends('layouts.app')

@section('content')
<div class="container verification-page">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="auth-form-container">
                <div class="auth-header">
                    <div class="auth-icon">
                        <i class="bi bi-envelope-check"></i>
                    </div>
                    <h1 class="auth-title">{{ __('Подтверждение Email') }}</h1>
                </div>

                <div class="auth-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ __('Новая ссылка подтверждения была отправлена на ваш email.') }}
                        </div>
                    @endif

                    <p>{{ __('Перед продолжением, пожалуйста, проверьте ваш email и перейдите по ссылке подтверждения.') }}</p>
                    <p class="text-muted">{{ __('Если письмо не пришло, проверьте папку "Спам".') }}</p>

                    <div class="mt-4">
                        <p>{{ __('Если вы не получили письмо') }},</p>
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="submit-button">
                                <i class="bi bi-send me-2"></i>{{ __('нажмите здесь, чтобы отправить повторно') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-form-container {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    overflow: hidden;
    margin: 2rem 0;
}

.auth-header {
    padding: 2.5rem 2rem 1.5rem;
    text-align: center;
    background: linear-gradient(135deg, #FFF3E0, #fff);
}

.auth-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #20B2AA, #17a589);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-icon i {
    font-size: 2rem;
    color: #fff;
}

.auth-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dark-color);
}

.auth-body {
    padding: 1.5rem 2rem 2.5rem;
}

.submit-button {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #20B2AA, #17a589);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.submit-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(32, 178, 170, 0.4);
}
</style>
@endsection
