<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 👈 IMPORTANTE
use Laravel\Sanctum\Sanctum;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
                 Sanctum::ignoreMigrations();

        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 👇 ACTIVAMOS EL ESTILO BOOTSTRAP EN LA PAGINACIÓN
        Paginator::useBootstrap();
    }
}
