<?php

namespace Teckipro\Admin\Domains\Plans\Trait;

use Illuminate\Http\Request;

use Tamunoemi\Laraplans\Models\Plan;
use Tamunoemi\Laraplans\Models\PlanFeature;
use Auth;

trait PlanTrait {

   
    public function getplanDetailsById($plan_id){
        $plans = Plan::where('id',$plan_id)->select('id','name','description','price','discount','coupon', 'interval','interval_count','trial_period_days','stripe_id','paddle_id')->get()->toArray();
        $result = array();
        foreach ($plans as $key => $value) {
            $planId = $value['id'];
            $value['paddle_id'] = json_decode($value['paddle_id'], true);
            $value['stripe_id'] = json_decode($value['stripe_id'], true);
            $value['discount'] = json_decode($value['discount'], true);
            $value['coupon'] = json_decode($value['coupon'], true);
            $value['price'] = json_decode($value['price'], true);
            $features = $this->getFeaturesByPlanId($planId);
            $value['features'] = $features;
            $result[$key] = $value;

        }
       return $result;
    }


    public function getFeaturesByPlanId($planId){
        $Planfeature = new PlanFeature();
        $features = $Planfeature->where("plan_id",$planId)->select('code','value')->orderBy('sort_order', 'asc')->get()->toArray();
        return $features;
    }
    

}
