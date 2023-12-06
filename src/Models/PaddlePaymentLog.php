<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaddlePaymentLog extends Model
{
    use HasFactory;
    protected $table='paddle_payment_logs'; //very important
    public $timestamps = true; 

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id',
      'checkout_id',
      'order_id',
      'product_id_or_subscription_plan_id',
      'product_or_plan_name',
      'subscription_id',
      'status',
      'alert_name',
      'earnings',
      'country',
      'receipt_url',
      'payload',
    ];
}
