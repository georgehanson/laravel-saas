<?php


namespace GeorgeHanson\SaaS\Services\Webhooks;

use Stripe\Event;

interface Handler
{
    /**
     * Process the Stripe event.
     *
     * @param Event $event
     * @return mixed
     */
    public function process(Event $event);
}
