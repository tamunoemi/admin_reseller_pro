<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Paddle\Subscription;

class PaddleModel extends Subscription
{
    use HasFactory;
    protected $table='paddle_subscriptions'; //very important
   // public $timestamps = false; //very important
   

}

