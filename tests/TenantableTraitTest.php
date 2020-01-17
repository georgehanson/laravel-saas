<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Tests\Resources\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantableTraitTest extends TestCase
{

    public function testIfTheModelIsTenantableItInsertsTheTenantId()
    {
        $user = $this->createUserAndTenant();
        $this->actingAs($user);

        $customer = Customer::create(['name' => 'My Customer']);

        $this->assertEquals($user->tenant_id, $customer->tenant_id);
    }

    public function testIfTheModelIsTenantableItOnlyQueriesRecordsForThatTenant()
    {
        $bill = $this->createUserAndTenant();
        Customer::create(['name' => 'My Customer', 'tenant_id' => $bill->tenant_id]);
        Customer::create(['name' => 'My Customer', 'tenant_id' => $bill->tenant_id]);
        Customer::create(['name' => 'My Customer', 'tenant_id' => $bill->tenant_id]);

        $ben = $this->createUserAndTenant();
        Customer::create(['name' => 'My Customer', 'tenant_id' => $ben->tenant_id]);
        Customer::create(['name' => 'My Customer', 'tenant_id' => $ben->tenant_id]);

        $this->actingAs($bill);
        $this->assertCount(3, Customer::all());

        $this->actingAs($ben);
        $this->assertCount(2, Customer::all());
    }

    public function testIfAModelIsTenantableItCanAccessTheTenantModel()
    {
        $bill = $this->createUserAndTenant();
        $customer = Customer::create(['name' => 'My Customer', 'tenant_id' => $bill->tenant_id]);

        $this->assertEquals($bill->tenant_id, $customer->tenant->id);
    }
}
