<?php

namespace GeorgeHanson\SaaS\Services;

use GeorgeHanson\SaaS\Plans\Plan;
use Stripe\Checkout\Session;

class StripeSessionBuilder
{
    /**
     * @var \GeorgeHanson\SaaS\Database\Models\Tenant
     */
    protected $tenant;

    /**
     * @var string
     */
    protected $plan;

    /**
     * StripeSessionBuilder constructor.
     * @param \GeorgeHanson\SaaS\Database\Models\Tenant $tenant
     */
    public function __construct(\GeorgeHanson\SaaS\Database\Models\Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * The plan to create the stripe session for.
     *
     * @param Plan $plan
     * @return StripeSessionBuilder
     */
    public function forPlan(Plan $plan)
    {
        $this->plan = $plan->getStripeId();

        return $this;
    }

    /**
     * Create the session.
     */
    public function create()
    {
        return Session::create([
            'customer' => $this->tenant->customer_id,
            'payment_method_types' => ['card'],
            'subscription_data' => [
                'items' => [
                    ['plan' => $this->plan]
                ]
            ],
            'success_url' => url(config('saas.billing.success_url_redirect')),
            'cancel_url' => url(config('saas.billing.cancel_url_redirect')),
        ]);
    }
}