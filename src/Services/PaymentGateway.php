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
}
