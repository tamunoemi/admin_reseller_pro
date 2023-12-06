<?php
 
namespace Teckipro\Admin\Domains\PaymentGateways\Stripe\Listeners;
 
use Laravel\Cashier\Events\WebhookReceived;
use Log;

 
class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        //Log::info("StripeEventListener is called");
        //Log::info(json_encode($event->payload));
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            // Handle the incoming event...
        }
    }
}