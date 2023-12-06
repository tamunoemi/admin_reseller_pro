<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Listeners;

use Laravel\Paddle\Events\WebhookReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Teckipro\Admin\Models\PaddlePaymentLog;
use Log;

class PaddleWebhookReceivedListener
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
    public function handle(WebhookReceived $event)
    {

        $this->handlePaymentSucceeded($event);
        $this->handleSubscriptionCreated($event);

        
    }


    public function handlePaymentSucceeded($event){

                   
        if($event->payload['alert_name']=='payment_succeeded' || $event->payload['alert_name']=='subscription_payment_succeeded'){

            $passthrough = json_decode($event->payload['passthrough']);
            $appname = $passthrough->appname;

            if(!config('my_config.app_name')==$appname){
                /**
                 * Check if this purchase is been registered by Cashier paddle in the
                 * paddle_subscription and receipt table and delete if found
                 */
                return false;
             }

            $product_id_or_subscription_plan_id = '';
            $product_or_plan_name = '';
            $subscription_id = '';

            if($event->payload['alert_name']=='payment_succeeded'){
                $product_id_or_subscription_plan_id = $event->payload['product_id'];
                $product_or_plan_name = $event->payload['product_name'];

            }elseif($event->payload['alert_name']=='subscription_payment_succeeded'){

                $product_id_or_subscription_plan_id = $event->payload['subscription_plan_id'];
                $product_or_plan_name = $event->payload['plan_name'];
                $subscription_id = $event->payload['subscription_id'];
            }


            $logevent = array();
            
            $logevent['checkout_id'] = $event->payload['checkout_id'];
            $logevent['order_id'] =  $event->payload['order_id'];
            $logevent['user_id'] = $passthrough->billable_id;
            $logevent['product_id_or_subscription_plan_id'] = $product_id_or_subscription_plan_id;
            $logevent['product_or_plan_name'] =  $product_or_plan_name;
            $logevent['earnings'] = $event->payload['earnings'];
            $logevent['status'] = isset($event->payload['status']) ? $event->payload['status']: 'active';
            $logevent['subscription_id'] = $subscription_id;
            $logevent['alert_name'] =  $event->payload['alert_name'];
            $logevent['country'] = $event->payload['country'];
            $logevent['receipt_url'] =  $event->payload['receipt_url'];
            $logevent['payload'] =  json_encode($event->payload);
            
            PaddlePaymentLog::firstOrCreate($logevent);

            

    }

    }


    public function handleSubscriptionCreated($event){

        if($event->payload['alert_name']=='subscription_created'){

            $passthrough = json_decode($event->payload['passthrough']);
            $appname = $passthrough->appname;

            if(!config('my_config.app_name')==$appname){
                /**
                 * Check if this purchase is been registered by Cashier paddle in the
                 * paddle_subscription and receipt table and delete if found
                 */
                return false;
             }
            }
            Log::info("handleSubscriptionCreated called");
    }


}
