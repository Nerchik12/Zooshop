<?php
/**
 * Скрипт для создания placeholder-изображений для товаров
 * Запустите: php create_placeholders.php
 */

$products = [
    ['file' => 'drill.jpg', 'text' => 'ДРЕЛЬ'],
    ['file' => 'hammer-drill.jpg', 'text' => 'ПЕРФОРАТОР'],
    ['file' => 'cement.jpg', 'text' => 'ЦЕМЕНТ'],
    ['file' => 'brick.jpg', 'text' => 'КИРПИЧ'],
    ['file' => 'paint.jpg', 'text' => 'КРАСКА'],
    ['file' => 'laminate.jpg', 'text' => 'ЛАМИНАТ'],
    ['file' => 'cable.jpg', 'text' => 'КАБЕЛЬ'],
    ['file' => 'faucet.jpg', 'text' => 'СМЕСИТЕЛЬ'],
    ['file' => 'saw.jpg', 'text' => 'ПИЛА'],
    ['file' => 'concrete-mixer.jpg', 'text' => 'БЕТОНОМЕШКА'],
    ['file' => 'insulation.jpg', 'text' => 'УТЕПЛИТЕЛЬ'],
    ['file' => 'putty.jpg', 'text' => 'ШПАКЛЁВКА'],
    ['file' => 'tape-measure.jpg', 'text' => 'РУЛЕТКА'],
    ['file' => 'fastener-set.jpg', 'text' => 'КРЕПЁЖ'],
    ['file' => 'gloves.jpg', 'text' => 'ПЕРЧАТКИ'],
    ['file' => 'overalls.jpg', 'text' => 'КОМБИНЕЗОН'],
    ['file' => 'hammer.jpg', 'text' => 'МОЛОТОК'],
    ['file' => 'level.jpg', 'text' => 'УРОВЕНЬ'],
];

$width = 400;
$height = 400;

foreach ($products as $product) {
    // Создаём изображение
    $img = imagecreatetruecolor($width, $height);
    
    // Оранжевый фон (строительный цвет)
    $bg = imagecolorallocate($img, 243, 156, 18);
    imagefill($img, 0, 0, $bg);
    
    // Белый текст
    $textColor = imagecolorallocate($img, 255, 255, 255);
    
    // Добавляем текст (используем встроенный шрифт)
    $text = $product['text'];
    $fontWidth = imagefontwidth(5);
    $fontHeight = imagefontheight(5);
    $textWidth = strlen($text) * $fontWidth;
    
    $x = ($width - $textWidth) / 2;
    $y = ($height - $fontHeight) / 2;
    
    imagestring($img, 5, $x, $y, $text, $textColor);
    
    // Сохраняем
    $filepath = __DIR__ . '/../public/img/' . $product['file'];
    imagejpeg($img, $filepath, 90);
    imagedestroy($img);
    
    echo "✓ Создано: {$product['file']}\n";
}

echo "\n✅ Все изображения созданы в папке public/img/\n";
