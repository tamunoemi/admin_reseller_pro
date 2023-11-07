<?php
namespace Teckipro\Admin\Traits;


use Illuminate\Http\Request;
use Teckipro\Admin\Models\User;
use Laravel\Paddle\Cashier;



/**
 * Trait SubscriptionTrait
 *
 * Reference
 */
trait PaddleTrait
{



    public function getBillableUserName($id){
      $resp = User::find($id);
      return $resp['name'];
    }

    /**
     * Without Payment Method Up Front
     * https://laravel.com/docs/9.x/cashier-paddle#without-payment-method-up-front
     *
     */

    public function launchUserSubscription($arg,$user){


        $package_id = $arg['package_id'];
        /**
         * Get launch package duration
         */

        $days = 360;
        $user->createAsCustomer([
            'trial_ends_at' => now()->addDays($days)
        ]);

    }

    /**
     * Check if launch subscribed user plan has expired or not
     */
    public function checkIfLaunchUserIsOnTrial($user){
        if ($user->onTrial()) {
            // User is within their trial period...
            return true;
        }else{
            return false;
        }
    }

    /**
     * create an actual subscription for the user
     * that bought during launch
     */
    public function subscribeLaunchUser($paddle_id,$user){

        //get package name by paddle_id
        $packagename = '';
        $payLink = $user->newSubscription($packagename,$paddle_id)
        ->returnTo(route(''.env('FRONTENDROUTENAME').''))
        ->create();
        return $payLink;

    }

    /**
     * You may use the onGenericTrial method if you wish to know
     * specifically that the user is within their "generic" trial period and
     * has not created an actual subscription yet:
     */
    public function isUserOnGenericTrial(){
        if ($user->onGenericTrial()) {
            // User is within their "generic" trial period...
            return true;
        }else{
            return false;
        }
    }

    /**
     * retrieve the user's trial ending date
     */
    public function getUserTrialEndDate($packagename,$user){

        $trialEndsAt = "";
        if ($user->onTrial()) {
            $trialEndsAt = $user->trialEndsAt($packagename);
        }
        return $trialEndsAt;
    }


}
