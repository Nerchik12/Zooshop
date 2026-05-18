@extends('admin.layout')

@section('title', 'Создать промокод')
@section('page-title', 'СОЗДАТЬ ПРОМОКОД')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 2rem;">
            <form method="POST" action="{{ route('admin.promocodes.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Код промокода <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" placeholder="Например: WELCOME20" required>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Код будет автоматически преобразован в верхний регистр</small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Тип скидки <span class="text-danger">*</span></label>
                        <select class="form-select @error('discount_type') is-invalid @enderror" name="discount_type" required>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Процент (%)</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Фиксированная (₽)</option>
                        </select>
                        @error('discount_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Значение скидки <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('discount_value') is-invalid @enderror" name="discount_value" value="{{ old('discount_value') }}" placeholder="10" step="0.01" min="0.01" required>
                        @error('discount_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Мин. сумма заказа</label>
                        <input type="number" class="form-control @error('min_order_amount') is-invalid @enderror" name="min_order_amount" value="{{ old('min_order_amount') }}" placeholder="1000" min="0" step="0.01">
                        @error('min_order_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Оставьте пустым, если ограничения нет</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Макс. количество использований</label>
                        <input type="number" class="form-control @error('max_uses') is-invalid @enderror" name="max_uses" value="{{ old('max_uses') }}" placeholder="100" min="1">
                        @error('max_uses') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Оставьте пустым, если без ограничений</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Действует до</label>
                        <input type="date" class="form-control @error('expires_at') is-invalid @enderror" name="expires_at" value="{{ old('expires_at') }}">
                        @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Оставьте пустым, если бессрочно</small>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-purple px-4">
                        <i class="bi bi-check-lg me-2"></i>СОЗДАТЬ ПРОМОКОД
                    </button>
                    <a href="{{ route('admin.promocodes') }}" class="btn btn-outline-secondary px-4">ОТМЕНА</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
