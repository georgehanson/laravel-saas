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
            if (config('saas.billing.provider') === 'stripe') {
                return app(Stripe::class);
            }
        });

        \Stripe\Stripe::setApiKey(config('saas.billing.providers.stripe.api_key'));
    }
}
