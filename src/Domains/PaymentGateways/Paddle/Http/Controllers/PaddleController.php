<?php
/**
 * Good pricing pages
 * https://codepen.io/vetrisuriya/pen/mdLxxQx
 * https://codepen.io/vetrisuriya/pen/PoyZzRB
 */
namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

use Teckipro\Admin\Models\PaddleModel;
use Teckipro\Admin\Models\ReceiptModel;
use Teckipro\Admin\Models\PaddleCustomersModel;
use Teckipro\Admin\Traits\PaddleTrait;
use Teckipro\Admin\Traits\EnvTrait;
use Illuminate\Support\Facades\Validator;
use Log;
use Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController;
use Teckipro\Admin\Domains\Plans\Trait\PlanTrait;


class PaddleController
{

    use PaddleTrait,EnvTrait,PlanTrait;

    public $paddlemodel;
    public $receiptModel;
    public $paddleCustomersModel;



    public function settings()
    {
        return view("teckiproadmin::plans.gateway.paddle.settings");
    }

    public function index(){

        return view('teckiproadmin::saas.index');
    }

    public function receipt(){
        return view('teckiproadmin::saas.receipts_index');
    }

    public function customers(){
        return view('teckiproadmin::saas.customers_index');
    }

    public function updatePaddleSettings(Request $request){

       try {
        $validator = Validator::make($request->all(), [
            'PADDLE_VENDOR_ID' => 'required',
            'PADDLE_VENDOR_AUTH_CODE' => 'required',
            'PADDLE_PUBLIC_KEY' => 'required',
            'PADDLE_SANDBOX' => 'required'
         ]);
         $validated = $validator->validated();

         //convert to a single line
         $PADDLE_PUBLIC_KEY = str_replace(array("\r\n", "\n", "\r"), '', $validated['PADDLE_PUBLIC_KEY']);


        //setting the app name
        $this->setEnv("PADDLE_VENDOR_ID",$validated['PADDLE_VENDOR_ID']);
        $this->setEnv("PADDLE_VENDOR_AUTH_CODE", $validated['PADDLE_VENDOR_AUTH_CODE']);
        $this->setEnv("PADDLE_PUBLIC_KEY", '"'.$PADDLE_PUBLIC_KEY.'"');
        $this->setEnv("PADDLE_SANDBOX", $validated['PADDLE_SANDBOX']);

        return redirect()->route('admin.plan.gateway.paddle')->with('success', __('Paddle setting successfully updated.'));


       } catch (\Throwable $th) {
        throw $th;
       }
    }


    public function revieworder(Request $request){
        /**
         * There are three types of plans that can be sold.
         * - Monthly
         * - Yearly
         * - One time purchase
         *
         * If the pricingtype is on, they it means that yearly plan was selected
         * otherwise it means that monthly plan was selected.
         */
        try {
          
       

            $selected_plan_type = $request['selected_plan_type'];
            if(!isset($selected_plan_type)){
                abort(400,'Unsupported request format received.');
            }
 
            $plan_id = $request->input('plan_id');
            $pricingtype = '';
            $pricing_type_formatted_text = '';

            if($selected_plan_type=='monthly'){
                $pricing_type_formatted_text = 'Per month';
                $pricingtype = 'per_month';

            }elseif ($selected_plan_type=='yearly') {
                $pricingtype = 'per_year';
                $pricing_type_formatted_text = 'Per Year';
            }elseif ($selected_plan_type=='one-time-purchase') {
                $pricingtype = 'one_time_purchase';
                $pricing_type_formatted_text = 'One time purchase ';
            }

            //check that this plan has price set and features
            $details = $this->getPlanDetailsById($plan_id)[0];
            $plan_name=$details['name'];
            $price = $details['price'][$pricingtype];

            //add the price to the formatted text
            $pricing_type_formatted_text = $pricing_type_formatted_text;

            //if(empty($price)){ return back()->with('error','This product price is missing. Cannot be sold.'); }


            /**
             * Get the paddle id and stripe id 
             */

            $paddle_id = "";
            if($pricingtype=='per_month'){
                $paddle_id = $details['paddle_id']['monthly'];
            }elseif($pricingtype=='per_year'){
                $paddle_id = $details['paddle_id']['yearly'];
            }elseif($pricingtype=='one_time_purchase'){
               $paddle_id = $details['paddle_id']['one_time_purchase'];
            }

            //Generate payment link for paddle
            $paddle_payLink = "";
            if(empty($paddle_id)):
               abort(404);
            endif;

            $paddle_payLink = $request->user()->newSubscription($plan_name, $premium = $paddle_id)
            ->returnTo(route('subscriptionsuccess'))
            ->withMetadata(['appname' => env('APP_NAME'),'domain'=>$request->host])
            ->create();
           

            return view("teckiproadmin::checkout/paddle/checkout")
            ->withDetails($details)
            ->withPricingtype($pricingtype)
            ->withRealPrice($price)
            ->withPaddlePayLink($paddle_payLink)
            ->withPriceTypeFormatted($pricing_type_formatted_text)
   
            ;
 
   


        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }

 


}
