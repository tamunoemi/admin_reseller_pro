<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Listeners;

use Laravel\Paddle\Events\SubscriptionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class PaddleSubscriptionCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Update the most importantly
     * (1) paddle_or_stripe_subscription_id to the id from this event
     * (2) type to paddle
     * In the base_subscriptions table. 
     */
    public function handle(SubscriptionCreated $event): void
    {
      Log::info(json_encode($event));
    
    }
}
