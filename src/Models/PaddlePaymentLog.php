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
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
