@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="auth-form-container">
                <div class="auth-header">
                    <div class="auth-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <h1 class="auth-title">{{ __('Вход в аккаунт') }}</h1>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-field-group">
                            <label for="phone" class="field-label">{{ __('Телефон') }}</label>
                            <div class="phone-input-wrapper">
                                <i class="bi bi-phone field-icon"></i>
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
                                <i class="bi bi-lock field-icon"></i>
                                <input id="password" type="password" class="field-input @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password">
                            </div>
                            @error('password')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="remember-me-check">
                            <input class="checkbox-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="checkbox-label" for="remember">
                                {{ __('Запомнить меня') }}
                            </label>
                        </div>

                        <div class="form-actions-row">
                            <button type="submit" class="submit-button">
                                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Войти') }}
                            </button>
                            <div class="auth-links">
                                @if (Route::has('password.request'))
                                    <a class="auth-link" href="{{ route('password.request') }}">
                                        <i class="bi bi-key"></i>{{ __('Забыли пароль?') }}
                                    </a>
                                @endif
                                <a class="auth-link" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus"></i>{{ __('Нет аккаунта? Зарегистрироваться') }}
                                </a>
                            </div>
                        </div>
                    </form>
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
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
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

.input-field-group {
    margin-bottom: 1.25rem;
}

.field-label {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.field-with-icon,
.phone-input-wrapper {
    position: relative;
}

.field-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    font-size: 1.1rem;
}

.field-input {
    width: 100%;
    padding: 12px 16px 12px 42px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    transition: border-color 0.3s;
    background: #fafafa;
}

.field-input:focus {
    outline: none;
    border-color: #FF8C42;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
}

.validation-error {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: #e74c3c;
}

.remember-me-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
}

.checkbox-input {
    width: 18px;
    height: 18px;
    accent-color: #FF8C42;
}

.checkbox-label {
    font-size: 0.9rem;
    color: #666;
}

.form-actions-row {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.submit-button {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #FF8C42, #FF6B6B);
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
    box-shadow: 0 6px 20px rgba(255, 140, 66, 0.4);
}

.auth-links {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.auth-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #FF8C42;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.2s;
}

.auth-link:hover {
    color: #e67a30;
}
</style>
@endsection
