<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\SaaS;
use GeorgeHanson\SaaS\Tests\Resources\User;

class SaaSTest extends TestCase
{
    public function testIfATenantIsNotSubscribedButItEndsSoonThenSubscriptionEndsSoonIsTrue()
    {
        $tenant = Tenant::create(['name' => 'Test', 'subscription_ends_at' => now()->addWeek(), 'subscription_active' => 0]);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $this->assertTrue(SaaS::subscriptionEndingSoon());
    }

    public function testIfATenantIsSubscribedButItEndsSoonThenSubscriptionEndsSoonIsFalse()
    {
        $tenant = Tenant::create(['name' => 'Test', 'subscription_ends_at' => now()->addWeek(), 'subscription_active' => 1]);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $this->assertFalse(SaaS::subscriptionEndingSoon());
    }

    public function testTheTenantIsSubscribedIfTheyHaveANonExpiredSubscription()
    {
        $tenant = Tenant::create(['name' => 'Test', 'subscription_ends_at' => now()->addWeek(), 'subscription_active' => 1]);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $this->assertTrue(SaaS::isSubscribed());
    }

    public function testTheTenantIsSubscribedIfTheyHaveANonExpiredSubscriptionAndNonActiveSubscription()
    {
        $tenant = Tenant::create(['name' => 'Test', 'subscription_ends_at' => now()->addWeek(), 'subscription_active' => 0]);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $this->assertTrue(SaaS::isSubscribed());
    }

    public function testTheTenantIsNotSubscribedIfTheirSubscriptionHasEnded()
    {
        $tenant = Tenant::create(['name' => 'Test', 'subscription_ends_at' => now()->subWeek(), 'subscription_active' => 0]);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $this->assertFalse(SaaS::isSubscribed());
    }

    public function testTheTenantIsNotSubscribedIfTheirSubscriptionHasEndedEvenIfItIsActive()
    {
        $tenant = Tenant::create(['name' => 'Test', 'subscription_ends_at' => now()->subWeek(), 'subscription_active' => 1]);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $this->assertFalse(SaaS::isSubscribed());
    }
}
