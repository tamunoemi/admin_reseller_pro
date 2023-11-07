<?php

namespace Teckipro\Admin\Domains\Tests;

use Illuminate\Http\Request;
use Teckipro\Admin\Domains\PaymentGateways\Stripe\Model\StripeUser;
use Auth;
use Tamunoemi\Laraplans\Models\Plan;

class Stripe {

    public function createPlan(Request $request){

        $plan = Plan::create([
            'name' => 'Gold',
            'description' => 'Gold plan',
            'price' => 99,
            'interval' => 'month',
            'interval_count' => 1,
            'trial_period_days' => 3,
            'sort_order' => 1,
            'stripe_id'=>'price_1O3ZngD4TuPSjCa7fLMDa3VN'
        ]);

        dump($plan);


    }


    public function getPlanFeatures(Request $request,$id){


    }

    public function subscribeUser(Request $request,$id){


      }

}
