<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Exceptions\WebhookCouldNotBeVerifiedException;
use GeorgeHanson\SaaS\SaaS;
use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\Webhooks;
use GeorgeHanson\SaaS\Tests\Resources\StripeEvent;
use GeorgeHanson\SaaS\Tests\Resources\User;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Stripe\Checkout\Session;
use Stripe\Event;

class TenantModelTest extends TestCase
{
    public function testTheTenantHasPayments()
    {
        $tenant = Tenant::create(['name' => 'ABC']);
        $this->assertInstanceOf(Collection::class, $tenant->payments);
    }
}
