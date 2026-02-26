<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review_text',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Товар отзыва
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Автор отзыва
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
