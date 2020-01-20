<?php


namespace GeorgeHanson\SaaS\Services\Webhooks;

use GeorgeHanson\SaaS\Services\Tenant;
use Illuminate\Support\Facades\Log;
use Stripe\Event;
use Stripe\Invoice;
use Stripe\InvoiceLineItem;

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
        $invoice = $this->getInvoiceObject($event);
        $line = $this->getFirstLineItem($invoice);

        Tenant::activateSubscription(
            $invoice->customer,
            $line->period->end,
            $line->plan->nickname,
            $invoice->subscription
        );
    }

    /**
     * Get the first line item.
     *
     * @param Invoice $invoice
     * @return InvoiceLineItem
     */
    protected function getFirstLineItem(Invoice $invoice)
    {
        return $invoice->lines->data[0];
    }

    /**
     * Get the invoice object.
     *
     * @param Event $event
     * @return Invoice
     */
    protected function getInvoiceObject(Event $event)
    {
        return $event->data->object;
    }
}
