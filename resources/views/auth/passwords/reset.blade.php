@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="password-reset-container">
                <div class="password-reset-card">
                    <div class="password-reset-header">
                        <h1 class="password-reset-title">{{ __('Сброс пароля') }}</h1>
                    </div>

                    <div class="password-reset-body">
                        <form method="POST" action="{{ route('password.update') }}" class="password-reset-form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email" class="password-reset-label">
                                    <i class="fas fa-envelope me-1"></i>{{ __('Email адрес') }}
                                </label>
                                <div class="password-reset-field">
                                    <input id="email" type="email" 
                                           class="password-reset-input @error('email') is-invalid @enderror" 
                                           name="email" value="{{ $email ?? old('email') }}" 
                                           required autocomplete="email" autofocus>
                                    <i class="password-reset-icon fas fa-at"></i>
                                </div>
                                @error('email')
                                    <span class="password-reset-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="password-reset-label">
                                    <i class="fas fa-lock me-1"></i>{{ __('Новый пароль') }}
                                </label>
                                <div class="password-reset-field">
                                    <input id="password" type="password" 
                                           class="password-reset-input @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password">
                                    <i class="password-reset-icon fas fa-key"></i>
                                </div>
                                <div class="password-strength-container">
                                    <div class="password-strength-bar">
                                        <div class="password-strength-fill" id="password-strength-bar"></div>
                                    </div>
                                    <div class="password-strength-text" id="password-strength-text">Введите пароль</div>
                                </div>
                                @error('password')
                                    <span class="password-reset-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="password-reset-label">
                                    <i class="fas fa-lock me-1"></i>{{ __('Подтвердите пароль') }}
                                </label>
                                <div class="password-reset-field">
                                    <input id="password-confirm" type="password" 
                                           class="password-reset-input" 
                                           name="password_confirmation" required autocomplete="new-password">
                                    <i class="password-reset-icon fas fa-lock"></i>
                                </div>
                            </div>

                            <button type="submit" class="password-reset-button">
                                <i class="fas fa-redo-alt"></i>
                                <span>{{ __('Сбросить пароль') }}</span>
                            </button>

                            <div class="password-reset-info">
                                <p>{{ __('Вернуться к') }} <a href="{{ route('login') }}" class="password-reset-link">авторизации</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
