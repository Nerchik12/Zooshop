@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1 class="auth-title">{{ __('Вход в аккаунт') }}</h1>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                       name="password" required autocomplete="current-password">
                                <i class="field-icon fas fa-lock"></i>
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
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Войти') }}
                            </button>
                            <div class="auth-links">
                                @if (Route::has('password.request'))
                                    <a class="auth-link" href="{{ route('password.request') }}">
                                        <i class="fas fa-key"></i>{{ __('Забыли пароль?') }}
                                    </a>
                                @endif
                                <a class="auth-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>{{ __('Нет аккаунта? Зарегистрироваться') }}
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