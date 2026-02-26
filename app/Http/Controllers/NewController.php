<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewController extends Controller
{
 public function home(){
     return view('home');
 }

 public function welcome(){
     // Получаем все товары для главной страницы
     $products = DB::table('products')
         ->where('in_stock', '>', 0)
         ->orderBy('created_at', 'desc')
         ->get();
     
     return view('welcome', compact('products'));
 }
}
