<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Listeners;

use Laravel\Paddle\Events\SubscriptionCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaddleSubscriptionCancelled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the id of the subscription, set in base_subscriptions table 
     * is_cancelled to 1 and the date it was cancelled (cancelled_date).
     * Ensure to set properly the type and paddle_or_stripe_subscription_id
     */
    public function handle(SubscriptionCancelled $event): void
    {

        
    }
}
