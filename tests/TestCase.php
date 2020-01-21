<?php


namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\LaravelSaaSServiceProvider;
use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\Tenant;
use GeorgeHanson\SaaS\Tests\Resources\FakePaymentGateway;
use GeorgeHanson\SaaS\Tests\Resources\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Setup the tests.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations();
        $this->withFactories(__DIR__ . '/../database/factories');
        $this->withFactories(__DIR__ . '/factories');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->app->bind(PaymentGateway::class, function () {
            return app(FakePaymentGateway::class);
        });
    }

    /**
     * Create a tenant and a user for that tenant.
     *
     * @return User
     */
    public function createUserAndTenant()
    {
        $tenant = (new Tenant())->create('ABC Industries');
        return factory(User::class)->create(['tenant_id' => $tenant->id]);
    }

    /**
     * Get the package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelSaaSServiceProvider::class
        ];
    }

    /**
     * Get environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        Hash::setRounds(4);
        $app['config']->set('saas.user_model', User::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }
}
