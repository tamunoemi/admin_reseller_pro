<?php

namespace Teckipro\Admin\Domains\Tests;

use Illuminate\Http\Request;
use Teckipro\Admin\Domains\PaymentGateways\Stripe\Model\StripeUser;
use Laravel\Cashier\Cashier;

use Tamunoemi\Laraplans\Models\Plan;
use Tamunoemi\Laraplans\Models\PlanFeature;
use Auth;

class Plans {

    public function createPlan(Request $request){

        $plan = Plan::create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'price' => 9.99,
            'interval' => 'month',
            'interval_count' => 1,
            'trial_period_days' => 15,
            'sort_order' => 1,
        ]);

        $plan->features()->saveMany([
            new PlanFeature(['code' => 'listings', 'value' => 50, 'sort_order' => 1]),
            new PlanFeature(['code' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
            new PlanFeature(['code' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10]),
            new PlanFeature(['code' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);

        dump($plan);


    }

    public function getPlanFeatures(Request $request,$id){
      $plan = Plan::find($id);
      //dd($plan);
      $features = $plan->features()->get();
      dump($features);

    }

    public function subscribeUser(Request $request,$id){
        $plan = Plan::find($id);

        $re = $request->user()->newSubscription('main', $plan)->create();
        dump($re);

      }

}
