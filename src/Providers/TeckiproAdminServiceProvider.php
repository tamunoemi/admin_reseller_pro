<?php

namespace Teckipro\Admin\Providers;

use Illuminate\Support\ServiceProvider;


class TeckiproAdminServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/auth.php');

        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'teckiproadmin');

        $this->loadMigrationsFrom(__DIR__.'/../Database/');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'teckiproadmin');

        //Front end site assets
        $this->publishes([
            __DIR__.'/../public/site' => public_path('vendor/plans'),
        ], 'teckiproadmin-plans-public');

        //Package dependencies assets
        $this->publishes([
            __DIR__.'/../public/package-dep' => public_path('vendor/package-dep'),
        ], 'teckiproadmin-package-dep-public');

        $this->publishes([
            __DIR__.'/../Config/Teckiproadmin.php' => config_path('teckiproadmin.php'),
        ],'teckiproadmin-config');


    }
}
