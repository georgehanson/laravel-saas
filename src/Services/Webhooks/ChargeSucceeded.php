<?php


namespace GeorgeHanson\SaaS\Services\Webhooks;

use GeorgeHanson\SaaS\Database\Models\Tenant;
use Stripe\Charge;
use Stripe\Event;

class ChargeSucceeded implements Handler
{
    /**
     * Process the Stripe event.
     *
     * @param Event $event
     * @return mixed
     */
    public function process(Event $event)
    {
        $charge = $this->getChargeObject($event);
        $tenant = Tenant::where('customer_id', $charge->customer)->first();
        $tenant->payments()->create([
            'amount' => $charge->amount,
            'charge_id' => $charge->id
        ]);
    }

    /**
     * Get the Charge object.
     *
     * @param Event $event
     * @return Charge
     */
    protected function getChargeObject(Event $event)
    {
        return $event->data->object;
    }
}
