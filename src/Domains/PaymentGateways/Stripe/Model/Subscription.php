<?php
namespace Teckipro\Admin\Domains\PaymentGateways\Stripe\Model;

use Laravel\Cashier\Subscription as CashierSubscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subscription extends CashierSubscription
{
    protected $table = 'stripe_subscriptions';
        /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


}
