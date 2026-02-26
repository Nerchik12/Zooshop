<?php
// Очистка кэша Laravel
echo "Очистка кэша...\n";

// Config cache
exec('php artisan config:clear', $output, $return);
echo "Config: " . ($return === 0 ? "OK" : "ERROR") . "\n";

// Cache
exec('php artisan cache:clear', $output, $return);
echo "Cache: " . ($return === 0 ? "OK" : "ERROR") . "\n";

// View cache
exec('php artisan view:clear', $output, $return);
echo "View: " . ($return === 0 ? "OK" : "ERROR") . "\n";

echo "\nГотово! Обновите страницу (Ctrl+F5)";
