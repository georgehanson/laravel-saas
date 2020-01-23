<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Services\PaymentGateways\Stripe;
use GeorgeHanson\SaaS\Services\StripeSessionBuilder;

class StripePaymentGatewayTest extends TestCase
{
    public function testItCanGetTheSessionBuilder()
    {
        $tenant = Tenant::create(['name' => 'ABC']);

        $gateway = app(Stripe::class);
        $this->assertInstanceOf(StripeSessionBuilder::class, $gateway->createSessionToken($tenant));
    }
}
