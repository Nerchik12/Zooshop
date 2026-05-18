<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();
        
        $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach($orders as $order) {
            $firstProduct = DB::table('order_cart')
                ->select('products.name as product_name')
                ->join('products', 'products.id', '=', 'order_cart.products_id')
                ->where('order_cart.order_id', $order->id)
                ->first();
                
            $order->product_name = $firstProduct ? $firstProduct->product_name : 'Товары в заказе';
            
            $order->products = DB::table('order_cart')
                ->select(
                    'products.name as product_name',
                    'order_cart.quantity',
                    'order_cart.unit_price',
                    DB::raw('order_cart.quantity * order_cart.unit_price as item_total')
                )
                ->join('products', 'products.id', '=', 'order_cart.products_id')
                ->where('order_cart.order_id', $order->id)
                ->get();
                
            $order->order_total = $order->products->sum('item_total');
            $order->total_items = $order->products->sum('quantity');
        }
        
        $totalOrders = DB::table('orders')
            ->where('user_id', $userId)
            ->count();
            
        $processingOrders = DB::table('orders')
            ->where('user_id', $userId)
            ->where('status', 'processing')
            ->count();
            
        $completedOrders = DB::table('orders')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
            
        $totalSpent = DB::table('orders')
            ->where('user_id', $userId)
            ->sum('total_amount') ?? 0;

        return view('home', [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'processingOrders' => $processingOrders,
            'completedOrders' => $completedOrders,
            'totalSpent' => $totalSpent
        ]);
    }
}
