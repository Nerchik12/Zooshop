<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'year',
        'country',
        'model',
        'in_stock',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'in_stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Категория товара
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Отзывы о товаре
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Товар в корзине
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Позиции в заказах
     */
    public function orderItems()
    {
        return $this->hasMany(OrderCart::class, 'products_id');
    }

    /**
     * Проверка наличия
     */
    public function isInStock(): bool
    {
        return $this->in_stock > 0;
    }

    /**
     * Есть ли старая цена (скидка)
     */
    public function hasDiscount(): bool
    {
        return false;
    }
}
