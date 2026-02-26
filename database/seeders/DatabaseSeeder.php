<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@stroimaster.ru',
            'password' => bcrypt('admin123'),
            'phone' => '+7 (495) 765-43-21',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Создаем категории
        $categories = [
            ['name' => 'Инструменты', 'slug' => 'instrumenty', 'icon_class' => 'bi-hammer'],
            ['name' => 'Стройматериалы', 'slug' => 'stroymaterialy', 'icon_class' => 'bi-bricks'],
            ['name' => 'Краски', 'slug' => 'kraski', 'icon_class' => 'bi-droplet'],
            ['name' => 'Отделка', 'slug' => 'otdelka', 'icon_class' => 'bi-house-door'],
            ['name' => 'Электрика', 'slug' => 'elektrika', 'icon_class' => 'bi-lightning-charge'],
            ['name' => 'Сантехника', 'slug' => 'santekhnika', 'icon_class' => 'bi-droplet-half'],
            ['name' => 'Крепёж', 'slug' => 'krepjezh', 'icon_class' => 'bi-screwdriver'],
            ['name' => 'Сад и огород', 'slug' => 'sad-i-ogorod', 'icon_class' => 'bi-flower1'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'icon_class' => $cat['icon_class'],
                'description' => "Категория: {$cat['name']}",
                'is_active' => true,
            ]);
        }

        // Создаем товары
        $products = [
            [
                'name' => 'Дрель-шуруповёрт аккумуляторная',
                'category' => 'Инструменты',
                'price' => 4999,
                'old_price' => 5999,
                'description' => 'Профессиональная дрель-шуруповёрт с двумя аккумуляторами. Мощность 18В, крутящий момент 50 Нм.',
                'country' => 'Германия',
                'model' => 'DX-1800',
                'year' => 2024,
                'in_stock' => 25,
                'is_new' => true,
            ],
            [
                'name' => 'Перфоратор профессиональный',
                'category' => 'Инструменты',
                'price' => 8999,
                'old_price' => 10999,
                'description' => 'Мощный перфоратор для тяжелых работ. Энергия удара 3.2 Дж, три режима работы.',
                'country' => 'Япония',
                'model' => 'RH-3200',
                'year' => 2024,
                'in_stock' => 15,
                'is_new' => true,
            ],
            [
                'name' => 'Цемент М-500 (50 кг)',
                'category' => 'Стройматериалы',
                'price' => 450,
                'old_price' => null,
                'description' => 'Высококачественный портландцемент марки М-500. Подходит для всех видов строительных работ.',
                'country' => 'Россия',
                'model' => 'ПЦ 500-Д20',
                'year' => 2024,
                'in_stock' => 100,
                'is_new' => false,
            ],
            [
                'name' => 'Кирпич красный полнотелый (1000 шт)',
                'category' => 'Стройматериалы',
                'price' => 18500,
                'old_price' => 20000,
                'description' => 'Полнотелый керамический кирпич для несущих стен и фундаментов. Марка прочности М-200.',
                'country' => 'Россия',
                'model' => 'КР-200',
                'year' => 2024,
                'in_stock' => 50,
                'is_new' => false,
            ],
            [
                'name' => 'Краска интерьерная белая (10 л)',
                'category' => 'Краски',
                'price' => 2499,
                'old_price' => 2999,
                'description' => 'Моющаяся краска для внутренних работ. Устойчива к влажной уборке, без запаха.',
                'country' => 'Финляндия',
                'model' => 'WF-1000',
                'year' => 2024,
                'in_stock' => 40,
                'is_new' => true,
            ],
            [
                'name' => 'Ламинат дуб натуральный (2.5 м²)',
                'category' => 'Отделка',
                'price' => 1899,
                'old_price' => null,
                'description' => 'Ламинат 33 класса износостойкости. Влагостойкая пропитка, замковое соединение.',
                'country' => 'Бельгия',
                'model' => 'Oak-Natural-33',
                'year' => 2024,
                'in_stock' => 60,
                'is_new' => false,
            ],
            [
                'name' => 'Кабель электрический ВВГнг 3х2.5 (100 м)',
                'category' => 'Электрика',
                'price' => 8500,
                'old_price' => 9500,
                'description' => 'Медный кабель в негорючей изоляции. Для прокладки в помещениях и на открытом воздухе.',
                'country' => 'Россия',
                'model' => 'ВВГнг-LS 3х2.5',
                'year' => 2024,
                'in_stock' => 30,
                'is_new' => false,
            ],
            [
                'name' => 'Смеситель для кухни',
                'category' => 'Сантехника',
                'price' => 3499,
                'old_price' => 4299,
                'description' => 'Однорычажный смеситель с высоким изливом. Керамический картридж, хромированное покрытие.',
                'country' => 'Китай',
                'model' => 'KF-2024',
                'year' => 2024,
                'in_stock' => 20,
                'is_new' => true,
            ],
            [
                'name' => 'Набор крепежа (200 шт)',
                'category' => 'Крепёж',
                'price' => 899,
                'old_price' => null,
                'description' => 'Универсальный набор: саморезы, дюбели, шурупы. Органайзер в комплекте.',
                'country' => 'Польша',
                'model' => 'Universal-200',
                'year' => 2024,
                'in_stock' => 80,
                'is_new' => false,
            ],
            [
                'name' => 'Газонная трава (1 кг)',
                'category' => 'Сад и огород',
                'price' => 650,
                'old_price' => 799,
                'description' => 'Смесь трав для создания идеального газона. Быстрорастущая, устойчивая к вытаптыванию.',
                'country' => 'Нидерланды',
                'model' => 'GreenLawn-1kg',
                'year' => 2024,
                'in_stock' => 45,
                'is_new' => true,
            ],
        ];

        foreach ($products as $prod) {
            $category = Category::where('name', $prod['category'])->first();
            
            Product::create([
                'name' => $prod['name'],
                'slug' => Str::slug($prod['name']),
                'description' => $prod['description'],
                'full_description' => $prod['description'] . "\n\nПолное описание товара с подробными характеристиками и преимуществами.",
                'price' => $prod['price'],
                'old_price' => $prod['old_price'],
                'stock_quantity' => $prod['in_stock'],
                'category_id' => $category?->id,
                'country' => $prod['country'],
                'model' => $prod['model'],
                'year' => $prod['year'],
                'is_new' => $prod['is_new'],
                'is_bestseller' => rand(0, 1),
                'is_active' => true,
                'image' => 'img/products/' . Str::slug($prod['name']) . '.jpg',
                'rating' => rand(40, 50) / 10,
                'reviews_count' => rand(0, 20),
            ]);
        }
    }
}
