@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1 class="auth-title">{{ __('Регистрация') }}</h1>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="input-field-group">
                            <label for="name" class="field-label">{{ __('Имя') }}</label>
                            <div class="field-with-icon">
                                <input id="name" type="text" class="field-input @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <i class="field-icon fas fa-user"></i>
                            </div>
                            @error('name')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-field-group">
                            <label for="email" class="field-label">{{ __('Email') }}</label>
                            <div class="field-with-icon">
                                <input id="email" type="email" class="field-input @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email">
                                <i class="field-icon fas fa-envelope"></i>
                            </div>
                            @error('email')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-field-group">
                            <label for="phone" class="field-label">{{ __('Телефон') }}</label>
                            <div class="phone-input-wrapper">
                                
                                <input id="phone" type="text" class="field-input phone-input @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}" required autocomplete="phone" 
                                       placeholder="79123456789">
                            </div>
                            @error('phone')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-field-group">
                            <label for="password" class="field-label">{{ __('Пароль') }}</label>
                            <div class="field-with-icon">
                                <input id="password" type="password" class="field-input @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                                <i class="field-icon fas fa-lock"></i>
                            </div>

                            @error('password')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="input-field-group">
                            <label for="password-confirm" class="field-label">{{ __('Повторите пароль') }}</label>
                            <div class="field-with-icon">
                                <input id="password-confirm" type="password" class="field-input" 
                                       name="password_confirmation" required autocomplete="new-password">
                                <i class="field-icon fas fa-lock"></i>
                            </div>
                        </div>

                        <div class="terms-agreement">
                            <div class="remember-me-check">
                                <input class="checkbox-input" type="checkbox" name="terms" id="terms" required>
                                <label class="checkbox-label" for="terms">
                                    {{ __('Я согласен с условиями использования') }}
                                </label>
                            </div>
                            <p class="terms-text">
                                Нажимая кнопку "Зарегистрироваться", вы принимаете наши 
                                <a href="#" class="terms-link">Условия использования</a> и 
                                <a href="#" class="terms-link">Политику конфиденциальности</a>.
                            </p>
                        </div>

                        <div class="form-actions-row">
                            <button type="submit" class="submit-button">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Зарегистрироваться') }}
                            </button>
                            <div class="auth-links">
                                <a class="auth-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i>{{ __('Уже есть аккаунт? Войти') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection