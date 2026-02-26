<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCart extends Model
{
    use HasFactory;

    protected $table = 'order_cart';

    protected $fillable = [
        'order_id',
        'products_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Заказ
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Товар
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    /**
     * Общая стоимость позиции
     */
    public function getTotalAttribute(): float
    {
        return $this->unit_price * $this->quantity;
    }
}
