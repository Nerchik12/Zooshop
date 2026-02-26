<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MapController extends Controller
{
    public function map(){
        return view("map");
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'phone' => ['required', 'regex:/^(\+?[1-9]\d{1,14})$/'],
            'email' => ['required', 'email'],
            'message' => ['nullable', 'string']
        ], [
            'name.required' => 'Имя обязательно для заполнения!',
            'phone.required' => 'Телефон обязателен для заполнения!',
            'phone.regex' => 'Телефон введен в неправильном формате!',
            'email.email' => 'Некорректный E-mail!',
            'email.required' => 'E-mail обязателен для заполнения!'
        ]);
    }
    
    public function sendFeedback(Request $request)
    {
        // Валидация
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        
        $exists = DB::table('feedback')
            ->where('email', $request->email)
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['email' => 'Отзыв с этого email уже существует']);
        }
        
        // Добавляем отзыв
        DB::table('feedback')->insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message ?: '',
            'created_at' => now()
        ]);
        
        return back()->with('success', 'Ваш отзыв успешно отправлен!');
    }
}