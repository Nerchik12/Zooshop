@extends('admin.layout')

@section('title', 'Промокоды')
@section('page-title', 'ПРОМОКОДЫ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Управление промокодами и скидками</p>
    </div>
    <a href="{{ route('admin.promocodes.create') }}" class="btn btn-purple">
        <i class="bi bi-plus-lg me-2"></i>СОЗДАТЬ ПРОМОКОД
    </a>
</div>

<div class="admin-table">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>Код</th>
                <th>Тип</th>
                <th>Скидка</th>
                <th>Мин. заказ</th>
                <th>Использований</th>
                <th>Действует до</th>
                <th>Статус</th>
                <th class="text-end">Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promocodes as $promo)
            <tr>
                <td>
                    <span class="fw-bold" style="color: #FF8C42;">{{ $promo->code }}</span>
                </td>
                <td>
                    @if($promo->discount_type == 'percent')
                        <span class="badge badge-purple">%</span>
                    @else
                        <span class="badge badge-blue">₽</span>
                    @endif
                </td>
                <td>
                    <span class="fw-bold">
                        @if($promo->discount_type == 'percent')
                            {{ $promo->discount_value }}%
                        @else
                            {{ number_format($promo->discount_value, 0, '', ' ') }} ₽
                        @endif
                    </span>
                </td>
                <td>
                    @if($promo->min_order_amount)
                        {{ number_format($promo->min_order_amount, 0, '', ' ') }} ₽
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    @if($promo->max_uses)
                        {{ $promo->used_count }} / {{ $promo->max_uses }}
                    @else
                        {{ $promo->used_count }} / ∞
                    @endif
                </td>
                <td>
                    @if($promo->expires_at)
                        {{ date('d.m.Y', strtotime($promo->expires_at)) }}
                    @else
                        <span class="text-muted">Не ограничен</span>
                    @endif
                </td>
                <td>
                    @if($promo->is_active)
                        <span class="badge badge-green">АКТИВЕН</span>
                    @else
                        <span class="badge badge-red">НЕАКТИВЕН</span>
                    @endif
                </td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.promocodes.delete', $promo->id) }}" class="d-inline" onsubmit="return confirm('Удалить промокод {{ $promo->code }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <i class="bi bi-ticket display-4 text-muted mb-3 d-block"></i>
                    <h5>Промокодов пока нет</h5>
                    <p class="text-muted">Создайте первый промокод для привлечения клиентов</p>
                    <a href="{{ route('admin.promocodes.create') }}" class="btn btn-purple mt-2">
                        <i class="bi bi-plus-lg me-2"></i>СОЗДАТЬ ПРОМОКОД
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $promocodes->links() }}
</div>
@endsection
