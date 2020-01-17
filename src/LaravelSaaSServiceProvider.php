<?php

namespace GeorgeHanson\SaaS;

use Illuminate\Support\ServiceProvider;

class LaravelSaaSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/saas.php' => config_path('saas.php')
        ]);

        $this->loadMigrationsFrom([
            __DIR__.'/../database/migrations'
        ]);
    }
}
