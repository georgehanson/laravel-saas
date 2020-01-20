<?php


namespace GeorgeHanson\SaaS\Services\Webhooks;

use GeorgeHanson\SaaS\Services\Tenant;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Event;
use Stripe\Invoice;
use Stripe\InvoiceLineItem;
use Stripe\PaymentMethod;
use Stripe\SetupIntent;

class CheckoutSessionCompleted implements Handler
{
    /**
     * Process the Stripe event.
     *
     * @param Event $event
     * @return mixed
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function process(Event $event)
    {
        $session = $this->getSessionObject($event);
        $intent = SetupIntent::retrieve($session->setup_intent);
        $paymentMethod = PaymentMethod::retrieve($intent->payment_method);
        $paymentMethod->attach(['customer' => $intent->metadata->customer_id]);

        Customer::update($intent->metadata->customer_id, [
            'invoice_settings' => ['default_payment_method' => $intent->payment_method],
        ]);
    }

    /**
     * Get the session object.
     *
     * @param Event $event
     * @return Session
     */
    protected function getSessionObject(Event $event)
    {
        return $event->data->object;
    }
}
