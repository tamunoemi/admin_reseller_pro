<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Paddle\Receipt;

class ReceiptModel extends Receipt
{
    use HasFactory;
    protected $table='receipts'; //very important
    public $timestamps = false; //very important
    protected $fillable = [
        'billable_id',
        'billable_type',
        'paddle_subscription_id',
        'checkout_id',
        'order_id',
        'amount',
        'tax',
        'currency',
        'quantity',
        'receipt_url',
        'paid_at'
    ];
}
