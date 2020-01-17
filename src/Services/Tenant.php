<?php

namespace GeorgeHanson\SaaS\Services;

class Tenant
{
    /**
     * Create a new tenant
     * @param $name
     * @return Tenant
     */
    public function create($name)
    {
        $tenant = \GeorgeHanson\SaaS\Database\Models\Tenant::create(['name' => $name]);

        if (config('saas.billing.enabled')) {
            $this->getPaymentGateway()->createCustomer($tenant);
        }

        return $tenant;
    }

    /**
     * Get the payment gateway.
     *
     * @return PaymentGateway
     */
    protected function getPaymentGateway()
    {
        return app(PaymentGateway::class);
    }
}
