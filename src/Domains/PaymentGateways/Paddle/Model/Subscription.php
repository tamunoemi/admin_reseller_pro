<?php
namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Model;

use Laravel\Paddle\Subscription as PaddleSubscription;

class Subscription extends PaddleSubscription
{
    protected $table = 'paddle_subscriptions';
}
