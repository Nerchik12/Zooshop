<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function catalog(Request $request)
    {
        // Простой запрос к таблице products
        $products = DB::table('products');

        // Поиск по названию (если пришло имя)
        if ($request->has('name')) {
            $name = $request->input('name');
            $products = $products->where('name', 'like', '%' . $name . '%');
        }

        // Фильтр по категории (если выбрана)
        if ($request->has('category')) {
            $category = $request->input('category');
            if ($category != '') {
                $products = $products->where('category', $category);
            }
        }

        // Фильтр по наличию
        if ($request->has('in_stock') && $request->input('in_stock') == '1') {
            $products = $products->where('in_stock', '>', 0);
        }

        // Фильтр по цене
        if ($request->has('min_price') && $request->input('min_price') != '') {
            $products = $products->where('price', '>=', $request->input('min_price'));
        }
        if ($request->has('max_price') && $request->input('max_price') != '') {
            $products = $products->where('price', '<=', $request->input('max_price'));
        }

        // Сортировка
        $sort = $request->input('sort', 'id_desc');
        if ($sort == 'price_asc') {
            $products = $products->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $products = $products->orderBy('price', 'desc');
        } elseif ($sort == 'name_asc') {
            $products = $products->orderBy('name', 'asc');
        } elseif ($sort == 'name_desc') {
            $products = $products->orderBy('name', 'desc');
        } elseif ($sort == 'in_stock_desc') {
            $products = $products->orderBy('in_stock', 'desc');
        } else {
            $products = $products->orderBy('id', 'desc');
        }

        // Получаем все товары
        $products = $products->get();

        // Получаем список категорий для выпадающего списка
        $categories = DB::table('categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        // Передаем на страницу
        return view('catalog', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}