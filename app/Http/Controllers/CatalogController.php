<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function catalog(Request $request)
    {
        $products = DB::table('products');

        if ($request->has('name')) {
            $name = $request->input('name');
            $products = $products->where('name', 'like', '%' . $name . '%');
        }

        if ($request->has('category')) {
            $category = $request->input('category');
            if ($category != '') {
                $products = $products->where('category', $category);
            }
        }

        if ($request->has('animal_type')) {
            $animalType = $request->input('animal_type');
            if ($animalType != '') {
                if ($animalType === 'Все') {
                    // показываем все
                } else {
                    $products = $products->where(function($q) use ($animalType) {
                        $q->where('animal_type', $animalType)
                          ->orWhere('animal_type', 'Все');
                    });
                }
            }
        }

        if ($request->has('brand')) {
            $brand = $request->input('brand');
            if ($brand != '') {
                $products = $products->where('brand', $brand);
            }
        }

        if ($request->has('age')) {
            $age = $request->input('age');
            if ($age != '') {
                $products = $products->where('age', $age);
            }
        }

        if ($request->has('in_stock') && $request->input('in_stock') == '1') {
            $products = $products->where('in_stock', '>', 0);
        }

        if ($request->has('min_price') && $request->input('min_price') != '') {
            $products = $products->where('price', '>=', $request->input('min_price'));
        }
        if ($request->has('max_price') && $request->input('max_price') != '') {
            $products = $products->where('price', '<=', $request->input('max_price'));
        }

        $sort = $request->input('sort', 'popular');
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
        } elseif ($sort == 'novelty') {
            $products = $products->orderBy('id', 'desc');
        } elseif ($sort == 'popular') {
            $products = $products->orderBy('in_stock', 'desc')->orderBy('id', 'desc');
        } else {
            $products = $products->orderBy('id', 'desc');
        }

        $products = $products->get();

        $categories = DB::table('categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $animalTypes = ['Кошка', 'Собака', 'Птица', 'Грызун', 'Все'];

        $brands = DB::table('products')
            ->whereNotNull('brand')
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $ages = DB::table('products')
            ->whereNotNull('age')
            ->select('age')
            ->distinct()
            ->orderBy('age')
            ->pluck('age');

        return view('catalog', [
            'products' => $products,
            'categories' => $categories,
            'animalTypes' => $animalTypes,
            'brands' => $brands,
            'ages' => $ages
        ]);
    }
}
