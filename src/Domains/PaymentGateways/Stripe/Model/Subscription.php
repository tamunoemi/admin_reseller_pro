<?php
namespace Teckipro\Admin\Domains\PaymentGateways\Stripe\Model;

use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    protected $table = 'stripe_subscriptions';
}
