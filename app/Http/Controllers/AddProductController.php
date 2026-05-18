<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AddProductController extends Controller
{
    public function add_product(){
        $categories = DB::table('categories')->orderBy('name')->get();
        $animalTypes = ['Кошка', 'Собака', 'Птица', 'Грызун', 'Все'];
        return view('add_product', compact('categories', 'animalTypes'));
    }

    public function img(Request $request){
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'description' => 'required|string',
                'price' => 'required|string',
                'category_id' => 'required|integer|exists:categories,id',
                'year' => 'required|integer|min:2000|max:'.(date('Y')+1),
                'country' => 'required|string|max:100',
                'model' => 'required|string|max:100',
                'in_stock' => 'required|integer|min:0',
                'animal_type' => 'required|string|in:Кошка,Собака,Птица,Грызун,Все'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with([
                        'msg' => 'Ошибка валидации: ' . $validator->errors()->first(),
                        'msg_type' => 'danger'
                    ]);
            }

            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $typeImg = $img->extension();
                $uniqName = Str::uuid();
                $nameImg = $uniqName . '.' . $typeImg;

                $folderPath = public_path('img');

                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, 0755, true);
                }

                $img->move($folderPath, $nameImg);

                $imagePath = '/img/' . $nameImg;

            } else {
                $imagePath = '/img/default-product.jpg';
            }

            $category = DB::table('categories')
                ->where('id', $request->category_id)
                ->value('name');

            DB::table('products')->insert([
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
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('add_product')->with([
                'msg' => 'Товар успешно добавлен!',
                'msg_type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'msg' => 'Ошибка: ' . $e->getMessage(),
                'msg_type' => 'danger'
            ]);
        }
    }
}
