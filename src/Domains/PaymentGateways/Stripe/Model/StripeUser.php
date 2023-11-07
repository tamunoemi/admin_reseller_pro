<?php
namespace Teckipro\Admin\Domains\PaymentGateways\Stripe\Model;

use Teckipro\Admin\Models\User;
use Laravel\Cashier\Billable;

class StripeUser extends User {
    use Billable;

}
