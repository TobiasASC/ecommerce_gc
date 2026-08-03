<?php

// 1. Crear la estructura de carpetas necesaria en la memoria temporal de Vercel
$tmpStorage = '/tmp/storage';
$directorios = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
];

foreach ($directorios as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Obligar a Laravel a usar esta zona segura para las vistas
putenv("VIEW_COMPILED_PATH={$tmpStorage}/framework/views");
$_ENV['VIEW_COMPILED_PATH'] = "{$tmpStorage}/framework/views";
$_SERVER['VIEW_COMPILED_PATH'] = "{$tmpStorage}/framework/views";

// 3. Encender la aplicación
require __DIR__ . '/../public/index.php';