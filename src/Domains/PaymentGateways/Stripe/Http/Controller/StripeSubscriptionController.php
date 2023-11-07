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

class StripeSubscriptionController
{
    use EnvTrait;

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


}
