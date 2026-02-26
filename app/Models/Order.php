<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    /**
     * Пользователь заказа
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Товары заказа
     */
    public function items()
    {
        return $this->hasMany(OrderCart::class, 'order_id');
    }

    /**
     * Статус заказа (текст)
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'active' => 'Активен',
            'completed' => 'Завершён',
            'cancelled' => 'Отменён',
        ];
        return $labels[$this->status] ?? $this->status;
    }
}
