<?php

namespace Teckipro\Admin\Domains\PaymentGateways\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentgateways extends Model
{
    use HasFactory;
    protected $table='payment_gateway'; //very important
    public $timestamps = true; //very important

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'is_active',
        'user_id'
    ];
}
