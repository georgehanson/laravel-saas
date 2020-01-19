<?php


namespace GeorgeHanson\SaaS\Services;

use GeorgeHanson\SaaS\Database\Models\Tenant;

interface PaymentGateway
{
    /**
     * @param Tenant $tenant
     * @return mixed
     */
    public function createCustomer(Tenant $tenant);

    /**
     * Create the session token.
     *
     * @param Tenant $tenant
     * @return StripeSessionBuilder
     */
    public function createSessionToken(Tenant $tenant);
}
