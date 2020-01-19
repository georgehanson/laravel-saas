<?php

namespace GeorgeHanson\SaaS\Plans;

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
     * @return array<Plan>
     */
    public static function getPlans()
    {
        return static::$plans;
    }
}