<?php

namespace Teckipro\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaunchSubscriptionModel extends Model
{
    use HasFactory;
    protected $table='base_subscriptions'; //very important
    public $timestamps = true; //very important

    public const TYPE_JVZOO = 'jvzoo';
    public const TYPE_CLICKBANK = 'clickbank';
    public const TYPE_CUSTOM = 'custom';
    public const TYPE_WARRIORPLUS = 'warriorplus';
    public const TYPE_APPSUMO = 'appsumo';
    /**
     * Launch package types
     */
    public const type = array(
        'Jvzoo'=>self::TYPE_JVZOO,
        'appsumo'=>self::TYPE_APPSUMO,
        'Clickbank'=>self::TYPE_CLICKBANK,
        'Custom'=>self::TYPE_CUSTOM,
        'Warriorplus'=>self::TYPE_WARRIORPLUS
    );

    /**
     * Default launch package
     */
    public const defaultLaunchPackage = 'custom';


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
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
