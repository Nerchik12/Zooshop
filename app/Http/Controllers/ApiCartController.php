<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiCartController extends Controller
{
    /**
     * Получить количество товаров в корзине
     */
    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        
        $count = DB::table('cart')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->sum('count');
            
        return response()->json(['count' => $count]);
    }
}
