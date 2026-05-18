<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cart(Request $request){
       $cart = DB::table("cart")
           ->join('products','products.id','=','cart.product_id')
           ->where('cart.user_id', Auth()->user()->id)
           ->select(
               'cart.id as cart_id',
               'cart.count',
               'cart.product_id',
               'cart.status',
               'products.name',
               'products.description',
               'products.price',
               'products.image',
               'products.category',
               'products.year',
               'products.country',
               'products.model',
               'products.in_stock',
               'products.updated_at'
           )
           ->get();

        if ($request->has('promo') && $request->promo != '') {
            $promoCode = $request->promo;
            $promo = DB::table('promo_codes')
                ->where('code', $promoCode)
                ->where('is_active', true)
                ->where(function($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()->format('Y-m-d'));
                })
                ->first();

            if (!$promo) {
                session()->put('promo_error', 'Промокод не найден или истёк');
                session()->forget(['promo_discount', 'promo_type', 'promo_code']);
            } elseif ($promo->max_uses && $promo->used_count >= $promo->max_uses) {
                session()->put('promo_error', 'Промокод больше не действует');
                session()->forget(['promo_discount', 'promo_type', 'promo_code']);
            } else {
                $subtotal = 0;
                foreach($cart as $item) {
                    $subtotal += $item->price * $item->count;
                }
                if ($promo->min_order_amount && $subtotal < $promo->min_order_amount) {
                    session()->put('promo_error', 'Минимальная сумма заказа для этого промокода: ' . number_format($promo->min_order_amount, 0, '', ' ') . ' ₽');
                    session()->forget(['promo_discount', 'promo_type', 'promo_code']);
                } else {
                    session()->put('promo_discount', $promo->discount_value);
                    session()->put('promo_type', $promo->discount_type);
                    session()->put('promo_code', $promo->code);
                    session()->forget('promo_error');
                }
            }
        } else {
            session()->forget(['promo_discount', 'promo_type', 'promo_code', 'promo_error']);
        }

        return view('cart', ['cart' => $cart]);
    }

    public function add(Request $request){
        $product = DB::table('products')->where('id', $request->id)->first();

        if (!$product) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Товар не найден']);
            }
            return redirect()->back()->with('error', 'Товар не найден');
        }

        if ($product->in_stock <= 0) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Товар закончился на складе']);
            }
            return redirect()->back()->with('error', 'Товар закончился на складе');
        }

        $quantity = (int)$request->quantity;
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cartItem = DB::table('cart')
            ->where('user_id', Auth()->user()->id)
            ->where('product_id', $request->id)
            ->where('status', 'active')
            ->first();

        if ($cartItem) {
            $newCount = $cartItem->count + $quantity;

            if ($newCount > $product->in_stock) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Недостаточно товара на складе']);
                }
                return redirect()->back()->with('error', 'Недостаточно товара на складе');
            }

            DB::table('cart')
                ->where('id', $cartItem->id)
                ->update(['count' => $newCount]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Количество товара увеличено']);
            }
            return redirect()->back()->with('success', 'Количество товара увеличено');
        } else {
            DB::table('cart')->insert([
                'user_id' => Auth()->user()->id,
                'product_id' => $request->id,
                'status' => 'active',
                'count' => $quantity,
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Товар добавлен в корзину']);
            }
            return redirect()->back()->with('success', 'Товар добавлен в корзину');
        }
    }

    public function remove(Request $request){
        DB::table('cart')->where('id', $request->cart_id)->delete();
        return redirect()->back();
    }

    public function remove_add(Request $request){
        DB::table('cart')->where('user_id', Auth()->user()->id)->delete();
        return redirect()->back();
    }

    public function updateQuantity(Request $request){
        $cartId = $request->cart_id;
        $newCount = (int) $request->count;
        
        if($newCount < 1) {
            $newCount = 1;
        }
        
        $cartItem = DB::table('cart')->where('id', $cartId)->first();
        if (!$cartItem) {
            return redirect()->back();
        }
        
        $inStock = DB::table('products')
            ->where('id', $cartItem->product_id)
            ->value('in_stock');
        
        if($newCount > $inStock) {
            $newCount = $inStock;
        }
        
        DB::table('cart')
            ->where('id', $cartId)
            ->update(['count' => $newCount]);
        
        return redirect()->back();
    }

    public function add_order(){
        $userId = auth()->user()->id;
        
        $cart_items = DB::table('cart')
            ->join('products', 'products.id', '=', 'cart.product_id')
            ->where('cart.user_id', $userId)
            ->where('cart.status', 'active')
            ->select('cart.*', 'products.price')
            ->get();

        if ($cart_items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Корзина пуста');
        }

        $subtotal = 0;
        foreach($cart_items as $item){
            $subtotal += $item->price * $item->count;
        }

        $totalAmount = $subtotal;
        $promoCode = session('promo_code');
        $promoDiscount = session('promo_discount');
        $promoType = session('promo_type');

        if ($promoCode && $promoDiscount && $promoType) {
            if ($promoType == 'percent') {
                $totalAmount = $subtotal - ($subtotal * $promoDiscount / 100);
            } else {
                $totalAmount = $subtotal - min($promoDiscount, $subtotal);
            }
            $totalAmount = max($totalAmount, 0);

            DB::table('promo_codes')
                ->where('code', $promoCode)
                ->increment('used_count');
        }
        
        DB::table('orders')->insert([
            'user_id' => $userId,
            'status' => 'active',
            'total_amount' => $totalAmount,
            'created_at' => now()
        ]);
        
        $order = DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->first();

        foreach($cart_items as $cart_item){
            DB::table('order_cart')->insert([
                'order_id' => $order->id, 
                'products_id' => $cart_item->product_id,
                'quantity' => $cart_item->count,
                'unit_price' => $cart_item->price,
            ]);
        }
        
        DB::table('cart')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->delete();

        session()->forget(['promo_discount', 'promo_type', 'promo_code', 'promo_error']);

        return redirect()->route('orders')->with('success', 'Заказ #' . $order->id . ' успешно оформлен!');
    }
}
