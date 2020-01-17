<?php

namespace GeorgeHanson\SaaS\Tests\Resources;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Services\PaymentGateway;

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
}