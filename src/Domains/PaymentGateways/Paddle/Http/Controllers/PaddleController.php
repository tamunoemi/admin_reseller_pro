<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

use Teckipro\Admin\Models\PaddleModel;
use Teckipro\Admin\Models\ReceiptModel;
use Teckipro\Admin\Models\PaddleCustomersModel;
use Teckipro\Admin\Traits\PaddleTrait;
use Teckipro\Admin\Traits\EnvTrait;
use Illuminate\Support\Facades\Validator;


class PaddleController
{

    use PaddleTrait,EnvTrait;

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


}
