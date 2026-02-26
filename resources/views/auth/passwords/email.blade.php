@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="password-request-container">
                <div class="password-request-card">
                    <div class="password-request-header">
                        <h1 class="password-request-title">{{ __('Сброс пароля') }}</h1>
                    </div>

                    <div class="password-request-body">
                        @if (session('status'))
                            <div class="password-request-alert" role="alert">
                                <i class="fas fa-check-circle"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="password-request-form">
                            @csrf

                            <div class="password-request-instructions">
                                <p>{{ __('Введите ваш email, и мы отправим вам ссылку для сброса пароля.') }}</p>
                            </div>

                            <div class="password-request-group">
                                <label for="email" class="password-request-label">{{ __('Email адрес') }}</label>
                                <div class="password-request-field">
                                    <i class="password-request-icon fas fa-envelope"></i>
                                    <input id="email" type="email" 
                                           class="password-request-input @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autocomplete="email" autofocus
                                           placeholder="example@email.com">
                                </div>
                                @error('email')
                                    <span class="password-request-error" role="alert">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="password-request-button">
                                <i class="fas fa-paper-plane"></i>
                                <span>{{ __('Отправить ссылку для сброса') }}</span>
                            </button>

                            <div class="password-request-info">
                                <p>{{ __('Вспомнили пароль?') }}</p>
                                <a href="{{ route('login') }}" class="password-request-link">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>{{ __('Войти в аккаунт') }}</span>
                                </a>
                                <p class="mt-2">{{ __('Нет аккаунта?') }}</p>
                                <a href="{{ route('register') }}" class="password-request-link">
                                    <i class="fas fa-user-plus"></i>
                                    <span>{{ __('Зарегистрироваться') }}</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
