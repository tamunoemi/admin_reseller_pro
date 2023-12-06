<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Listeners;


use Laravel\Paddle\Events\PaymentSucceeded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Teckipro\Admin\Models\LaunchSubscriptionModel as BaseSubscriptionModel;
use Teckipro\Admin\Models\Package as PlanModel;
use Log;

class PaddlePaymentSucceeded
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle received Paddle webhooks.
     */
    public function handle(PaymentSucceeded $event): void
    {
      
     /**
      * check if it's a plan that was purchased, if so, update subscription.
      */
      //$plan_id = $event->payload['product_id'];
      //$d = PlanModel::where('')
      Log::info(json_encode($event));
        
    }
}
