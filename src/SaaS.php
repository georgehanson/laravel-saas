<?php


namespace GeorgeHanson\SaaS;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use GeorgeHanson\SaaS\Plan;
use Illuminate\Support\Collection;

class SaaS
{
    /**
     * @var array
     */
    protected static $plans = [];

    /**
     * Get the subscribe url for plans.
     */
    public static function subscribeUrl()
    {
        return url('saas/subscribe');
    }

    /**
     * Setup a new plan.
     *
     * @param $name
     * @param $stripeId
     */
    public static function plan($name, $stripeId)
    {
        $plan = (new Plan())->setName($name)->setStripeId($stripeId);
        static::$plans[] = $plan;
    }

    /**
     * Get all of the plans.
     *
     * @return Collection
     */
    public static function getPlans()
    {
        return collect(static::$plans);
    }

    /**
     * Get the tenant logged in.
     *
     * @return Tenant
     */
    public static function tenant()
    {
        if ($user = auth()->user()) {
            return Tenant::find($user->tenant_id);
        }

        return null;
    }

    public static function subscriptionEndingSoon()
    {
        $tenant = static::tenant();

        if ($tenant->subscription_active) {
            return false;
        }

        if (is_null($tenant->subscription_ends_at)) {
            return false;
        }

        if ($tenant->subscription_ends_at->gt(now())) {
            return true;
        }

        return false;
    }
}