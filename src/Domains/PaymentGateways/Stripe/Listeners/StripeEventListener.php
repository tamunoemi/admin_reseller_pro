<?php
 
namespace Teckipro\Admin\Domains\PaymentGateways\Stripe\Listeners;
 
use Laravel\Cashier\Events\WebhookReceived;
use Log;
use Teckipro\Admin\Models\StripePaymentLog;
use Teckipro\Admin\Domains\PaymentGateways\Stripe\Model\Subscription as stripeSubscriptionModel;
use Teckipro\Admin\Models\LaunchSubscriptionModel as baseSubscriptionModel;
use Tamunoemi\Laraplans\Models\Plan;
use Teckipro\Admin\Http\Controllers\BillingController;
class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event)
    {
        
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            // Handle the incoming event...
            
          
            $object = $event->payload['data']['object'];
            $metadata = $object['lines']['data'][0]['metadata'];
            if(empty($metadata)){ return false; }
            $user_id = $metadata['user_id'];
            $app_name = $metadata['appname'];
            if(!$app_name==config('my_config.app_name')){
                return false;
            }
            
            Log::info("invoice.payment_succeeded is called");
            
            
            $data = [
                'user_id'=>$user_id,
                'billing_reason'=>$object['billing_reason'],
                'invoice_id'=>$object['id'],
                'invoice_pdf'=>$object['invoice_pdf'],
                'hosted_invoice_url'=>$object['hosted_invoice_url'],
                'amount_paid'=>$object['amount_paid']/100,
                'subscription'=>$object['subscription'],
                'subscription_item'=>$object['lines']['data'][0]['subscription_item'],
                'paid'=>$object['paid'],
                'invoice_number'=>$object['number'],
                'description'=>$object['lines']['data'][0]['description'],
                'payload'=>json_encode($event->payload),
                'type'=>'subscription'

            ];
            if(!StripePaymentLog::where('invoice_id',$object['id'])->exists()){
                StripePaymentLog::create($data);
            }
 
        $billingController = new BillingController();
        $billingController->clearBillingCaches();


        }elseif($event->payload['type'] === 'customer.subscription.updated'){

            sleep(10);

            $object = $event->payload['data']['object'];
            $metadata = $object['metadata'];
            if(empty($metadata)){ return false; }
            $user_id = $metadata['user_id'];
            $app_name = $metadata['appname'];
            $plan_name = $metadata['plan_name'];
            $email = $metadata['email'];

            $plan_res = Plan::where('name',$plan_name)->select('id')->first();
            $plan_id = $plan_res->id;
    

            if(!$app_name==config('my_config.app_name')){
                return false;
            }

            Log::info("customer.subscription.updated is called");

            $subscription = $object['items']['data'][0]['subscription'];
            

            $data = [
              'invoice_id'=>$object['latest_invoice'],
              'item_id'=>$object['items']['data'][0]['id'],
              'current_period_end'=>$object['current_period_end'],
              'current_period_start'=>$object['current_period_start'],
              'discount'=>$object['discount'],
              'interval'=>$object['items']['data'][0]['plan']['interval'],
              'interval_count'=>$object['items']['data'][0]['plan']['interval_count'],
            ];

            if(stripeSubscriptionModel::where('stripe_id',$subscription)->exists()){
                stripeSubscriptionModel::where('stripe_id',$subscription)->update($data);
            }
           
            $log_res = StripePaymentLog::where('subscription',$subscription)->select('id')->first();
            $paddle_stripe_payment_logs_id = isset($log_res->id) ? $log_res->id: '';


            $price = $object['items']['data'][0]['plan']['id'];
            $subscription_id = stripeSubscriptionModel::where('stripe_id',$subscription)->select('id')->first();
            $subscription_id = isset($subscription_id->id) ? $subscription_id->id: '';
            $amount = $object['plan']['amount']/100;

            if(empty($paddle_stripe_payment_logs_id)){ return false; }

            //Save subscription details
            $base_subtable = [
                'type'=>'stripe',
                'user_id'=>$user_id,
                'package_id'=>$plan_id,
                'paddle_stripe_payment_logs_id'=>$paddle_stripe_payment_logs_id,
                'is_active'=>'1',
                'amount'=>$amount,
                'name'=>$plan_name,
                'email'=>$email,
                'transactionId'=>$object['latest_invoice'],
                'expires'=>date('y-m-d, h:i:s',$object['current_period_end']),
                'payment_Data'=>json_encode($event->payload),
                'paddle_or_stripe_subscription_id'=>$subscription_id,
                'is_recurring'=>'1'
            ];

            if(!baseSubscriptionModel::where('transactionId',$object['latest_invoice'])->exists()){
                baseSubscriptionModel::create($base_subtable);
            }

            $billingController = new BillingController();
            $billingController->clearBillingCaches();

            
        }elseif($event->payload['type'] === 'charge.succeeded'){
            $object = $event->payload['data']['object'];
            $metadata = $object['metadata'];
            if(empty($metadata)){ return false; }
            $user_id = $metadata['user_id'];
            $app_name = $metadata['appname'];
            $plan_name = $metadata['plan_name'];

            if(!$app_name==config('my_config.app_name')){
                return false;
            }

            $email = $metadata['email'];

            $plan_res = Plan::where('name',$plan_name)->select('id','interval','interval_count')->first();
            $plan_id = $plan_res->id;

            /**
             * Calculate when this plan is set to expire
             */
            $interval = $plan_res->interval;
            $interval_count = $plan_res->interval_count;
            $expire_in="";
            if($interval=='year'){
                $total_days = $interval_count*365;
                $expire_in = now()->addDays($total_days);

            }

            
            $charge_id = $object['id'];
            $amount = $object['amount']/100;

            $data = [
                'user_id'=>$user_id,
                'billing_reason'=>'charge',
                'receipt_url'=>$object['receipt_url'],
                'amount_paid'=>$amount,
                'paid'=>$object['paid'],
                'payload'=>json_encode($event->payload),
                'type'=>'charge',
                'charge_id'=>$charge_id

            ];
            if(!StripePaymentLog::where('charge_id',$charge_id)->exists()){
                $resp = StripePaymentLog::create($data);
                $logId = $resp->id;
                

                //Save subscription details
                $base_subtable = [
                    'type'=>'stripe',
                    'user_id'=>$user_id,
                    'package_id'=>$plan_id,
                    'paddle_stripe_payment_logs_id'=>$logId,
                    'is_active'=>'1',
                    'amount'=>$amount,
                    'name'=>$plan_name,
                    'email'=>$email,
                    'transactionId'=>$charge_id,
                    'expires'=>$expire_in,
                    'payment_Data'=>json_encode($event->payload),
                    'is_recurring'=>'0'
                ];

                if(!baseSubscriptionModel::where('transactionId',$charge_id)->exists()){
                   baseSubscriptionModel::create($base_subtable);
                }

            }

            $billingController = new BillingController();
            $billingController->clearBillingCaches();
        /**
         * Refund on one off payment
         */
        }elseif($event->payload['type'] === 'charge.refunded'){
            $object = $event->payload['data']['object'];
            /** Check if its a refund of a one-off purchase or subscription */
            $invoice = $object['invoice'];

            if(empty($invoice)){
                /** It's a one -off */

                $metadata = $object['metadata'];
                if(empty($metadata)){ return false; }
                $user_id = $metadata['user_id'];
                $app_name = $metadata['appname'];
                $plan_name = $metadata['plan_name'];
                $email = $metadata['email'];
    
                if(!$app_name==config('my_config.app_name')){
                    return false;
                }
    
                $refund_update = [];
                $charge_id = $object['id'];
                if(StripePaymentLog::where('charge_id',$charge_id)->exists()){
                    $resp = StripePaymentLog::where('charge_id',$charge_id)->select('id')->first();
                    $id = $resp->id;
                    $up = StripePaymentLog::find($id);
                    $up->refunded='1';
                    $up->refund_payload=json_encode($event->payload);
                    $up->save();
                 }
    
                 if(baseSubscriptionModel::where('transactionId',$charge_id)->exists()){
                    $resp = baseSubscriptionModel::where('transactionId',$charge_id)->select('id')->first();
                    $id = $resp->id;
                    $up = baseSubscriptionModel::find($id);
                    $up->is_refunded='1';
                    $up->is_cancelled='1';
                    $up->save();
                 }

            

            }else{
                /** It's a subscription */

    
                $refund_update = [];
                
                if(StripePaymentLog::where('invoice_id',$invoice)->exists()){
                    $resp = StripePaymentLog::where('invoice_id',$invoice)->select('id')->first();
                    $id = $resp->id;
                    $up = StripePaymentLog::find($id);
                    $up->refunded='1';
                    $up->refund_payload=json_encode($event->payload);
                    $up->save();
                 }
    
                 if(baseSubscriptionModel::where('transactionId',$invoice)->exists()){
                    $resp = baseSubscriptionModel::where('transactionId',$invoice)->select('id')->first();
                    $id = $resp->id;
                    $up = baseSubscriptionModel::find($id);
                    $up->is_refunded='1';
                    $up->is_cancelled='1';
                    $up->save();
                 }

                 if(stripeSubscriptionModel::where('invoice_id',$invoice)->exists()){
                    $resp = stripeSubscriptionModel::where('invoice_id',$invoice)->select('id')->first();
                    $id = $resp->id;
                    $up = stripeSubscriptionModel::find($id);
                    $up->stripe_status='inactive';
                    $up->save();
                 }

                 
            }
           

            $billingController = new BillingController();
            $billingController->clearBillingCaches();

        /**
         * Refund on subscriptions
         */
        }elseif($event->payload['type'] === 'customer.subscription.deleted'){

        }elseif($event->payload['type'] === 'refund.updated'){

        }
    }
}