@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="auth-form-container">
                <div class="auth-header">
                    <div class="auth-icon">
                        <i class="bi bi-key"></i>
                    </div>
                    <h1 class="auth-title">{{ __('Сброс пароля') }}</h1>
                </div>

                <div class="auth-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <p class="text-muted mb-4">{{ __('Введите ваш email, и мы отправим вам ссылку для сброса пароля.') }}</p>

                        <div class="input-field-group">
                            <label for="email" class="field-label">{{ __('Email адрес') }}</label>
                            <div class="field-with-icon">
                                <i class="bi bi-envelope field-icon"></i>
                                <input id="email" type="email" 
                                       class="field-input @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email"
                                       placeholder="example@email.com">
                            </div>
                            @error('email')
                                <span class="validation-error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="submit-button">
                            <i class="bi bi-send me-2"></i>{{ __('Отправить ссылку для сброса') }}
                        </button>

                        <div class="auth-links mt-4">
                            <a class="auth-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i>{{ __('Войти в аккаунт') }}
                            </a>
                            <a class="auth-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i>{{ __('Зарегистрироваться') }}
                            </a>
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

.field-with-icon {
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
    border-color: #20B2AA;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
}

.validation-error {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: #e74c3c;
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
    color: #20B2AA;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.2s;
}

.auth-link:hover {
    color: #17a589;
}
</style>
@endsection
