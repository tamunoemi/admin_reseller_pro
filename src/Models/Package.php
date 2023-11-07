<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table='plans'; //very important
    public $timestamps = false; //very important

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
        'name',
        'description',
        'interval',
        'interval_count',
        'trial_period_days',
        'sort_order',
        'discount',
        'coupon',
        'type',
        'role_ids',
        'monthly_limit',
        'bulk_limit',
        'price',
        'visible',
        'highlight',
        'deleted',
        'jvzoo_id',
        'warriorplus_id',
        'appsumo_id',
        'clickbank_id',
        'paddle_id',
        'stripe_id',
        'user_can_resell'
    ];

}
