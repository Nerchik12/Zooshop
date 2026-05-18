<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->whereNotNull('old_price')
            ->where('old_price', '>', DB::raw('price'))
            ->orderBy(DB::raw('(old_price - price)'), 'desc')
            ->get();

        return view('sales', compact('products'));
    }
}
