<?php

namespace GeorgeHanson\SaaS;

use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\PaymentGateways\Stripe;
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

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes');
        $this->loadViewsFrom(__DIR__.'/../views', 'saas');
    }

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/saas.php', 'saas');

        $this->app->singleton(PaymentGateway::class, function () {
            return app(Stripe::class);
        });

        \Stripe\Stripe::setApiKey(config('saas.billing.stripe.secret_key'));
    }
}
