<?php

namespace Teckipro\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Teckipro\Admin\Models\StripePaymentLog;
use Teckipro\Admin\Domains\PaymentGateways\Stripe\Model\Subscription as stripeSubscriptionModel;
use Teckipro\Admin\Models\LaunchSubscriptionModel as baseSubscriptionModel;
use Tamunoemi\Laraplans\Models\Plan;
use Auth;
use Cache;
use Livewire\Component;
use Livewire\WithPagination;

class BillingController 
{
    public $user_id;
    public function __construct(){
       $this->user_id = isset(auth()->user()->id) ? auth()->user()->id: '' ;
    }

    public function getRefunds(){
        /**
         * List out refunds on both one-off payments and subscriptions
         */
        $refunds = array();
        if(config('my_config.default_gateway')=='stripe'){
         
           $response = Cache::remember('cachedRefundRecords', now()->addHours(48), function () {
            return StripePaymentLog::where(['user_id'=>$this->user_id,'refunded'=>'1'])->get();
            });
   

           if(!empty($response)){
            foreach($response as $resp){
                $refund_payload = json_decode($resp->refund_payload);
                $object = $refund_payload->data->object;
                $type = $resp->type;
                $plan_name = "";
                if($type=='charge'){
                    $plan_name = $object->metadata->plan_name;
                }elseif($type=='subscription'){
                 $payload = json_decode($resp->payload);
                 $plan_name = $payload->data->object->lines->data[0]->metadata->plan_name;
                }
                
                
                $arg = [
                  'amount'=>$object->amount_refunded/100,
                  'receipt_url'=>$object->receipt_url,
                  'status'=>$object->status,
                  'plan_name'=>$plan_name,
                  'issued_on'=>date('y-m-d h:i:s',$object->created)
                ];
                $refunds[] = $arg;
                
            }
           }
        }elseif(config('my_config.default_gateway')=='paddle'){

        }
        return $refunds;

    }

    public function getPayments(){
        /**List out one-off payments */

        $payments = array();
        if(config('my_config.default_gateway')=='stripe'){

           $response = Cache::remember('cachedPaymentRecords', now()->addHours(48), function () {
            return StripePaymentLog::where(['user_id'=>$this->user_id,'type'=>'charge'])->get();
            });
 
           if(!empty($response)){
            foreach($response as $resp){
                $payload = json_decode($resp->refund_payload);
                $object = $payload->data->object;
     
                $arg = [
                  'amount'=>$object->amount_refunded/100,
                  'receipt_url'=>$payload->data->previous_attributes->receipt_url,
                  'status'=>$object->status,
                  'plan_name'=>$object->metadata->plan_name,
                  'issued_on'=>date('y-m-d h:i:s',$object->created)
                ];
                $payments[] = $arg;
                
            }
           }
        }else{

        }

       return $payments;

    }


    public function getSubscriptions(){
        /**List out subscriptions */
        $results = array();
        if(config('my_config.default_gateway')=='stripe'){

           $response = Cache::remember('cachedSubscriptionRecords', now()->addHours(48), function () {
            return  stripeSubscriptionModel::where(['user_id'=>$this->user_id,'stripe_status'=>'active'])->get();
            });
  
 
           if(!empty($response)){
            foreach($response as $resp){
                
                $res = StripePaymentLog::where(['user_id'=>$this->user_id,'subscription'=>$resp->stripe_id])->select('invoice_pdf','hosted_invoice_url','invoice_number')->first();
                $arg = [
                  'name'=>$resp->name,
                  'invoice_number'=>$res->invoice_number,
                  'hosted_invoice_url'=>$res->hosted_invoice_url,
                  'invoice_pdf'=>$res->invoice_pdf,
                  'start'=>date('Y-m-d h:i:s',$resp->current_period_start),
                  'end'=>date('Y-m-d h:i:s',$resp->current_period_end),
                  'status'=>$resp->stripe_status

                ];
                $results[] = $arg;
                
            }
           }
        }else{

        }
       return $results;
    }

    public function clearBillingCaches(){
        /** Clear all cached billing queries. Called after a new transaction is recorded */
        try {
            Cache::forget('cachedSubscriptionRecords');
            Cache::forget('cachedPaymentRecords');
            Cache::forget('cachedRefundRecords');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function sampleBillingQuery(){
        /**
         * Sample implementation for pagination suggestion
         * Use multi pagination on a single page technique with livewire
         */
        $payments = $this->getPayments();
        $subscriptions = $this->getSubscriptions();
        $refunds = $this->getRefunds();
        
        /*
        $perPage = 10;
        $offset = max(0, ($this->page - 1) * $perPage);
        $collection = collect($this->result);
        $paginator = $collection->paginate($perPage,'',$this->page);

        return view('livewire.elements.icons',['results'=>$paginator]);
        */

    }

 

}
