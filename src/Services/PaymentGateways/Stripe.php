<?php


namespace GeorgeHanson\SaaS\Services\PaymentGateways;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Services\PaymentGateway;
use GeorgeHanson\SaaS\Services\StripeSessionBuilder;

class Stripe implements PaymentGateway
{

    /**
     * @param Tenant $tenant
     * @return mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCustomer(Tenant $tenant)
    {
        $customer = \Stripe\Customer::create(['description' => $tenant->name]);
        $tenant->update(['customer_id' => $customer->id]);
    }

    /**
     * Create the session token.
     *
     * @param Tenant $tenant
     * @return mixed
     */
    public function createSessionToken(Tenant $tenant)
    {
        return (new StripeSessionBuilder($tenant));
    }
}
