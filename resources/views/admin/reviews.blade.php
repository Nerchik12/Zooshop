@extends('admin.layout')

@section('title', 'Отзывы')
@section('page-title', 'Управление отзывами')

@section('content')
<div class="admin-table">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">ВСЕ ОТЗЫВЫ ({{ $reviews->total() }})</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Товар</th>
                    <th>Пользователь</th>
                    <th>Рейтинг</th>
                    <th>Текст отзыва</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <td><strong>{{ $review->id }}</strong></td>
                    <td>
                        <a href="{{ route('product', $review->product_id) }}" target="_blank" class="text-decoration-none">
                            {{ Str::limit($review->product_name, 40) }}
                        </a>
                    </td>
                    <td>
                        <div>{{ $review->user_name }}</div>
                        <small class="text-muted">{{ $review->user_email }}</small>
                    </td>
                    <td>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span class="star-filled">★</span>
                                @else
                                    <span class="star-empty">☆</span>
                                @endif
                            @endfor
                            <span class="rating-value">({{ $review->rating }}/5)</span>
                        </div>
                    </td>
                    <td>
                        <span class="review-text-preview">{{ Str::limit($review->review_text, 50) }}</span>
                    </td>
                    <td>{{ date('d.m.Y H:i', strtotime($review->created_at)) }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('product', $review->product_id) }}#reviews" class="btn btn-sm btn-outline-purple" target="_blank" title="Посмотреть на сайте">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить этот отзыв?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Удалить отзыв">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <div class="p-4 border-top">
        {{ $reviews->links() }}
    </div>
    @endif
</div>

<style>
.rating-stars {
    display: flex;
    align-items: center;
    gap: 2px;
}

.star-filled {
    color: #FF8C42;
    font-size: 1.2rem;
}

.star-empty {
    color: #ddd;
    font-size: 1.2rem;
}

.rating-value {
    margin-left: 5px;
    font-size: 0.85rem;
    color: #666;
}

.review-text-preview {
    max-width: 300px;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endsection
