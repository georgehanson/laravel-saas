<?php

namespace GeorgeHanson\SaaS\Tests\Resources;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\StripeSessionBuilder;

class FakePaymentGateway implements PaymentGateway
{

    /**
     * @param Tenant $tenant
     * @return mixed
     */
    public function createCustomer(Tenant $tenant)
    {
        $tenant->update(['customer_id' => '1234']);
    }

    /**
     * Create the session token.
     *
     * @param Tenant $tenant
     * @return StripeSessionBuilder
     */
    public function createSessionToken(Tenant $tenant)
    {
        // TODO: Implement createSessionToken() method.
    }
}