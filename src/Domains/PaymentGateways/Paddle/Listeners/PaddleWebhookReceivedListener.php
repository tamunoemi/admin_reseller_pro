<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Listeners;

use Laravel\Paddle\Events\WebhookReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;


use Teckipro\Admin\Models\PaddlePaymentLog;
use Teckipro\Admin\Models\LaunchSubscriptionModel as baseSubscriptionModel;
use Tamunoemi\Laraplans\Models\Plan;
use Teckipro\Admin\Http\Controllers\BillingController;



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
        //$this->handleSubscriptionCreated($event);

        
    }


    public function handlePaymentSucceeded($event){

                   
        if($event->payload['alert_name']=='payment_succeeded' || $event->payload['alert_name']=='subscription_payment_succeeded'){


            $user_id = "";
            $email = "";
            $plan_name = "";
            $plan_id = "";

            $product_id_or_subscription_plan_id = '';
            $product_or_plan_name = '';
            $subscription_id = '0';
            $type="";
            $recurring='';
            $expires = ""; //duration this subscription or payment will expire

            if($event->payload['alert_name']=='payment_succeeded'){
                $product_id_or_subscription_plan_id = $event->payload['product_id'];
                $plan_name = $product_or_plan_name = $event->payload['product_name'];
                $email = $event->payload['email'];

                $passthrough = json_decode($event->payload['passthrough']);
                $user_id = $passthrough->billable_id;

                $type="one-off";
                $recurring='0';

                /**
                 * Calculate when this plan is set to expire
                 */
                $plan_res = Plan::where('name',$plan_name)->select('id','interval','interval_count')->first();
                if(!empty($plan_res)){
                    $plan_id = $plan_res->id;

                    $interval = $plan_res->interval;
                    $interval_count = $plan_res->interval_count;
                    if($interval=='year'){
                        $total_days = $interval_count*365;
                        $expires = strtotime(now()->addDays($total_days));

                    }
                }else{
                    $expires = strtotime(now()->addDays(365));
                    //get the plan id since the $plan_name which is set on paddle
                    //does not match the name of the plan on this app
                    $plan_id = '0';
                }

            }elseif($event->payload['alert_name']=='subscription_payment_succeeded'){

                $passthrough = json_decode($event->payload['passthrough']);
                $appname = $passthrough->appname;
                $user_id = $passthrough->user_id;
                $email = $passthrough->email;
                $plan_name = $passthrough->plan_name;
    
                $plan_res = Plan::where('name',$plan_name)->select('id','interval','interval_count')->first();
                $plan_id = $plan_res->id;
    
                if(!config('my_config.app_name')==$appname){
                    /**
                     * Check if this purchase is been registered by Cashier paddle in the
                     * paddle_subscription and receipt table and delete if found
                     */
                    return false;
                 }

                $product_id_or_subscription_plan_id = $event->payload['subscription_plan_id'];
                $product_or_plan_name = $event->payload['plan_name'];
                $subscription_id = $event->payload['subscription_id'];
                $type="subscription";
                $recurring='1';
                $expires = strtotime($event->payload['next_bill_date']);


    
            }

            $logevent = array();

            $checkout_id = $event->payload['checkout_id'];
            
            $logevent['checkout_id'] = $checkout_id;
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
            $logevent['type'] = $type;
            //Log::info(json_encode($logevent));

            $logsId = "";
            if(!PaddlePaymentLog::where('checkout_id',$checkout_id)->exists()){
                $resp = PaddlePaymentLog::create($logevent);
                $logsId = $resp->id;
            }

            //Save subscription details
            $base_subtable = [
                'type'=>'paddle',
                'user_id'=>$user_id,
                'package_id'=>$plan_id,
                'paddle_stripe_payment_logs_id'=>$logsId,
                'is_active'=>'1',
                'amount'=>$event->payload['earnings'],
                'name'=>$plan_name,
                'email'=>$email,
                'transactionId'=>$checkout_id,
                'expires'=>date('y-m-d, h:i:s',$expires),
                'payment_Data'=>json_encode($event->payload),
                'paddle_or_stripe_subscription_id'=>$subscription_id,
                'is_recurring'=>$recurring
            ];

            if(!baseSubscriptionModel::where('transactionId',$checkout_id)->exists()){
                baseSubscriptionModel::create($base_subtable);
            }

            $billingController = new BillingController();
            $billingController->clearBillingCaches();
            


    }elseif($event->payload['alert_name']=='update_audience_member' || $event->payload['alert_name']=='new_audience_member'){
    /**
     * Log customers email that gives marketing consent during checkout
     */


    }elseif($event->payload['alert_name']=='subscription_cancelled'){
       /**
        * Handle refunds
        **/ 
        $passthrough = json_decode($event->payload['passthrough']);
        $appname = $passthrough->appname;
        $user_id = $passthrough->user_id;
        $email = $passthrough->email;
        $plan_name = $passthrough->plan_name;
        $subscription_id = $event->payload['subscription_id'];

        if(PaddlePaymentLog::where(['subscription_id'=>$subscription_id,'user_id'=>$user_id])->exists()){

        $log_res = PaddlePaymentLog::where(['subscription_id'=>$subscription_id,'user_id'=>$user_id])->select('id')->first();
        $logId = $log_res->id;
        $paddlePaymentLog = PaddlePaymentLog::find($logId);
        $paddlePaymentLog->refunded='1';
        $paddlePaymentLog->refund_payload=json_encode($event->payload);
        $paddlePaymentLog->status=$event->payload['status'];
        $paddlePaymentLog->save();
        
        }

        if(baseSubscriptionModel::where(['paddle_or_stripe_subscription_id'=>$subscription_id,'user_id'=>$user_id])->exists()){
            $base_res = baseSubscriptionModel::where(['paddle_or_stripe_subscription_id'=>$subscription_id,'user_id'=>$user_id])->select('id')->first();
            $base_res->is_active='0';
            $base_res->is_refunded='1';
            $base_res->is_cancelled='1';
            $base_res->cancelled_date = date('Y-m-d h:i:s',strtotime($event->payload['cancellation_effective_date']));
            $base_res->save();
        }

    }

    }




}
