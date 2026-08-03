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
    }
}
