<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JwtAuthServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
//Importante agregar este providers en el archivo de conf app.php
        public function register()
    {
        require_once app_path().'/Helpers/JwtAuth.php';
    }

}
