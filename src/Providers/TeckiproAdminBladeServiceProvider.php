<?php

namespace Teckipro\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use Teckipro\Admin\Http\Livewire\TutorialTable;
use Teckipro\Admin\Http\Livewire\LaunchSubscriptionTable;
use Teckipro\Admin\Http\Livewire\ModulesTable;
use Teckipro\Admin\Http\Livewire\PlanTable;
use Teckipro\Admin\Http\Livewire\PaddleTable;
use Teckipro\Admin\Http\Livewire\ReceiptSubscriptionTable;
use Teckipro\Admin\Http\Livewire\ReceiptTable;
use Teckipro\Admin\Http\Livewire\RolesTable;
use Teckipro\Admin\Http\Livewire\SaasCustomersTable;
use Teckipro\Admin\Http\Livewire\SaasSubscriptionTable;
use Teckipro\Admin\Http\Livewire\UserLaunchSubscriptionTable;
use Teckipro\Admin\Http\Livewire\UsersTable;
use Teckipro\Admin\Http\Livewire\PermissionTable;
use Teckipro\Admin\Http\Livewire\UserRolesTable;
use Teckipro\Admin\Http\Livewire\UserPermissionTable;
use Teckipro\Admin\Http\Livewire\AnnouncementTable;



use Livewire;

class TeckiproAdminBladeServiceProvider extends ServiceProvider
{



/**
 * Bootstrap your package's services.
 *
 * @return void
 */
    public function boot()
    {
        Blade::componentNamespace('Teckipro\\Admin\\Resources\\Views\\Components', 'teckiproadmin');


        /**
         * Register livewire components
         * Reference: https://laravel-livewire.com/docs/2.x/package-dev
         */
        Livewire::component('tutorial-table', TutorialTable::class);
        Livewire::component('launch-subscription-table', LaunchSubscriptionTable::class);
        Livewire::component('modules-table', ModulesTable::class);
        Livewire::component('plan-table', PlanTable::class);
        Livewire::component('paddle-table', PaddleTable::class);
        Livewire::component('receipt-subscription-table', ReceiptSubscriptionTable::class);
        Livewire::component('receipt-table', ReceiptTable::class);
        Livewire::component('roles-table', RolesTable::class);
        Livewire::component('saas-customers-table', SaasCustomersTable::class);
        Livewire::component('saas-subscription-table', SaasSubscriptionTable::class);
        Livewire::component('user-launch-subscription-table', UserLaunchSubscriptionTable::class);
        Livewire::component('users-table', UsersTable::class);
        Livewire::component('permission-table', PermissionTable::class);
        Livewire::component('user-roles-table', UserRolesTable::class);
        Livewire::component('user-permission-table', UserPermissionTable::class);
        Livewire::component('announcement-table', AnnouncementTable::class);
    }
}

