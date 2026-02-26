<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function sendReviews(){
    return view('review');
}
public function sendReview(Request $request)
{
    // Валидация
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'regex:/^(\+?[1-9]\d{1,14})$/'],
        'email' => ['required', 'email', 'max:255'],
        'message' => ['nullable', 'string', 'max:1000']
    ], [
        'name.required' => 'Имя обязательно для заполнения!',
        'phone.required' => 'Телефон обязателен для заполнения!',
        'phone.regex' => 'Телефон введен в неправильном формате! Пример: +79999999999',
        'email.email' => 'Некорректный E-mail!',
        'email.required' => 'E-mail обязателен для заполнения!'
    ]);
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }
    
    // Проверяем, если пользователь авторизован
    if (auth()->check()) {
        $userId = auth()->id();
        
        // Проверяем, есть ли уже отзыв от этого пользователя
        $existingReview = DB::table('feedback')
            ->where('user_id', $userId)
            ->first();
            
        if ($existingReview) {
            return back()->withErrors([
                'error' => 'Вы уже оставляли отзыв. Один пользователь может оставить только один отзыв.'
            ])->withInput();
        }
    }
    
    // Подготавливаем данные
    $data = [
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'message' => $request->message ?: '',
        'created_at' => now(),
        'updated_at' => now()
    ];
    
    // Если пользователь авторизован, добавляем его ID
    if (auth()->check()) {
        $data['user_id'] = auth()->id();
        // Можно также автоматически взять имя и email из профиля
        if (empty($request->name) && auth()->user()->name) {
            $data['name'] = auth()->user()->name;
        }
        if (empty($request->email) && auth()->user()->email) {
            $data['email'] = auth()->user()->email;
        }
    }
    
    // Добавляем отзыв
    DB::table('feedback')->insert($data);
    
    return back()->with('success', 'Ваш отзыв успешно отправлен!');
}
    }