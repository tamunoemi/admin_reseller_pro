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
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
