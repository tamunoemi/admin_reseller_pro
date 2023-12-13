<?php
/**
 * Stripe Api Doc: https://stripe.com/docs/api
 */
namespace Teckipro\Admin\Domains\PaymentGateways\Stripe\Http\Controller;

use Illuminate\Http\Request;
use Tamunoemi\Laraplans\Models\Plan;

use Laravel\Cashier\Cashier; //stripe client
use Teckipro\Admin\Traits\EnvTrait;
use Illuminate\Support\Facades\Validator;
use Teckipro\Admin\Domains\Plans\Trait\PlanTrait;
use Illuminate\Support\Facades\Auth;

class StripeSubscriptionController
{
    use EnvTrait,PlanTrait;

    public  $stripe;


    public function __construct(){
        $this->stripe = Cashier::stripe();
    }

    public function settings()
    {
        return view("teckiproadmin::plans.gateway.stripe.settings");
    }


    public function updateStripeSettings(Request $request){

        $validator = Validator::make($request->all(), [
            'STRIPE_KEY' => 'required',
            'STRIPE_SECRET' => 'required',
            'STRIPE_WEBHOOK_SECRET' => 'nullable'
         ]);
         $validated = $validator->validated();

        //setting the app name
        $this->setEnv("STRIPE_KEY",$validated['STRIPE_KEY']);
        $this->setEnv("STRIPE_SECRET", $validated['STRIPE_SECRET']);
        $this->setEnv("STRIPE_WEBHOOK_SECRET", $validated['STRIPE_WEBHOOK_SECRET']);

        return redirect()->route('admin.plan.gateway.stripe')->with('success', __('Stripe setting successfully updated.'));

    }

    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        return view("plans/subscription", compact("plan", "intent"));
    }

    public function subscription(Request $request)
    {

        try {

            $plan = Plan::find($request->plan);
            /**
             * check if product is one time or recurring
             */

            $price_details = $this->stripe->prices->retrieve(
                $plan->stripe_id,
                []
              );

            if($price_details->type == "one_time"){
                $request->user()->invoicePrice($plan->stripe_id, 1);

            }else{

                $subscription = $request->user()->newStripeSubscription($request->plan, $plan->stripe_id)->create($request->token);
                dd($subscription);

            }

            return view("plans/subscription_success");

        } catch (\Stripe\Exception\InvalidRequestException $e) {
             dd($e->getMessage());
        }catch (\Laravel\Cashier\Exceptions\IncompletePayment $e) {
            dd($e->getMessage());
         }

    }


    /**
     * Check if a stripe price is recurring payment or one time charge
     */
    public function isPriceRecurringOrOneTime($price_id){
        try {
            $price_details = $this->stripe->prices->retrieve(
                $price_id,
                []
              );

            if($price_details->type == "one_time"){
                return 'one_time';
            }else{
                return 'recurring';
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function createSubscription(Request $request){
        try{

            //dd($request->all());

            if($request->input('add_new_payment_method')){

                $token = $request->input('token');
                try{

                    $request->user()->addPaymentMethod($token);
                    return back()->with('success',__('New payment method added successfully.'));
                }catch(\Exception $e){
                    dd($e->getMessage());
                }
                
            }else{

            

            $token = "";
            if($request->input('token') !== null){
                $token = $request->input('token');
            }elseif($request->input('payment_method') !== null){
                $token = $request->input('payment_method');
            }
            
            $plan = $request->input('plan');
            $plan_name = $request->input('plan_name');
            $type = $request->input('type');
            
    
            if($type=='monthly' || $type=='yearly'){
                $response = $request->user()->newStripeSubscription(
                    $plan_name, $plan
                )->create($token, [
                    'email' => $request->user()->email,
                ], [
                    'metadata' => ['appname' => config('my_config.app_name'),
                                'user_id'=>$request->user()->id,
                                'plan_name'=>$plan_name,
                                'email'=>$request->user()->email
                               ],
                ]);
           }else{
            $price = $request->input('price');
            //$price = $price * 100;
            $response = $request->user()->charge($price, $token, [
                'metadata' => ['appname' => config('my_config.app_name'),
                'user_id'=>$request->user()->id,
                'plan_name'=>$plan_name,
                'email'=>$request->user()->email
               ],
            ]);
       
             
           }

    
            return redirect()->to('stripe/order/success');
            }
        }catch(\Exception $ex){
            exit('Something went wrong: '.$ex->getMessage());
        }

    }

    public function ordersuccess(Request $request){
        return view("teckiproadmin::checkout/stripe/success");
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
           
            $selected_plan_type = "";
            $plan_id = "";
       
            if ($request->session()->exists('loginRequestOnStripePaymentOrderPage')) {
                $input = session()->pull('loginRequestOnStripePaymentOrderPage');
                $plan_id = $input['plan_id'];
                $selected_plan_type = $input['selected_plan_type'];
            }else{
                $selected_plan_type = $request['selected_plan_type'];
                $plan_id = $request->input('plan_id');
            }

            if(!isset($selected_plan_type)){
                abort(400,'Unsupported request format received.');
            }

 
            $pricingtype = '';
            $pricing_type_formatted_text = '';

            if($selected_plan_type=='monthly'){
                $pricing_type_formatted_text = 'Per month';
                $pricingtype = 'per_month';

            }elseif ($selected_plan_type=='yearly') {
                $pricingtype = 'per_year';
                $pricing_type_formatted_text = 'Per Year';
            }elseif ($selected_plan_type=='one-time') {
                $pricingtype = 'one_time_purchase';
                $pricing_type_formatted_text = 'One time purchase ';
            }
            

            //check that this plan has price set and features
            $details = $this->getPlanDetailsById($plan_id);
            $details = isset($details[0]) ? $details[0]: $details;

            $price = $details['price'][$pricingtype];
            


            //if(empty($price)){ return back()->with('error','This product price is missing. Cannot be sold.'); }


      

            $stripe_id = "";
            if($pricingtype=='per_month'){
                $stripe_id = $details['stripe_id']['monthly'];
            }elseif($pricingtype=='per_year'){
                $stripe_id = $details['stripe_id']['yearly'];
            }elseif($pricingtype=='one_time_purchase'){
               $stripe_id = $details['stripe_id']['one_time_purchase'];
            }

   
            if(empty($stripe_id)):
               abort(404);
            endif;

            /**
             * Get user default payment information.
             * List the payment methods this user has to enable user switch payment methood he/she wants to use
             * Provide option for user to enter new payment method to be used for this transaction
             */

            $payment_method_type="recurring";
            $paymentMethods = [];
            $default_payment_method = '';
            $intent = "";

            if($selected_plan_type=='monthly' || $selected_plan_type=='yearly'){
              
                if (Auth::check()) {
                    if($request->user()->hasPaymentMethod()){
                    //checking to see if user has atleast one payment method
                    $paymentMethods = $request->user()->paymentMethods()->toArray();
                    $default_payment_method = $request->user()->hasDefaultPaymentMethod() ? $request->user()->defaultPaymentMethod()->toArray() : '';
                    }
                    //Used for subscriptions only
                    $intent = $request->user()->createSetupIntent();
                    
                }else{
                    session(['loginRequestOnStripePaymentOrderPage' => [
                        'plan_id'=>$plan_id,
                        'selected_plan_type'=>$selected_plan_type
                    ]]);
                }

            }else{
                $payment_method_type="oneoff";
                /** The price should be in the lowest denominator of the currency used. See https://laravel.com/docs/10.x/billing#creating-payment-intents */
                if (Auth::check()){
                    $price = $price * 100;
                    $payment = $request->user()->payWith(
                        $price, ['card']
                    );
                    $intent = $payment->client_secret;
                 }
            }


            return view("teckiproadmin::checkout/stripe/checkout")
            ->withDetails($details)
            ->withPricingtype($pricingtype)
            ->withSelectedPlanType($selected_plan_type)
            ->withRealPrice($price)
            ->withPriceTypeFormatted($pricing_type_formatted_text)
            ->withStripeId($stripe_id)
            ->withIntent($intent)
            ->withPaymentMethodType($payment_method_type)
            ->withPaymentMethods($paymentMethods)
            ->withDefaultPaymentMethod($default_payment_method)
            ;
 
   


        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }


}
