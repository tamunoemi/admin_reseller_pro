<?php

namespace Teckipro\Admin\Services;


use App\Services\BaseService;

use Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController;

use Tamunoemi\Laraplans\Models\Plan;
use Teckipro\Admin\Models\User;
use Teckipro\Admin\Models\LaunchSubscriptionModel;
use Teckipro\Admin\Services\UserSubscriptionService;
use Carbon\Carbon;
use Teckipro\Admin\Notifications\UpgradeDetailEmail;
use Teckipro\Admin\Traits\PaddleTrait;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;
use Teckipro\Admin\Models\Traits\Method\PlanMethod;

use Notification;

/**
 * Class PermissionService.
 */
class PackageService extends BaseService
{

    use PaddleTrait;
    use PlanMethod;


    public $launchSubscriptionModel;

    public $userSubscriptionService;

    public function __construct()
    {
        $this->model = new Plan();
        $this->launchSubscriptionModel = new LaunchSubscriptionModel();
        $this->userSubscriptionService = new UserSubscriptionService();
    }

    public function getAll(){
        $list_ = $this->model::all();
        return $this->format_package_as_array($list_);
    }

    public function getLaunchPackages(){
        $list_ = $this->model::where(array('type'=>PlanController::TYPE_LAUNCH,'deleted'=>'0'))->get();
        return $this->format_package_as_array($list_);
    }

    public function getSaasPackages(){
        $list_ = $this->model::where(array('type'=>PlanController::TYPE_SAAS,'deleted'=>'0'))->get();
       return $this->format_package_as_array($list_);
    }

    public function paddle_launch_packageid_matching($itemNumber,$launch_package_type){
        $result = "";
        switch($launch_package_type):
            case $this->launchSubscriptionModel::TYPE_JVZOO:
                $result = PlanController::sortPlanByVendorId($itemNumber,$vendor="jvzoo");
                break;

            case $this->launchSubscriptionModel::TYPE_WARRIORPLUS:
                $result = PlanController::sortPlanByVendorId($itemNumber,$vendor="warriorplus");
                break;

            case $this->launchSubscriptionModel::TYPE_CLICKBANK:
                $result = PlanController::sortPlanByVendorId($itemNumber,$vendor="clickbank");
                break;

            case $this->launchSubscriptionModel::TYPE_APPSUMO:
                $result = PlanController::sortPlanByVendorId($itemNumber,$vendor="appsumo");
                break;

        endswitch;
        return isset($result['id']) ? $result['id']: '';

    }


    private function format_package_as_array($list_){
        $packages = array();
        if(!empty($list_)):
            foreach($list_ as $list):
                $packages[$list->name] = $list->id;
            endforeach;
        endif;
        return $packages;
    }


    /**
     * Get package name by package ID
     */

     public function getPackageName($plan_id):string
     {
        $resp = $this->model::select('name')->where(array('id'=>$plan_id))->first();
        return $resp['name'];
     }

     /**
     * Get package name by package ID
     */

     public function getPackageExpiryDate($plan_id){
        $resp = $this->model::select('validity')->where(array('id'=>$plan_id))->first();
        $validity = (int)$resp['validity'];
        $formattedDate= Carbon::now()->addDays($validity);
        return $formattedDate->toDateTimeString();
     }

    /**
     * process saas subscription
     */
    public function sassSubscription($arg, $user){

    }


      /**
     * process launch subscription
     */
    public function launchSubscription($arg,$user){
        unset($arg['type']); //remove the type param
        $plan_id = $arg['package_id'];

        //get packagename
        $name = $this->getPackageName($plan_id);
        $launch_package_type = $arg['launch_package_type'];

        $arg['name'] = $user['name'];
        $arg['email'] = $user['email'];
        $expires = $arg['expired_date'];
        unset($arg['expired_date']);
        $arg['expires'] = $expires;
        $arg['user_id'] = $user['id'];
        $arg['payment_Data'] = json_encode($arg);

        unset($arg['launch_package_type']);

        $status = false;

        //get the package amount if package type is custom
        switch($launch_package_type):
            case $this->launchSubscriptionModel::TYPE_CUSTOM:
                $status = $this->processCustomSubscription($arg);
                break;

            case $this->launchSubscriptionModel::TYPE_JVZOO:
                $status = $this->processJvzooSubscription($arg);

            break;

            case $this->launchSubscriptionModel::TYPE_WARRIORPLUS:
                $status = $this->processWplusSubscription($arg);
            break;

            case $this->launchSubscriptionModel::TYPE_CLICKBANK:
                $status = $this->processClickbankSubscription($arg);
            break;


            case $this->launchSubscriptionModel::TYPE_APPSUMO:
                $status = $this->processAppsumoSubscription($arg);
            break;

        endswitch;

        if($status){
            $upgradeData['name'] = $name;
            Notification::send($user, new UpgradeDetailEmail($upgradeData));
        }
        return true;

    }



    /**
     * @var processJvzooSubscription
     */

     public function processJvzooSubscription($arg){

        $arg['type'] = $this->launchSubscriptionModel::TYPE_JVZOO;
        $this->saveSubscription($arg);
        //Assign role and permissions
        $plan_id = $arg['package_id'];
        $user_id = $arg['user_id'];
        $user = User::find($user_id);
        $this->assignPermissionAndRolesToUser($plan_id,$user);
        return true;

     }


      /**
     * @var processWplusSubscription
     */

     public function processWplusSubscription($arg){
        $arg['type'] = $this->launchSubscriptionModel::TYPE_WARRIORPLUS;
        $this->saveSubscription($arg);
        //Assign role and permissions
        $plan_id = $arg['package_id'];
        $user_id = $arg['user_id'];
        $user = User::find($user_id);
        $this->assignPermissionAndRolesToUser($plan_id,$user);
        return true;

     }


       /**
     * @var processCustomSubscription
     */

     public function processCustomSubscription($arg){
        $arg['type'] = $this->launchSubscriptionModel::TYPE_CUSTOM;
        $this->saveSubscription($arg);
        //Assign role and permissions
        $plan_id = $arg['package_id'];
        $user_id = $arg['user_id'];
        $user = User::find($user_id);
        $this->assignPermissionAndRolesToUser($plan_id,$user);
        return true;

     }


    /**
     * @var processClickbankSubscription
     */
     public function processClickbankSubscription($arg){
        $arg['type'] = $this->launchSubscriptionModel::TYPE_CLICKBANK;
        $this->saveSubscription($arg);
        //Assign role and permissions
        $plan_id = $arg['package_id'];
        $user_id = $arg['user_id'];
        $user = User::find($user_id);
        $this->assignPermissionAndRolesToUser($plan_id,$user);
        return true;
     }


      /**
     * @var processAppsumoSubscription
     */

     public function processAppsumoSubscription($arg){
        $arg['type'] = $this->launchSubscriptionModel::TYPE_APPSUMO;
        $this->saveSubscription($arg);
        //Assign role and permissions
        $plan_id = $arg['package_id'];
        $user_id = $arg['user_id'];
        $user = User::find($user_id);
        $this->assignPermissionAndRolesToUser($plan_id,$user);
        return true;
     }


     public function saveSubscription($arg){
        $plan_id = $arg['package_id'];
        $user_id = $arg['user_id'];

        $arg['is_active'] = '1';
        $can_send_upgrade_info = false;

        /**
         * Check if user is already subscribed to this package
         */
        if (LaunchSubscriptionModel::where(array('package_id'=>$plan_id,'is_active'=>'1','user_id'=>$user_id))->exists()) {
           return;
        }else{
            LaunchSubscriptionModel::create($arg);
            $can_send_upgrade_info = true;

            /**
             * register user on paddle as customer
             */
        }
        return $can_send_upgrade_info;
     }






}
