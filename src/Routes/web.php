<?php
use Illuminate\Http\Request;

use Teckipro\Admin\Models\Role;
use Teckipro\Admin\Models\User;
use Tabuna\Breadcrumbs\Trail;

use Illuminate\Support\Facades\Route;
use Teckipro\Admin\Domains\PaymentGateways\Paddle\Http\Controllers\PaddleController;
use Teckipro\Admin\Http\Middleware\AdminCheck;


use Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController;
use Teckipro\Admin\Http\Controllers\ModuleController;
use Teckipro\Admin\Models\Package;
use Teckipro\Admin\Models\Modules;
use Teckipro\Admin\Http\Controllers\LaunchSubscriptions;
use Teckipro\Admin\Models\LaunchSubscriptionModel as LaunchModel;
use Teckipro\Admin\Http\Controllers\AdminController;

use Teckipro\Admin\Http\Controllers\FileManagerController;
use Teckipro\Admin\Http\Controllers\TutorialController;

use Teckipro\Admin\Http\Controllers\DashboardController;

use Teckipro\Admin\Models\Tutorials;

use Teckipro\Admin\Http\Controllers\Permissions\PermissionController;
use Teckipro\Admin\Models\Permission;
use Teckipro\Admin\Http\Controllers\SettingController;
use Teckipro\Admin\Http\Controllers\AnnouncementController;

use App\Http\Controllers\HomeController;

use Teckipro\Admin\Domains\PaymentGateways\Stripe\Http\Controller\StripeSubscriptionController;
use Teckipro\Admin\Domains\PaymentGateways\Concerns\Paymentgateways;

use Teckipro\Admin\Domains\Plans\Http\Controllers\FeaturesController;


use Teckipro\Admin\Domains\Tests\Plans as TestPlans;
use Teckipro\Admin\Domains\Tests\Stripe as StripeTest;


/*
 * Backend Routes
 */



/*
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'web'], function () {

  Route::redirect('/', '/admin/dashboard', 301);

Route::get('dashboard', [DashboardController::class, 'index'])
->middleware('admin')
->name('dashboard')
->breadcrumbs(function (Trail $trail) {
    $trail->push(__('Home'), route('admin.dashboard'));
});



});



/*
 *
 * These routes can only be accessed by users with type `tradmin` and admin users
 */

Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware'=>['web','admin']], function () {


  Route::get('filemanager', [FileManagerController::class, 'index'])->middleware(['permission:admin.filemanager','is_super_admin']);

        //Route::get('inspire', [PaddleController::class,'justDoIt']);

        /** Paddle management */
        Route::group([
            'prefix'=>'paddle',
            'as'=>'paddle.'
          ], function(){


            Route::get('/', [PaddleController::class, 'index'])
            ->name('index')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.paddle.index')
                    ->push(__('Saas Subscriptions'), route('admin.paddle.index'));
            });

            Route::get('/receipts', [PaddleController::class, 'receipt'])
            ->name('receipts')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.paddle.receipts')
                    ->push(__('Saas Subscriptions'), route('admin.paddle.receipts'));
            });


            Route::get('/customers', [PaddleController::class, 'customers'])
            ->name('customers')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.paddle.customers')
                    ->push(__('Saas Subscriptions'), route('admin.paddle.customers'));
            });


          });





                   /** Plan management */
                   Route::group([
                    'prefix'=>'plan',
                    'as'=>'plan.',
                    'middleware'=>['permission:admin.plan.index','is_super_admin']
                  ], function(){

                    Route::get('/', [PlanController::class, 'index'])
                    ->name('index')
                    ->breadcrumbs(function (Trail $trail) {
                        $trail->parent('admin.dashboard')
                            ->push(__('Plan Management'), route('admin.plan.index'));
                    });


                    Route::get('create', [PlanController::class, 'create'])
                    ->name('create')
                    ->breadcrumbs(function (Trail $trail) {
                        $trail->parent('admin.plan.index')
                            ->push(__('Create Plan'), route('admin.plan.create'));
                    });


                    Route::post('create', [PlanController::class, 'store'])
                    ->name('store');

                    Route::get('settings', [PlanController::class, 'plansettings'])
                    ->name('settings')
                    ->breadcrumbs(function (Trail $trail) {
                        $trail->parent('admin.plan.index')
                            ->push(__('Stripe Settings'), route('admin.plan.settings'));
                    });

                    Route::post('saveplansettings', [PlanController::class, 'saveplansettings'])
                    ->name('saveplansettings');



                    #FEATURES
                    Route::group(['prefix'=>'features','as'=>'features.'], function(){

                        Route::get('index', [FeaturesController::class, 'index'])
                        ->name('index')
                        ->breadcrumbs(function (Trail $trail) {
                            $trail->parent('admin.plan.index')
                                ->push(__('Plan features'), route('admin.plan.features.index'));
                        });



                        Route::get('create', [FeaturesController::class, 'create'])
                        ->name('create')
                        ->breadcrumbs(function (Trail $trail) {
                            $trail->parent('admin.plan.index')
                                ->push(__('Plan features'), route('admin.plan.features.create'));
                        });





                        Route::post('add', [FeaturesController::class, 'store'])
                        ->name('add');

                        Route::post('delete', [FeaturesController::class, 'delete'])
                        ->name('delete');

                        Route::get('getPlanFeaturesTablerows', [FeaturesController::class, 'getPlanFeaturesTablerows'])
                        ->name('getPlanFeaturesTablerows');

                    });//end of features





                     #PAYMENT GATEWAY FOR STRIPE AND PADDLE ONLY
                     Route::group(['prefix'=>'gateway','as'=>'gateway.'], function(){



                        Route::get('paddle', [PaddleController::class, 'settings'])
                        ->name('paddle')
                        ->breadcrumbs(function (Trail $trail) {
                            $trail->parent('admin.plan.index')
                                ->push(__('Paddle Settings'), route('admin.plan.gateway.paddle'));
                        });

                        Route::post('savepaddlesettings', [PaddleController::class, 'updatePaddleSettings'])
                        ->name('savepaddlesettings');

                        Route::get('stripe', [StripeSubscriptionController::class, 'settings'])
                        ->name('stripe')
                        ->breadcrumbs(function (Trail $trail) {
                            $trail->parent('admin.plan.index')
                                ->push(__('Stripe Settings'), route('admin.plan.gateway.stripe'));
                        });

                        Route::post('savestripesettings', [StripeSubscriptionController::class, 'updateStripeSettings'])
                        ->name('savestripesettings');





                     });
                     //end of gateway






                    Route::group(['prefix'=>'{plan}'], function(){

                    Route::post('create', [PlanController::class, 'store']);

                    Route::get('edit', [PlanController::class, 'edit'])
                    ->name('edit')
                    ->breadcrumbs(function (Trail $trail, Plan $plan) {
                        $trail->parent('admin.dashboard')
                            ->push(__('Plan Edit: '.$plan->name,['plan'=>$plan->name]), route('admin.plan.edit',$plan));
                    });

                    Route::post('edit', [PlanController::class, 'update'])
                    ->name('update');

                    Route::get('view', [PlanController::class, 'show'])
                    ->name('view');

                    Route::delete('/', [PlanController::class, 'destroy'])
                    ->name('delete');

                    });

                    Route::group(['prefix'=>'launch','as'=>'launch.'], function(){

                            Route::get('/', [LaunchSubscriptions::class, 'index'])
                            ->name('index')
                            ->breadcrumbs(function (Trail $trail) {
                            $trail->parent('admin.dashboard')
                            ->push(__('Launch Subscriptions'), route('admin.plan.launch.index'));
                            });

                            Route::group(['prefix'=>'{launch}','middleware'=>'is_super_admin'], function(){

                                Route::get('edit', [LaunchSubscriptions::class, 'edit'])
                                ->name('edit')
                                ->breadcrumbs(function (Trail $trail, LaunchModel $launchModel) {
                                    $trail->parent('admin.dashboard')
                                        ->push(__('Edit Launch Purchase: '.$launchModel->id), route('admin.plan.launch.edit',$launchModel));
                                });

                                Route::post('edit', [LaunchSubscriptions::class, 'update'])
                                ->name('update');

                                Route::get('view', [LaunchSubscriptions::class, 'show'])
                                ->name('view');

                                Route::delete('/', [LaunchSubscriptions::class, 'destroy'])
                                ->name('delete');

                        });


                    });


                  });





     /** User management */
     Route::group([
        'prefix'=>'user',
        'as'=>'user.'
      ], function(){

        Route::group(['prefix'=>'package','as'=>'package.'], function(){

          Route::group(['prefix'=>'{package}'], function(){

            Route::get('edit', [AdminController::class, 'userLaunchPackageEdit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, User $user) {
                  $trail->parent('admin.auth.user.show', $user)
                    ->push($user->name, route('admin.user.package.edit',$user));
            });

            Route::post('edit', [AdminController::class, 'updateUserLaunchPackage'])
            ->name('update');

            Route::get('view', [AdminController::class, 'viewUserLaunchPackage'])
            ->name('view');


            Route::delete('/', [AdminController::class, 'destroyUserLaunchPackage'])
            ->name('delete');

          });

  });



        Route::group(['prefix'=>'{user}'], function(){

            Route::get('edit', [AdminController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, User $user) {
                  $trail->parent('admin.auth.user.show', $user)
                    ->push($user->name, route('admin.user.edit',$user));
            });

            Route::post('edit', [AdminController::class, 'update'])
            ->name('update');

            Route::patch('/updateSubscription', [AdminController::class, 'updateSubscription'])->name('updatesubscription');

            Route::delete('/', [AdminController::class, 'destroy'])
            ->name('delete');

    });



      });






      /**TUTORIALS */
       Route::group([
        'prefix'=>'tutorial',
        'as'=>'tutorial.'
      ], function(){


        Route::get('/', [TutorialController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.tutorial.index')
                ->push(__('Tutorials Management'), route('admin.tutorial.index'));
        });

        Route::get('/create', [TutorialController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push(__('Tutorial Management'), route('admin.tutorial.create'));
        });

        Route::post('/create',[TutorialController::class, 'store']);


        Route::group(['prefix'=>'{tutorial}'], function(){

            Route::get('edit', [TutorialController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Tutorials $tutorial) {
                $trail->parent('admin.dashboard')
                    ->push(__('Tutorial Edit: '.$tutorial->title), route('admin.tutorial.edit',$tutorial));
            });

            Route::post('edit', [TutorialController::class, 'update'])
            ->name('update');

            Route::delete('/', [TutorialController::class, 'destroy'])
            ->name('delete');

    });




      });







      /**PERMISSION */
      Route::group([
        'prefix'=>'permission',
        'as'=>'permission.',
        'middleware'=>'is_super_admin'
      ], function(){


        Route::get('/', [PermissionController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.permission.index')
                ->push(__('Permission Management'), route('admin.permission.index'));
        });

        Route::get('/create', [PermissionController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push(__('Permission Management'), route('admin.permission.create'));
        });

        Route::post('/create',[PermissionController::class, 'store']);


        Route::group(['prefix'=>'{permission}'], function(){

            Route::get('edit', [PermissionController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Permission $Permission) {
                $trail->parent('admin.dashboard')
                    ->push(__('Permission Edit: '.$Permission->name), route('admin.permission.edit',$Permission));
            });

            Route::post('edit', [PermissionController::class, 'update'])
            ->name('update');

            Route::delete('/', [PermissionController::class, 'destroy'])
            ->name('delete');

    });

      });




       /**SETTINGS */
       Route::group([
        'prefix'=>'setting',
        'as'=>'setting.',
        'middleware'=>'is_super_admin'
      ], function(){


        /** Brand setting */
        Route::get('/', [SettingController::class, 'brandSettings'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.setting.index')
                ->push(__('Brand Settings'), route('admin.setting.index'));
        });
        Route::post('/brand',[SettingController::class, 'updatebrandSettings'])->name('brand');
        //Route::post('/logo',[SettingController::class, 'updatebrandLogoSettings'])->name('logo');
        //Route::post('/favicon',[SettingController::class, 'updatebrandSettings'])->name('favicon');



        /** Mail setting*/
        Route::get('/mail', [SettingController::class, 'mailSettings'])
        ->name('mail')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.setting.index')
                ->push(__('Mail Settings'), route('admin.setting.mail'));
        });


        Route::post('/mail',[SettingController::class, 'updateMailSetting']);



        /** Database setting */
        Route::get('/database', [SettingController::class, 'databaseSettings'])
        ->name('database')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.setting.index')
                ->push(__('Database Settings'), route('admin.setting.database'));
        });

        Route::post('/database',[SettingController::class, 'updateDatabaseSetting']);




        /** Webhook URLS */
        Route::get('/webhook', [SettingController::class, 'webhook'])
        ->name('webhook')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.setting.webhook')
                ->push(__('Webhook URLs'), route('admin.setting.webhook'));
        });


         /** Webhook URLS */
         Route::get('/payment', [SettingController::class, 'payment'])
         ->name('payment')
         ->breadcrumbs(function (Trail $trail) {
             $trail->parent('admin.setting.payment')
                 ->push(__('Payment Settings'), route('admin.setting.payment'));
         });



      });




      /**TUTORIALS */
      Route::group([
        'prefix'=>'announcement',
        'as'=>'announcement.'
      ], function(){


        Route::get('/', [AnnouncementController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.announcement.index')
                ->push(__('Announcement Management'), route('admin.announcement.index'));
        });

        Route::get('/create', [AnnouncementController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.dashboard')
                ->push(__('Announcement Management'), route('admin.announcement.create'));
        });

        Route::post('/create',[AnnouncementController::class, 'store']);


        Route::group(['prefix'=>'{announcement}'], function(){


        Route::delete('/', [AnnouncementController::class, 'destroy'])
        ->name('delete');

    });




      });
      //end of announcement


/** Test */
Route::group([
    'prefix'=>'test',
    'as'=>'test.'
    ], function(){


    Route::get('test', [\Teckipro\Admin\Http\Controllers\BillingController::class,'getRefunds']);




    }); //end of test




});





//Subscription and plans

Route::middleware("web")->group(function () {

    Route::get('site/pricing', [PlanController::class, 'pricinglist'])->name('site.pricing');
    Route::post('site/pricing/review', [PlanController::class, 'reviewSubscription'])->name("plans.reviewsubscription");

   
    Route::post('stripe/subscription/create', [StripeSubscriptionController::class, 'createSubscription'])->name('stripe.subscription.create');
    Route::get('site/pricing/subscription/success', [PaddleController::class, 'subscription_success'])->name("subscriptionsuccess");
    Route::get('paddle/revieworder', [PaddleController::class, 'revieworder'])->name('paddle.revieworder');
    Route::get('stripe/revieworder', [StripeSubscriptionController::class, 'revieworder'])->name('stripe.revieworder');
    Route::get('stripe/order/success', [StripeSubscriptionController::class, 'ordersuccess'])->name('stripe.order.success');


    //LOGIN WITH GOOGLE
    Route::get('login/google/redirect', [Teckipro\Admin\Domains\Google\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('login/google/callback', [Teckipro\Admin\Domains\Google\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');


    /** Test */
Route::group([
    'prefix'=>'test',
    'as'=>'test.'
    ], function(){


    Route::get('test', [\Teckipro\Admin\Http\Controllers\BillingController::class,'getRefunds']);




    }); //end of test


});



