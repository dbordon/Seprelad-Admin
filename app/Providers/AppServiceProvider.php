<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 👈 IMPORTANTE

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
