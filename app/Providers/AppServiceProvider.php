<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Agrega esta importación en la parte superior
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // 2. Agrega esta línea para forzar el uso de Bootstrap
        Paginator::useBootstrapFive();

        // protección de HTTPS para Vercel
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Normaliza la URL base para que los assets se generen con el dominio correcto
        $rawAppUrl = env('APP_URL');
        if (!empty($rawAppUrl)) {
            $url = trim($rawAppUrl);
            // Si viene en formato Markdown [text](https://domain), extraer la URL
            if (preg_match('/\[.*?\]\((https?:\/\/[^)]+)\)/', $url, $matches)) {
                $url = $matches[1];
            }
            // Si no arranca con http(s), intentar extraer cualquier substring http(s)
            if (!preg_match('/^https?:\/\//', $url)) {
                if (preg_match('/(https?:\/\/[^\s]+)/', $url, $m2)) {
                    $url = $m2[1];
                }
            }
            $url = rtrim($url, '/');
            if (preg_match('/^https?:\/\//', $url)) {
                // Actualiza la configuración y fuerza la URL raíz
                config(['app.url' => $url]);
                URL::forceRootUrl($url);
            }
        }
    }
}
