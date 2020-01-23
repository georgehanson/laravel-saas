<?php

namespace GeorgeHanson\SaaS;

use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\PaymentGateways\Stripe;
use GeorgeHanson\SaaS\Services\Tenant;
use Illuminate\Support\ServiceProvider;
use Stripe\Customer;

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

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
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

        $this->app->singleton('saas.services.tenant', function () {
            return app(Tenant::class);
        });

        $this->app->singleton('saas.stripe.customer', function () {
            return app(Customer::class);
        });

        \Stripe\Stripe::setApiKey(config('saas.billing.stripe.secret_key'));
    }
}
