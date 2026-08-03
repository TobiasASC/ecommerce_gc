<?php

// 1. Crear el ecosistema de carpetas en la memoria RAM de Vercel
$tmp = '/tmp/laravel';
$directorios = [
    "$tmp/storage/framework/views",
    "$tmp/storage/framework/cache/data",
    "$tmp/storage/framework/sessions",
    "$tmp/storage/logs",
    "$tmp/bootstrap/cache",
];

foreach ($directorios as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Obligar a Laravel a usar esta zona libre para TODO su caché
$variables = [
    'APP_CONFIG_CACHE' => "$tmp/bootstrap/cache/config.php",
    'APP_EVENTS_CACHE' => "$tmp/bootstrap/cache/events.php",
    'APP_PACKAGES_CACHE' => "$tmp/bootstrap/cache/packages.php",
    'APP_ROUTES_CACHE' => "$tmp/bootstrap/cache/routes.php",
    'APP_SERVICES_CACHE' => "$tmp/bootstrap/cache/services.php",
    'VIEW_COMPILED_PATH' => "$tmp/storage/framework/views",
];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 3. Encender la aplicación de forma segura
require __DIR__ . '/../public/index.php';