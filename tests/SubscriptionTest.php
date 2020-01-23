<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Exceptions\WebhookCouldNotBeVerifiedException;
use GeorgeHanson\SaaS\SaaS;
use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\Webhooks;
use GeorgeHanson\SaaS\Tests\Resources\StripeEvent;
use GeorgeHanson\SaaS\Tests\Resources\User;
use Mockery;
use Stripe\Checkout\Session;
use Stripe\Event;

class SubscriptionTest extends TestCase
{
    public function testWhenSubscribingTheUserMustProvideAPlan()
    {
        $this->json('POST', '/saas/subscribe', [])->assertStatus(422)->assertJsonValidationErrors([
            'plan' => 'The plan field is required.'
        ]);
    }

    public function testWhenSubscribingItGeneratesASessionToken()
    {
        $this->withoutExceptionHandling();
        $tenant = Tenant::create(['name' => 'ABC']);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $session = new class {
            public $id = 'plan-a-session-token';
        };

        $gateway = Mockery::mock(PaymentGateway::class)
            ->shouldReceive('createSessionToken')
            ->once()->andReturnSelf()->getMock()
            ->shouldReceive('forPlan')->once()->with('plan-a')->andReturnSelf()->getMock()
            ->shouldReceive('create')->once()->andReturn($session)->getMock();

        app()->instance(PaymentGateway::class, $gateway);

        $this->post('/saas/subscribe', ['plan' => 'plan-a'])
            ->assertStatus(200)
            ->assertSee($session->id);
    }

    public function testTheSubscriptionCanBeUpdated()
    {
        $this->withoutExceptionHandling();
        $tenant = Tenant::create(['name' => 'ABC']);
        $user = factory(User::class)->create(['tenant_id' => $tenant->id]);
        $this->actingAs($user);

        $session = new class {
            public $id = 'plan-a-session-token';
        };

        $gateway = Mockery::mock(PaymentGateway::class)
            ->shouldReceive('createSessionToken')
            ->once()->andReturnSelf()->getMock()
            ->shouldReceive('toUpdate')->once()->andReturn($session)->getMock();

        app()->instance(PaymentGateway::class, $gateway);

        $this->post('/saas/subscribe/update', [])
            ->assertStatus(200)
            ->assertSee($session->id);
    }
}
