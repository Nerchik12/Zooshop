<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product($id)
    {
        // Получаем товар
        $product = DB::table('products')->where('id', $id)->get();
        
        if ($product->isEmpty()) {
            abort(404, 'Товар не найден');
        }
        
        // Получаем отзывы для этого товара с именем пользователя
        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('reviews.product_id', $id)
            ->select(
                'reviews.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->orderBy('reviews.created_at', 'desc')
            ->get();
        
        return view('product', [
            'product' => $product,
            'reviews' => $reviews
        ]);
    }
    
    public function addReview(Request $request, $id)
    {
        // Валидация данных
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
        ]);
        
        // Проверяем авторизацию
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Для добавления отзыва необходимо авторизоваться!');
        }
        
        // Проверяем, не оставлял ли пользователь уже отзыв на этот товар
        $existingReview = DB::table('reviews')
            ->where('product_id', $id)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReview) {
            return redirect()->back()->with('error', 'Вы уже оставляли отзыв на этот товар!');
        }
        
        // Сохраняем отзыв
        DB::table('reviews')->insert([
            'product_id' => $id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'created_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Ваш отзыв успешно добавлен!');
    }
}