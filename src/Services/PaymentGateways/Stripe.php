<?php


namespace GeorgeHanson\SaaS\Services\PaymentGateways;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Services\PaymentGateway;

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
}
