<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Concerns;

use Teckipro\Admin\Domains\PaymentGateways\Models\Paymentgateways as paymentGatewayModel;
use Auth;
use Log;

class Paymentgateways {

    public $model;
    private $user_id;

    public function __construct(){
        $this->model = new paymentGatewayModel();
       $this->user_id = Auth::user()->id;
    }


    public function create(array $data)
    {
          try {
            //check that this record does not already exist
            $this->model::firstOrCreate($data);
          } catch (\Exception $e) {
             Log::error($e);
          }

    }

    public function updateStatus($id,$active='1'){

        try {
            $data = array('is_active'=>$active);
            $this->model::where('id',$id)->update($data);
            return true;
        } catch (\Exception $e) {
            Log::error($e);
        }

    }





}
