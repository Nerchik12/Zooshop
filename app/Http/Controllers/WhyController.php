<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WhyController extends Controller
{
    /**
     * Главная страница (при нажатии на логотип)
     */
    public function index()
    {
        // Получаем последние добавленные товары (8 штук)
        $products = DB::table('products')
            ->where('in_stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('home-page', compact('products'));
    }

    /**
     * Страница "О нас"
     */
    public function why()
    {
        // Получаем последние добавленные товары (4 штуки)
        $products = DB::table('products')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();


        // Получаем отзывы для главной страницы
        $reviews = DB::table('feedback')
            ->select('feedback.*', 'users.name as user_name')
            ->leftJoin('users', 'feedback.user_id', '=', 'users.id')
            ->orderBy('feedback.created_at', 'desc')
            ->limit(3) // Берем только 3 последних отзыва для главной
            ->get();

        return view('why', [
            'products' => $products,
            'reviews' => $reviews // Добавляем отзывы
        ]);
    }

    public function add_review()
    {
        $user = Auth::user();
        
        // Получаем все отзывы
        $reviews = DB::table('feedback')
            ->select('feedback.*', 'users.name as user_name')
            ->leftJoin('users', 'feedback.user_id', '=', 'users.id')
            ->orderBy('feedback.id', 'desc')
            ->get();
        
        // Проверяем, есть ли отзыв от текущего пользователя
        $userReview = null;
        if ($user) {
            $userReview = DB::table('feedback')
                ->where('user_id', $user->id)
                ->first();
        }
        
        return view('review', compact('reviews', 'userReview'));
    }
}