<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'product_id',
        'user_id',
        'status',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
    ];

    /**
     * Товар в корзине
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Пользователь корзины
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Общая стоимость позиции
     */
    public function getTotalAttribute(): float
    {
        return $this->product->price * $this->count;
    }
}
