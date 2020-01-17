<?php


namespace GeorgeHanson\SaaS\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use GeorgeHanson\SaaS\Services\Tenant;

class TenantServiceTest extends TestCase
{
    use RefreshDatabase;

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
}