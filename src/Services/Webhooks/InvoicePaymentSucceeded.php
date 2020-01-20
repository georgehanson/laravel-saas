<?php


namespace GeorgeHanson\SaaS\Services\Webhooks;

use Illuminate\Support\Facades\Log;
use Stripe\Event;

class InvoicePaymentSucceeded implements Handler
{
    /**
     * Process the Stripe event.
     *
     * @param Event $event
     * @return mixed
     */
    public function process(Event $event)
    {
       // The invoice payment was successful. We need to mark the tenants subscription as active and set the expiry date.
        Log::error($event->data->lines->data[0]->plan);
    }
}