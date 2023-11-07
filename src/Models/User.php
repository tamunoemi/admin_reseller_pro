<?php

namespace Teckipro\Admin\Models;

use Teckipro\Admin\Models\Traits\Attribute\UserAttribute;
use Teckipro\Admin\Models\Traits\Method\UserMethod;
use Teckipro\Admin\Models\Traits\Relationship\UserRelationship;
use Teckipro\Admin\Models\Traits\Scope\UserScope;
use Teckipro\Admin\Notifications\Frontend\ResetPasswordNotification;
use Teckipro\Admin\Notifications\Frontend\VerifyEmail;

use Teckipro\Admin\Database\Factories\UserFactory;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


use Laragear\TwoFactor\TwoFactorAuthentication;
use Laragear\TwoFactor\Contracts\TwoFactorAuthenticatable;


use Laravel\Cashier\Billable as StripeBillable;
use Laravel\Paddle\Billable as PaddleBillable;

//Laraplan packages
use Tamunoemi\Laraplans\Contracts\PlanSubscriberInterface;
use Tamunoemi\Laraplans\Traits\PlanSubscriber;

/**
 * Class User.
 */
class User extends Authenticatable implements MustVerifyEmail,TwoFactorAuthenticatable
{
    use HasApiTokens,
        HasFactory,
        HasRoles,
        Impersonate,
        MustVerifyEmailTrait,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        TwoFactorAuthentication;




    use StripeBillable,PaddleBillable, PlanSubscriber {

        StripeBillable::newSubscription as newStripeSubscription;
        StripeBillable::subscriptions as stripeSubscriptions;
        StripeBillable::subscription as stripeSubscription;
        StripeBillable::onTrial as stripeOnTrial;
        StripeBillable::hasExpiredTrial as hasExpiredTrialStripe;
        StripeBillable::onGenericTrial as onGenericTrialStripe;
        StripeBillable::hasExpiredGenericTrial as hasExpiredGenericTrialStripe;
        StripeBillable::trialEndsAt as trialEndsAtStripe;
        StripeBillable::subscribed as subscribedStripe;
        StripeBillable::charge as stripeCharge;
        StripeBillable::refund as stripeRefund;

        PlanSubscriber::newSubscription insteadof PaddleBillable,StripeBillable;
        PlanSubscriber::subscriptions insteadof StripeBillable,PaddleBillable;
        PlanSubscriber::subscription insteadof StripeBillable,PaddleBillable;
        PlanSubscriber::subscribed insteadof StripeBillable,PaddleBillable;

        PaddleBillable::newSubscription as  newPaddleSubscription;
        PaddleBillable::subscriptions as paddleSubscriptions;
        PaddleBillable::subscription as  paddleSubscription;
        PaddleBillable::subscribed as subscribedPaddle;

        PaddleBillable::onTrial insteadof StripeBillable;
        PaddleBillable::hasExpiredTrial insteadof StripeBillable;
        PaddleBillable::onGenericTrial insteadof StripeBillable;
        PaddleBillable::hasExpiredGenericTrial insteadof StripeBillable;
        PaddleBillable::trialEndsAt insteadof StripeBillable;
        PaddleBillable::charge insteadof StripeBillable;
        PaddleBillable::refund insteadof StripeBillable;


    }


    public const TYPE_ADMIN = 'admin';
    public const TYPE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'email_verified_at',
        'password',
        'password_changed_at',
        'active',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'provider',
        'provider_id',
        'phone',
        'address',
        'gender',
        'user_permissions',
        'brand_logo',
        'brand_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'last_login_at',
        'email_verified_at',
        'password_changed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'to_be_logged_out' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'avatar',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'permissions',
        'roles',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the registration verification email.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }


    /**
     * Return true or false if the user can impersonate an other user.
     *
     * @param void
     * @return bool
     */
    public function canImpersonate(): bool
    {
        return $this->can('admin.access.user.impersonate');
    }

    /**
     * Return true or false if the user can be impersonate.
     *
     * @param void
     * @return bool
     */
    public function canBeImpersonated(): bool
    {
        return ! $this->isMasterAdmin();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
