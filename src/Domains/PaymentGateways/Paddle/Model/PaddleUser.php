<?php
namespace Teckipro\Admin\Domains\PaymentGateways\Paddle\Model;

use Teckipro\Admin\Models\User;

use Laravel\Paddle\Billable;

class PaddleUser extends User {
    use Billable;

}
