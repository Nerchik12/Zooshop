<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Проверка на администратора
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Проверка на обычного пользователя
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Получить роль пользователя
     */
    public function getRoleNameAttribute(): string
    {
        return $this->role === 'admin' ? 'Администратор' : 'Пользователь';
    }

    /**
     * Отзывы пользователя
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Заказы пользователя
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Товары в корзине
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Обратная связь
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
