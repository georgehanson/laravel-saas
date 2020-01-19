<?php

namespace GeorgeHanson\SaaS\Plans;

use Illuminate\Support\Collection;

class Plans
{
    /**
     * @var array<Plan>
     */
    public static $plans = [];

    /**
     * Add a plan.
     *
     * @param Plan $plan
     */
    public static function addPlan(Plan $plan)
    {
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