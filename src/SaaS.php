<?php


namespace GeorgeHanson\SaaS;

use GeorgeHanson\SaaS\Plan;
use Illuminate\Support\Collection;

class SaaS
{
    /**
     * @var array
     */
    protected static $plans = [];

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
}