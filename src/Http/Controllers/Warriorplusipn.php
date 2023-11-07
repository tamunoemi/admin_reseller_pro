<?php
/**
 * WARRIOR PLUS IPN
 */
namespace Teckipro\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teckipro\Admin\Services\PackageService;
use Teckipro\Admin\Services\UserService;
use Hash;
use Teckipro\Admin\Models\User;
use Teckipro\Admin\Notifications\LoginDetailEmail;
use Teckipro\Admin\Notifications\UpgradeDetailEmail;
use Notification;


class Warriorplusipn extends Controller
{

     /**
     * @var UserService
     */
    protected $userService;

     /**
     * @var PackageService
     */
    protected $packageService;

    /**
     * @var User
     */
    protected $user;


    public function __invoke(Request $request){

        $this->user = new User();
        $this->userService = new UserService($this->user);
        $this->packageService = new PackageService();


    $data = $request->all();

    if(!isset($data['WP_ITEM_NUMBER']) &&  !isset($data['WP_BUYER_EMAIL'])){
        exit("Invalid param sent");
    }

    $cproditem = $data['WP_ITEM_NUMBER'];
    $email = $data['WP_BUYER_EMAIL'];
    $name = $data['WP_BUYER_NAME'];
    $ctransreceipt = $data['WP_TXNID']; //
    $amount = $data['WP_SALE_AMOUNT'];

    /**
     * Compare and get the matching package
     */
    $package_id = $this->packageService->paddle_launch_packageid_matching($cproditem, $this->packageService->launchSubscriptionModel::TYPE_WARRIORPLUS);

    //There submitted package does not exist. Do not continue.
    if(empty($package_id)){
        exit("Invalid request submitted");
    }
    /**
     * Register user
     */
    $password = uniqid(); //for sending login details

    $userData['type'] = User::TYPE_USER;
    $userData['email'] =$email;
    $userData['name'] = $name;
    $userData['password'] = Hash::make($password);
    $userData['active'] = '1';
    $userData['send_confirmation_email'] = '0';



    $result = $this->userService->customRegisterUser($userData);
    $userInfo = $result['user'];
    $send_upgrade_email = $result['send_upgrade_email'];
    $send_login_details = $result['send_login_details'];


    $packageData['name'] = $name;
    $packageData['email'] = $email;
    $packageData['amount'] = $amount;
    $packageData['package_id'] = $package_id;
    $packageData['transactionId'] = $ctransreceipt;


    /**
     * Get expiry date for this subscription
     */
    $expiry_date = $this->packageService->getPackageExpiryDate($package_id);
    $packageData['expires'] = $expiry_date;
    $packageData['user_id'] = $userInfo['id'];
    $packageData['payment_Data'] = json_encode($data);

    $this->packageService->processWplusSubscription($packageData);


    /**
     * Prepare to data to send login details
     */
    if($send_login_details){

        $userData['password'] = $password;
        $userData['user_id'] = $userInfo->id;
        Notification::send($userInfo, new LoginDetailEmail($userData));

    }

    /**
     * Send upgrade info
     */

    $name = $this->packageService->getPackageName($package_id);
    if($send_upgrade_email){
        $upgradeData['name'] = $name;
        Notification::send($userInfo, new UpgradeDetailEmail($upgradeData));
    }






    }



}
