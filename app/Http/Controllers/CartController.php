<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function cart(){
   $cart=DB::table("cart")
       ->join('products','products.id','=','cart.product_id')
       ->where('user_id', Auth()->user()->id)
       ->get();
    return view('cart',['cart'=>$cart]);
}
public function add(Request $request){
    // Проверяем количество товара на складе
    $product = DB::table('products')->where('id', $request->id)->first();

    if (!$product) {
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Товар не найден']);
        }
        return redirect()->back()->with('error', 'Товар не найден');
    }

    // Проверяем наличие
    if ($product->in_stock <= 0) {
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Товар закончился на складе']);
        }
        return redirect()->back()->with('error', 'Товар закончился на складе');
    }

    // Получаем количество из запроса (по умолчанию 1)
    $quantity = (int)$request->quantity;
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Проверяем сколько уже в корзине
    $cartItem = DB::table('cart')
        ->where('user_id', Auth()->user()->id)
        ->where('product_id', $request->id)
        ->where('status', 'active')
        ->first();

    if ($cartItem) {
        // Товар уже в корзине - увеличиваем количество
        $newCount = $cartItem->count + $quantity;

        // Проверяем хватает ли на складе
        if ($newCount > $product->in_stock) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Недостаточно товара на складе']);
            }
            return redirect()->back()->with('error', 'Недостаточно товара на складе');
        }

        DB::table('cart')
            ->where('user_id', Auth()->user()->id)
            ->where('product_id', $request->id)
            ->update(['count' => $newCount]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Количество товара увеличено']);
        }
        return redirect()->back()->with('success', 'Количество товара увеличено');
    } else {
        // Добавляем новый товар в корзину
        DB::table('cart')->insert([
            'user_id' => Auth()->user()->id,
            'product_id' => $request->id,
            'status' => 'active',
            'count' => $quantity
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Товар добавлен в корзину']);
        }
        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }
}

   public function remove(Request $request){
       DB::table('cart')->where('user_id', Auth()->user()->id)->where('product_id', $request->id)->delete();
       return redirect()->back();
   }
    public function remove_add(Request $request){
        DB::table('cart')->where('user_id', Auth()->user()->id)->delete();
        return redirect()->back();
    }

    public function updateQuantity(Request $request){
    $userId = Auth()->user()->id;
    $productId = $request->id;
    $newCount = $request->count;
    
    // что количество не меньше 1
    if($newCount < 1) {
        $newCount = 1;
    }
    
    //  наличие товара на складе
    $inStock = DB::table('products')
        ->where('id', $productId)
        ->value('in_stock');
    
    if($newCount > $inStock) {
        $newCount = $inStock;
    }
    
    DB::table('cart')
        ->where('user_id', $userId)
        ->where('product_id', $productId)
        ->update(['count' => $newCount]);
    
    return redirect()->back();
}

public function add_order(){
    $userId = auth()->user()->id;
    
    // товары из корзины
    $cart_items = DB::table('cart')
        ->join('products', 'products.id', '=', 'cart.product_id')
        ->where('cart.user_id', $userId)
        ->where('cart.status', 'active')
        ->select('cart.*', 'products.price')
        ->get();

    //  корзина не пуста
    if ($cart_items->isEmpty()) {
        return redirect()->route('cart')->with('error', 'Корзина пуста');
    }

    //  общая сумма товаров в корзине
    $totalAmount = 0;
    foreach($cart_items as $item){
        $totalAmount += $item->price * $item->count;
    }
    
    //  заказ для всех товаров
    DB::table('orders')->insert([
        'user_id' => $userId,
        'status' => 'active',
        'total_amount' => $totalAmount,
        'created_at' => now()
    ]);
    
    //  только что созданный заказ
    $order = DB::table('orders')
        ->where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->first();

    // товары из корзины в этот один заказ
    foreach($cart_items as $cart_item){
        DB::table('order_cart')->insert([
            'order_id' => $order->id, 
            'products_id' => $cart_item->product_id,
            'quantity' => $cart_item->count,
            'unit_price' => $cart_item->price
        ]);
    }
    
    //  очищаем корзину 
    DB::table('cart')
        ->where('user_id', $userId)
        ->where('status', 'active')
        ->delete();

    return redirect()->route('orders')->with('success', 'Заказ #' . $order->id . ' успешно оформлен!');
}
}

