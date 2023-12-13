<?php
/**
 * 7 Best SaaS Pricing Page Examples (plus 5 SaaS Pricing Strategy Questions to Consider)
 * https://fastspring.com/blog/7-best-saas-pricing-page-examples-plus-5-saas-pricing-strategy-questions-to-consider/
 *
 * 13 Examples of Effective SaaS Pricing Pages That Drive Conversions
 * https://thegood.com/insights/saas-pricing-page/
 *
 * Paddle Api Reference
 * https://developer.paddle.com/classic/api-reference/a835554495295-list-plans
 *
 */
namespace Teckipro\Admin\Domains\Plans\Http\Controllers;


use Illuminate\Http\Request;
use Tamunoemi\Laraplans\Models\Plan;
use Tamunoemi\Laraplans\Models\PlanFeature;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Teckipro\Admin\Http\Controllers\OperationReport;

use Teckipro\Admin\Http\Requests\StorePlanRequest;
use Teckipro\Admin\Http\Requests\EditPlanRequest;
use Teckipro\Admin\Traits\EnvTrait;

use Teckipro\Admin\Services\RoleService;
use Teckipro\Admin\Models\Traits\Method\PlanMethod;
use Illuminate\Support\Facades\Validator;
use Str;
use Illuminate\Support\Facades\Cache;
use DB;
use Teckipro\Admin\Models\StripePricingTableModel;
use Teckipro\Admin\Domains\Plans\Trait\PlanTrait;


class PlanController extends Controller{

    use PlanMethod,EnvTrait,PlanTrait;

    public $operationReport;

    /** Duration of package or plan */
    public $validity = array('D' => 'Day', 'W' => 'Week', 'M' => 'Month', 'Y' => 'Year');
    public $validity_type_arr = array('D'=>1,'W'=>7,'M'=>30,'Y'=>365);
    private $request;
    public const TYPE_LAUNCH = "launch";
    public const TYPE_SAAS = "saas";

    public $planSelectOptions = array(
        'Launch'=>self::TYPE_LAUNCH,
        'Saas'=>self::TYPE_SAAS
    );

    public $subscriptionGatewayOptions = array(
        'Select ..'=>'',
        'Stripe'=>'stripe',
        'Paddle'=>'paddle'
    );

    public $paddle_id,$type,$plan_id,$stripe_id,$jvzoo_id,$appsumo_id,$clickbank_id,$warriorplus_id;

    public $roleService;

    public $default_price_json;
    public $default_gateway_id_json;
    public $default_discount_json;
    public $default_coupon_json;


    public function __construct(RoleService $roleService){
        $this->operationReport = new OperationReport();
        $this->roleService = $roleService;

        $this->default_price_json = json_encode(['per_month'=>'','per_year'=>'', 'one_time_purchase'=>'']);
        $this->default_gateway_id_json =  json_encode(['monthly'=>'','yearly'=>'', 'one_time_purchase'=>'']);
        $this->default_discount_json = json_encode(['per_month'=>'','per_year'=>'','one_time_purchase'=>'']);
        $this->default_coupon_json = json_encode(['monthly'=>'','yearly'=>'','one_time_purchase'=>'']);

    }

    public function pricinglist()
    {
        /**
         * Show pricing base on the default_gateway settings.
         * Options are paddle, stripe and custom
         */
        
        $default_gateway = config('my_config.default_gateway');
     
        if($default_gateway=='paddle'){
            $plans = $this->fetchPlanListing();
            $collection = collect($plans);

            $monthly_plans = $collection->where('paddle_id.monthly','!=','');
            $yearly_plans = $collection->where('paddle_id.yearly','!=','');
            $onetime_plans = $collection->where('paddle_id.one_time_purchase','!=','');

            //determine default plan to show
            $default_plan = 'm';
            if($yearly_plans->isEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isEmpty()){
                $default_plan = 'y';
            }elseif($yearly_plans->isEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isEmpty()){
                $default_plan = 'o';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isEmpty()){
                $default_plan = 'y';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isEmpty()){
                abort(404);
            }
 
            return view("teckiproadmin::checkout/paddle/pricing")
            ->withMonthlyplans($monthly_plans)
            ->withYearlyplans($yearly_plans)
            ->withOnetimeplans($onetime_plans)
            ->withYearlyplanstate($yearly_plans->isEmpty() ? '0': '1')
            ->withMonthlyplanstate($monthly_plans->isEmpty() ? '0': '1')
            ->withOnetimeplanstate($onetime_plans->isEmpty() ? '0': '1')
            ->withDefaultplan($default_plan)
            ;
        }elseif($default_gateway=='stripe'){
           /** Fetch stripe embed pricing table from database */
        
           $plans = $this->fetchPlanListing();
            $collection = collect($plans);

            $monthly_plans = $collection->where('stripe_id.monthly','!=','');
            $yearly_plans = $collection->where('stripe_id.yearly','!=','');
            $onetime_plans = $collection->where('stripe_id.one_time_purchase','!=','');

            //determine default plan to show
            $default_plan = 'm';
            if($yearly_plans->isEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isEmpty()){
                $default_plan = 'y';
            }elseif($yearly_plans->isEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isEmpty()){
                $default_plan = 'o';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isEmpty()){
                $default_plan = 'y';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isNotEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isEmpty() && $onetime_plans->isNotEmpty() && $monthly_plans->isNotEmpty()){
                $default_plan = 'm';
            }elseif($yearly_plans->isEmpty() && $onetime_plans->isEmpty() && $monthly_plans->isEmpty()){
                abort(404);
            }
 
            return view("teckiproadmin::checkout/stripe/pricing")
            ->withMonthlyplans($monthly_plans)
            ->withYearlyplans($yearly_plans)
            ->withOnetimeplans($onetime_plans)
            ->withYearlyplanstate($yearly_plans->isEmpty() ? '0': '1')
            ->withMonthlyplanstate($monthly_plans->isEmpty() ? '0': '1')
            ->withOnetimeplanstate($onetime_plans->isEmpty() ? '0': '1')
            ->withDefaultplan($default_plan)
            ;


        }else{
            abort('Invalid request');
        }
        
        
    }



    public function fetchPlanListing(){
        $plans = Plan::where(['visible'=>'1','deleted'=>'0'])->select('id','name','description','price','discount','coupon', 'interval','interval_count','trial_period_days','stripe_id','paddle_id')->get()->toArray();
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




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //list all packages
      $plans = Plan::count();
      return view('teckiproadmin::plans.index',['totalpackages'=>$plans]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = ['validities'=>$this->validity,
                'roles'=>$this->roleService->getRolesForUsers(),
                'planOptions'=>$this->planSelectOptions
               ];

        return view('teckiproadmin::plans.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



       /**
     * @param  StoreRoleRequest  $request
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StorePlanRequest $request)
    {
        $this->request = $request;
        $data = $this->processformrequest();
        Plan::create($data);
        return redirect()->route('admin.plan.index')->withFlashSuccess(__('The package was successfully created.'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = Plan::find($id);
        $validity_days = $plan->validity;

        if ($validity_days % 365 == 0) {

        $plan->validity_type_info = 'Y';
        $plan->validity_amount = $validity_days / 365;
        }
        else if ($validity_days % 30 == 0) {

        $plan->validity_type_info = 'M';
        $plan->validity_amount = $validity_days / 30;
        }
        else if ($validity_days % 7 == 0) {

            $plan->validity_type_info = 'W';
        $plan->validity_amount = $validity_days / 7;
        }
        else {

            $plan->validity_type_info = 'D';
             $plan->validity_amount = $validity_days;
        }


        $data = [
          'roles'=>$this->roleService->getRolesForUsers(),
          'plan'=>$plan,
          'validities'=>$this->validity,
          'planOptions'=>$this->planSelectOptions
        ];

     return view('teckiproadmin::plans.detail',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $validity_days = $plan->validity;

        if ($validity_days % 365 == 0) {

        $plan->validity_type_info = 'Y';
        $plan->validity_amount = $validity_days / 365;
        }
        else if ($validity_days % 30 == 0) {

        $plan->validity_type_info = 'M';
        $plan->validity_amount = $validity_days / 30;
        }
        else if ($validity_days % 7 == 0) {

            $plan->validity_type_info = 'W';
        $plan->validity_amount = $validity_days / 7;
        }
        else {

            $plan->validity_type_info = 'D';
        $plan->validity_amount = $validity_days;
        }



     $data = ['roles'=>$this->roleService->getRolesForUsers(),
             'plan'=>$plan,
             'validities'=>$this->validity,
             'planOptions'=>$this->planSelectOptions
            ];

     return view('teckiproadmin::plans.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPlanRequest $request, $id)
    {
        $plan = Plan::find($id);
        $this->type = $plan->type;
        $this->paddle_id = $plan->paddle_id;
        $this->warriorplus_id = $plan->warriorplus_id;
        $this->clickbank_id = $plan->clickbank_id;
        $this->stripe_id = $plan->stripe_id;
        $this->jvzoo_id = $plan->jvzoo_id;
        $this->appsumo_id = $plan->appsumo_id;

        $this->request = $request;
        $this->package_id = $id;

        $this->updateUsersRoleAndPermissionsByPackage();
        $data = $this->processformrequest();
        /**
         * reset the package type to remain unchanged for edit.
         * Package type is not allowed to be editted
         */

        //$data->type = $plan->type;
        $plan->update($data);

        return redirect()->route('admin.plan.index')->withFlashSuccess(__('The package was successfully updated.'));
    }


    /**
     * Process package form request
     */

     public function processformrequest(){
         // Retrieve the validated input data...
        $validated = $this->request->validated();

        $type = isset($this->request['type']) ? $this->request['type']: $this->type;

        //SAAS PACKAGE OPTIONS
        $paddle_id = isset($this->request['paddle_id']) ? $this->request['paddle_id']: $this->paddle_id;
        $stripe_id = isset($this->request['stripe_id']) ? $this->request['stripe_id']: $this->stripe_id;

        if(config('my_config.default_gateway')=='paddle'){
            $stripe_id = $this->default_gateway_id_json;
        }
        if(config('my_config.default_gateway')=='stripe'){
            $paddle_id = $this->default_gateway_id_json;
        }
        


        //laUNCH PACKAGE IDS OPTIONS
        $jvzoo_id = isset($this->request['jvzoo_id']) ? $this->request['jvzoo_id']: $this->jvzoo_id;
        $warriorplus_id = isset($this->request['warriorplus_id']) ? $this->request['warriorplus_id']: $this->warriorplus_id;
        $appsumo_id = isset($this->request['appsumo_id']) ? $this->request['appsumo_id']: $this->appsumo_id;
        $clickbank_id = isset($this->request['clickbank_id']) ? $this->request['clickbank_id']: $this->clickbank_id;


        if ($type==self::TYPE_SAAS) {
            if(empty($paddle_id) && empty($stripe_id)){
                return back()->withErrors([
                    'paddle_id'=>'Provide paddle ID',
                    'stripe_id'=>'Or provide Stripe ID',
                    ])->withInput();
            }
        }
        if($type==self::TYPE_LAUNCH){
           if(empty($jvzoo_id) && empty($warriorplus_id) && empty($appsumo_id) && empty($clickbank_id)){
            return back()->withErrors(
                [
                    'jvzoo_id'=>'Set JVZOO ID or any of the other',
                    'warriorplus_id'=>'Set WPLUS ID or any of the other',
                    'appsumo_id'=>'Set APPSUMO ID or any of the other',
                    'clickbank_id'=>'Set CLICKBANK ID or any of the other',
                ]
                )->withInput();
           }
        }


        $visible = $this->request['visible'];
        if($visible=='on')
          $visible = '1';
        else
          $visible = '0';

        $highlight = $this->request['highlight'];
        if($highlight=='on')
           $highlight = '1';
        else
           $highlight = '0';

        $user_can_resell = $this->request['user_can_resell'];
        if($user_can_resell=='on')
           $user_can_resell = '1';
        else
           $user_can_resell = '0';


        $validated['visible'] = $visible;
        $validated['highlight'] = $highlight;
        $validated['interval_count']= $validated['interval_count'];


        /** Calulate plan duration */
        $interval = $validated['interval'];
        $interval_count = (int)$validated['interval_count'];

        $validity_cal = $interval_count * $this->validity_type_arr[$interval];



        $roles = $validated['role_ids'];

        $bulk_limit=$validated['bulk_limit'];
        $monthly_limit=$validated['monthly_limit'];


        $role_str =implode(',',$roles);

        $data=array
                (
                    'name'=>$validated['name'],
                    'name_alias'=>$validated['name_alias'],
                    'price'=>$validated['price'],
                    'description'=>$validated['description'],
                    'trial_period_days'=>$validated['trial_period_days'],
                    'interval'=>Str::lcfirst($this->validity[$interval]),
                    'interval_count'=>$validated['interval_count'],

                    'discount'=>$validated['discount'],
                    'coupon'=>$validated['coupon'],

                    'validity'=>$validity_cal,
                    'visible'=>$validated['visible'],
                    'highlight'=>$validated['highlight'],


                    'role_ids'=>$role_str,
                    'monthly_limit'=>$monthly_limit,
                    'bulk_limit'=>$bulk_limit,

                    'type'=>$type,

                    'paddle_id'=>$paddle_id,
                    'jvzoo_id'=>$jvzoo_id,
                    'warriorplus_id'=>$warriorplus_id,
                    'appsumo_id'=>$appsumo_id,
                    'clickbank_id'=>$clickbank_id,
                    'stripe_id'=>$stripe_id,

                    'user_can_resell'=>$user_can_resell
                );
     return $data;
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $plan = Plan::find($id);
        $plan->delete();

        return redirect()->route('admin.plan.index')->withFlashSuccess(__('The package was successfully deleted.'));
    }


    public function plansettings(){
        return view("teckiproadmin::plans.settings")->withSubscriptionGatewayOptions($this->subscriptionGatewayOptions);
    }

    public function saveplansettings(Request $request){
        $validator = Validator::make($request->all(), [
            'DEFAULT_SUBSCRIPTION_GATEWAY' => 'required',
            'MONTHLY_YEARLY_PLAN_OPTION'=>'required',
            'CASHIER_CURRENCY' => 'required',
         ]);
         $validated = $validator->validated();
         $MONTHLY_YEARLY_PLAN_OPTION = !isset($validated['MONTHLY_YEARLY_PLAN_OPTION']) ? 0 : 1;



        //setting the app name
        $this->setEnv("DEFAULT_SUBSCRIPTION_GATEWAY",$validated['DEFAULT_SUBSCRIPTION_GATEWAY']);
        $this->setEnv("MONTHLY_YEARLY_PLAN_OPTION", $MONTHLY_YEARLY_PLAN_OPTION);
        $this->setEnv("CASHIER_CURRENCY", $validated['CASHIER_CURRENCY']);

        return redirect()->route('admin.plan.settings')->with('success', __('Plan setting successfully updated.'));
    }

    /**
     * Return plan info using a provided vendor id
     */
    public static function sortPlanByVendorId($vendor_id="",$vendor="paddle"){
        if(!$vendor_id){ return ''; }
        $plan =  Cache::rememberForever('plan', function () {
            return DB::table('plans')->select('id','price','jvzoo_id','warriorplus_id','paddle_id','appsumo_id','clickbank_id','stripe_id')->get()->toArray();
        });

        $plan = objectToArray($plan);
        $plan_fmt = array();
        foreach ($plan as $key => $value) {
             $value['jvzoo_id'] = json_decode($value['jvzoo_id']);
             $value['warriorplus_id'] = json_decode($value['warriorplus_id'], true);
             $value['paddle_id'] = json_decode($value['paddle_id'], true);
             $value['appsumo_id'] = json_decode($value['appsumo_id'], true);
             $value['stripe_id'] = json_decode($value['stripe_id'], true);
             $value['clickbank_id'] = json_decode($value['clickbank_id'], true);
             $value['price'] = json_decode($value['price'], true);

             $plan_fmt['plans'][$key] = $value;
        }


        $result = '';
        $plan_duration_type = "monthly";
        switch ($vendor) {
            case 'paddle':
                $result = collect($plan_fmt['plans'])->where('paddle_id.monthly',$vendor_id)->first();
                if(!$result){
                    $result = collect($plan_fmt['plans'])->where('paddle_id.yearly',$vendor_id)->first();
                    $plan_duration_type = "yearly";
                }
                break;

            case 'stripe':
                $result = collect($plan_fmt['plans'])->where('stripe_id.monthly',$vendor_id)->first();
                if(!$result){
                    $result = collect($plan_fmt['plans'])->where('stripe_id.yearly',$vendor_id)->first();
                    $plan_duration_type = "yearly";
                }
                break;

            case 'jvzoo':
                $result = collect($plan_fmt['plans'])->where('jvzoo_id.monthly',$vendor_id)->first();
                if(!$result){
                    $result = collect($plan_fmt['plans'])->where('jvzoo_id.yearly',$vendor_id)->first();
                    $plan_duration_type = "yearly";
                }
                break;

            case 'warriorplus':
                $result = collect($plan_fmt['plans'])->where('warriorplus_id.monthly',$vendor_id)->first();
                if(!$result){
                    $result = collect($plan_fmt['plans'])->where('warriorplus_id.yearly',$vendor_id)->first();
                    $plan_duration_type = "yearly";
                }
                break;


            case 'appsumo':
                $result = collect($plan_fmt['plans'])->where('appsumo_id.monthly',$vendor_id)->first();
                if(!$result){
                    $result = collect($plan_fmt['plans'])->where('appsumo_id.yearly',$vendor_id)->first();
                    $plan_duration_type = "yearly";
                }
                break;

            case 'clickbank':
                $result = collect($plan_fmt['plans'])->where('clickbank_id.monthly',$vendor_id)->first();
                if(!$result){
                    $result = collect($plan_fmt['plans'])->where('clickbank_id.yearly',$vendor_id)->first();
                    $plan_duration_type = "yearly";
                }
                break;

        }

        if(!empty($result)){
            $result['plan_duration_type'] = $plan_duration_type;
        }


        //dd($result);
        return $result;

    }







}
