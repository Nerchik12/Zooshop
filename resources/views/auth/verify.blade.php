@extends('layouts.app')

@section('content')
<div class="container verification-page">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="verify-email-container">
                <!-- Заголовок -->
                <div class="verify-header">
                    <div class="verify-icon">
                        <i class="fas fa-envelope-circle-check"></i>
                    </div>
                    <h1 class="verify-title">{{ __('Подтверждение Email') }}</h1>
                </div>

                <!-- Контент -->
                <div class="verify-content">
                    @if (session('resent'))
                        <div class="verify-success-message">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ __('Новая ссылка подтверждения была отправлена на ваш email.') }}</span>
                        </div>
                    @endif

                    <div class="verify-message">
                        <p>{{ __('Перед продолжением, пожалуйста, проверьте ваш email и перейдите по ссылке подтверждения.') }}</p>
                        <p class="verify-hint">{{ __('Если письмо не пришло, проверьте папку "Спам".') }}</p>
                    </div>

                    <div class="verify-actions">
                        <p>{{ __('Если вы не получили письмо') }},</p>
                        <form class="verify-resend-form" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="verify-resend-button">
                                <i class="fas fa-paper-plane"></i>
                                <span>{{ __('нажмите здесь, чтобы отправить повторно') }}</span>
                            </button>
                        </form>
                    </div>

                    <div class="verify-timer" id="resendTimer" style="display: none;">
                        <i class="fas fa-clock"></i>
                        <span>{{ __('Повторная отправка через:') }}</span>
                        <span class="timer-count" id="countdown">60</span>
                        <span>{{ __('сек') }}</span>
                    </div>

                    <div class="verify-tips">
                        <h3><i class="fas fa-lightbulb"></i> {{ __('Советы:') }}</h3>
                        <ul>
                            <li><i class="fas fa-search"></i> {{ __('Проверьте папку "Спам" или "Рассылки"') }}</li>
                            <li><i class="fas fa-envelope"></i> {{ __('Убедитесь в правильности email адреса') }}</li>
                            <li><i class="fas fa-sync-alt"></i> {{ __('Подождите несколько минут') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection