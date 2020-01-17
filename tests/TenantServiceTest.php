<?php


namespace GeorgeHanson\SaaS\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use GeorgeHanson\SaaS\Services\Tenant;

class TenantServiceTest extends TestCase
{

    public function testATenantCanBeCreated()
    {
        (new Tenant())->create('ABC Industries');
        $this->assertDatabaseHas('tenants', ['name' => 'ABC Industries']);
    }

    public function testAUserCanBeCreatedForTheTenant()
    {
        (new Tenant())->create('ABC Industries')
            ->users()
            ->create(['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password']);

        $this->assertDatabaseHas('users', ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'password']);
    }

    public function testIfBillingIsEnabledACustomerIsCreatedWhenCreatingTheTenant()
    {
        $tenant = (new Tenant())->create('ABC Industries');
        $this->assertNotNull($tenant->fresh()->customer_id);
    }
}