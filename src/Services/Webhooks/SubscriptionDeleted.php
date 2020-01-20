<?php


namespace GeorgeHanson\SaaS\Services\Webhooks;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use Stripe\Event;
use Stripe\Subscription;

class SubscriptionDeleted implements Handler
{
    /**
     * Process the Stripe event.
     *
     * @param Event $event
     * @return mixed
     */
    public function process(Event $event)
    {
        $subscription = $this->getSubscriptionObject($event);
        $tenant = Tenant::where('customer_id', $subscription->customer)->first();

        $tenant->update([
            'subscription_active' => $subscription->plan->active
        ]);
    }

    /**
     * Get the subscription object.
     *
     * @param Event $event
     * @return Subscription
     */
    protected function getSubscriptionObject(Event $event)
    {
        return $event->data->object;
    }
}
