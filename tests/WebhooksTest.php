<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Exceptions\WebhookCouldNotBeVerifiedException;
use GeorgeHanson\SaaS\SaaS;
use GeorgeHanson\SaaS\Services\Webhooks;
use GeorgeHanson\SaaS\Tests\Resources\StripeEvent;
use GeorgeHanson\SaaS\Tests\Resources\User;
use Mockery;
use Stripe\Event;

class WebhooksTest extends TestCase
{
    public function testIfTheWebhookSignatureCanNotBeVerifiedItReturnsA403Response()
    {
        $mock = Mockery::mock(Webhooks::class)->shouldReceive('verify')->once()->andThrow(WebhookCouldNotBeVerifiedException::class)->getMock();
        app()->instance(Webhooks::class, $mock);
        $_SERVER['HTTP_STRIPE_SIGNATURE'] = '1234';

        $this->json('POST', '/saas/hooks', [])->assertStatus(403);
    }

    public function testIfTheWebhookSignatureCanBeVerifiedItHandlesTheEventAndReturnsA200Response()
    {
        $this->withoutExceptionHandling();
        $event = new Event();

        $mock = Mockery::mock(Webhooks::class)
            ->shouldReceive('verify')
            ->once()
            ->andReturn($event)
            ->getMock()
            ->shouldReceive('handle')
            ->once()
            ->with($event)
            ->getMock();

        app()->instance(Webhooks::class, $mock);
        $_SERVER['HTTP_STRIPE_SIGNATURE'] = '1234';

        $this->json('POST', '/saas/hooks', [])->assertStatus(200);
    }
}
