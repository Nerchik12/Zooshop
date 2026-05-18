<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = DB::table('users')->count();
        $totalAdmins = DB::table('users')->where('role', 'admin')->count();
        $totalOrders = DB::table('orders')->count();
        $totalProducts = DB::table('products')->count();
        $totalRevenue = DB::table('orders')->sum('total_amount');

        $recentOrders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name')
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        $recentUsers = DB::table('users')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.index', compact(
            'totalUsers',
            'totalAdmins',
            'totalOrders',
            'totalProducts',
            'totalRevenue',
            'recentOrders',
            'recentUsers'
        ));
    }

    public function users()
    {
        $users = DB::table('users')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function makeAdmin($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя изменить свою собственную роль.');
        }

        DB::table('users')->where('id', $id)->update(['role' => 'admin']);

        return redirect()->back()->with('success', "Пользователь {$user->name} теперь администратор.");
    }

    public function makeUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя изменить свою собственную роль.');
        }

        $adminCount = DB::table('users')->where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return redirect()->back()->with('error', 'Должен остаться хотя бы один администратор.');
        }

        DB::table('users')->where('id', $id)->update(['role' => 'user']);

        return redirect()->back()->with('success', "Пользователь {$user->name} теперь обычный пользователь.");
    }

    public function resetPassword($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя сбросить свой собственный пароль.');
        }

        $temporaryPassword = 'admin123';
        DB::table('users')->where('id', $id)->update(['password' => Hash::make($temporaryPassword)]);

        return redirect()->back()->with('success', "Пароль пользователя {$user->name} сброшен. Временный пароль: {$temporaryPassword}");
    }

    public function deleteUser($id)
    {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя удалить самого себя.');
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            DB::table('orders')->where('user_id', $id)->delete();
            DB::table('cart')->where('user_id', $id)->delete();
            DB::table('reviews')->where('user_id', $id)->delete();
            DB::table('feedback')->where('user_id', $id)->delete();

            DB::table('users')->where('id', $id)->delete();

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

            return redirect()->route('admin.users')->with('success', "Пользователь {$user->name} удалён.");
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            return redirect()->back()->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }

    public function reviews()
    {
        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->select(
                'reviews.*',
                'users.name as user_name',
                'users.email as user_email',
                'products.name as product_name',
                'products.id as product_id'
            )
            ->orderBy('reviews.created_at', 'desc')
            ->paginate(20);

        return view('admin.reviews', compact('reviews'));
    }

    public function deleteReview($id)
    {
        DB::table('reviews')->where('id', $id)->delete();
        return redirect()->route('admin.reviews')->with('success', 'Отзыв удалён.');
    }

    public function orders()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = DB::table('orders')->where('id', $id)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Заказ не найден.');
        }

        $request->validate([
            'status' => 'required|in:active,pending,completed,cancelled',
        ]);

        DB::table('orders')
            ->where('id', $id)
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Статус заказа #{$order->id} обновлён.");
    }

    public function products()
    {
        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->orderBy('products.created_at', 'desc')
            ->paginate(20);

        return view('admin.products', compact('products'));
    }

    public function editProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Товар не найден.');
        }

        $categoryName = DB::table('categories')->where('id', $product->category_id)->value('name');

        $categories = DB::table('categories')->orderBy('name')->get();
        $animalTypes = ['Кошка', 'Собака', 'Птица', 'Грызун', 'Все'];

        return view('admin.edit-product', compact('product', 'categories', 'categoryName', 'animalTypes'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'required|string',
            'price' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'year' => 'required|integer|min:2000|max:'.(date('Y')+1),
            'country' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'in_stock' => 'required|integer|min:0',
            'animal_type' => 'required|string|in:Кошка,Собака,Птица,Грызун,Все'
        ]);

        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Товар не найден.');
        }

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $typeImg = $img->extension();
            $uniqName = \Illuminate\Support\Str::uuid();
            $nameImg = $uniqName . '.' . $typeImg;

            $folderPath = public_path('img');

            if (!\Illuminate\Support\Facades\File::exists($folderPath)) {
                \Illuminate\Support\Facades\File::makeDirectory($folderPath, 0755, true);
            }

            $img->move($folderPath, $nameImg);
            $imagePath = '/public/img/' . $nameImg;
        }

        $category = DB::table('categories')
            ->where('id', $request->category_id)
            ->value('name');

        DB::table('products')->where('id', $id)->update([
            'name' => $request->name,
            'image' => $imagePath,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $category,
            'category_id' => $request->category_id,
            'year' => $request->year,
            'country' => $request->country,
            'model' => $request->model,
            'in_stock' => $request->in_stock,
            'animal_type' => $request->animal_type,
            'updated_at' => now()
        ]);

        return redirect()->route('admin.products')->with('success', 'Товар успешно обновлён!');
    }

    public function deleteProduct($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('admin.products')->with('success', 'Товар удалён.');
    }

    public function promocodes()
    {
        $promocodes = DB::table('promo_codes')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.promocodes', compact('promocodes'));
    }

    public function createPromocode()
    {
        return view('admin.create-promocode');
    }

    public function storePromocode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date'
        ]);

        DB::table('promo_codes')->insert([
            'code' => strtoupper($request->code),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount ?: null,
            'max_uses' => $request->max_uses ?: null,
            'used_count' => 0,
            'is_active' => true,
            'expires_at' => $request->expires_at ?: null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.promocodes')->with('success', "Промокод {$request->code} успешно создан!");
    }

    public function deletePromocode($id)
    {
        $promo = DB::table('promo_codes')->where('id', $id)->first();

        if (!$promo) {
            return redirect()->route('admin.promocodes')->with('error', 'Промокод не найден.');
        }

        DB::table('promo_codes')->where('id', $id)->delete();

        return redirect()->route('admin.promocodes')->with('success', "Промокод {$promo->code} удалён.");
    }
}
