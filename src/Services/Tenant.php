<?php

namespace GeorgeHanson\SaaS\Services;

use GeorgeHanson\SaaS\Database\Models\Tenant as Model;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Subscription;

class Tenant
{
    /**
     * Cancel the subscription for the tenant.
     *
     * @param Model $tenant
     * @return bool
     */
    public static function cancelSubscription(Model $tenant)
    {
        try {
            $subscription = Subscription::retrieve($tenant->subscription_id);
            $subscription->delete();

            return true;
        } catch (ApiErrorException $e) {
            Log::error('Could not cancel subscription');
            return false;
        }
    }

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
        $tenant = Model::where('customer_id', $customerId)->first();
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
        $tenant = Model::create(['name' => $name]);

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
