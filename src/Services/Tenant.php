<?php

namespace GeorgeHanson\SaaS\Services;

class Tenant
{
    /**
     * Activate the subscription for the tenant.
     *
     * @param string $customerId
     * @param int $endsAt
     * @param string $nickname
     * @param string $subscription
     */
    public static function activateSubscription($customerId, $endsAt, $nickname, $subscription)
    {
        $tenant = \GeorgeHanson\SaaS\Database\Models\Tenant::where('customer_id', $customerId)->first();
        $tenant->update([
            'subscription_ends_at' => \Carbon\Carbon::createFromTimestamp($endsAt),
            'subscription_active' => true,
            'subscription_plan' => $nickname,
            'subscription_id' => $subscription
        ]);
    }

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
