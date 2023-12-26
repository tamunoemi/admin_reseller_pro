<?php

namespace Teckipro\Admin\Listeners;

use Teckipro\Admin\Events\User\UserCreated;
use Teckipro\Admin\Events\User\UserDeleted;
use Teckipro\Admin\Events\User\UserDestroyed;
use Teckipro\Admin\Events\User\UserLoggedIn;
use Teckipro\Admin\Events\User\UserRestored;
use Teckipro\Admin\Events\User\UserStatusChanged;
use Teckipro\Admin\Events\User\UserUpdated;
use Illuminate\Auth\Events\PasswordReset;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public function onLoggedIn($event)
    {
        // Update the logging in users time & IP
        $event->user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->getClientIp(),
        ]);
    }

    /**
     * @param $event
     */
    public function onPasswordReset($event)
    {
        $event->user->update([
            'password_changed_at' => now(),
        ]);
    }

    /**
     * @param $event
     */
    public function onCreated($event)
    {
     
        activity('user')
            ->performedOn($event->user)
            ->withProperties([
                'user' => [
                    'type' => $event->user->type,
                    'name' => $event->user->name,
                    'email' => $event->user->email,
                    'active' => $event->user->active,
                    'email_verified_at' => $event->user->email_verified_at,
                ],
                'roles' => $event->user->roles->count() ? $event->user->roles->pluck('name')->implode(', ') : 'None',
                'permissions' => $event->user->permissions ? $event->user->permissions->pluck('description')->implode(', ') : 'None',
            ])
            ->log(':causer.name created user :subject.name with roles: :properties.roles and permissions: :properties.permissions');
    }

    
    /**
     * Update the uuid field
     */
    public function updateUuid($event){

        $event->user->update([
            'uuid' => \Str::uuid()
        ]);
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('user')
            ->performedOn($event->user)
            ->withProperties([
                'user' => [
                    'type' => $event->user->type,
                    'name' => $event->user->name,
                    'email' => $event->user->email,
                ],
                'roles' => $event->user->roles->count() ? $event->user->roles->pluck('name')->implode(', ') : 'None',
                'permissions' => $event->user->permissions ? $event->user->permissions->pluck('description')->implode(', ') : 'None',
            ])
            ->log(':causer.name updated user :subject.name with roles: :properties.roles and permissions: :properties.permissions');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('user')
            ->performedOn($event->user)
            ->log(':causer.name deleted user :subject.name');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        activity('user')
            ->performedOn($event->user)
            ->log(':causer.name restored user :subject.name');
    }

    /**
     * @param $event
     */
    public function onDestroyed($event)
    {
        activity('user')
            ->performedOn($event->user)
            ->log(':causer.name permanently deleted user :subject.name');
    }

    /**
     * @param $event
     */
    public function onStatusChanged($event)
    {
        activity('user')
            ->performedOn($event->user)
            ->log(':causer.name '.($event->status === 0 ? 'deactivated' : 'reactivated').' user :subject.name');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            UserLoggedIn::class,
            'Teckipro\Admin\Listeners\UserEventListener@onLoggedIn'
        );

        $events->listen(
            PasswordReset::class,
            'Teckipro\Admin\Listeners\UserEventListener@onPasswordReset'
        );

        $events->listen(
            UserCreated::class,
            'Teckipro\Admin\Listeners\UserEventListener@onCreated',
            'Teckipro\Admin\Listeners\UserEventListener@updateUuid'
        );


        $events->listen(
            UserUpdated::class,
            'Teckipro\Admin\Listeners\UserEventListener@onUpdated'
        );

        $events->listen(
            UserDeleted::class,
            'Teckipro\Admin\Listeners\UserEventListener@onDeleted'
        );

        $events->listen(
            UserRestored::class,
            'Teckipro\Admin\Listeners\UserEventListener@onRestored'
        );

        $events->listen(
            UserDestroyed::class,
            'Teckipro\Admin\Listeners\UserEventListener@onDestroyed'
        );

        $events->listen(
            UserStatusChanged::class,
            'Teckipro\Admin\Listeners\UserEventListener@onStatusChanged'
        );
    }
}
