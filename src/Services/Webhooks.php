<?php


namespace GeorgeHanson\SaaS\Services;

use GeorgeHanson\SaaS\Exceptions\WebhookCouldNotBeVerifiedException;
use GeorgeHanson\SaaS\Services\Webhooks\ChargeSucceeded;
use GeorgeHanson\SaaS\Services\Webhooks\CheckoutSessionCompleted;
use GeorgeHanson\SaaS\Services\Webhooks\InvoicePaymentSucceeded;
use GeorgeHanson\SaaS\Services\Webhooks\SubscriptionDeleted;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Webhook;

class Webhooks
{
    /**
     * Events that are handled.
     *
     * @var array
     */
    protected $events = [
        'invoice.payment_succeeded' => InvoicePaymentSucceeded::class,
        'charge.succeeded' => ChargeSucceeded::class,
        'customer.subscription.deleted' => SubscriptionDeleted::class,
        'checkout.session.completed' => CheckoutSessionCompleted::class
    ];

    /**
     * Verify the signature and return the event instance.
     *
     * @param $payload
     * @param $signature
     * @return Event
     * @throws WebhookCouldNotBeVerifiedException
     */
    public function verify($payload, $signature)
    {
        try {
            return Webhook::constructEvent($payload, $signature, config('saas.billing.stripe.webhook_key'));
        } catch (UnexpectedValueException | SignatureVerificationException $e) {
            throw new WebhookCouldNotBeVerifiedException();
        }
    }

    /**
     * Handle the Stripe Event.
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        if (array_key_exists($event->type, $this->events)) {
            $class = $this->events[$event->type];
            (new $class)->process($event);
        }
    }
}
