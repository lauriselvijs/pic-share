<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Admin;
use App\Services\Helper;
use Illuminate\Support\Str;
use App\Events\UserRegisteredEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegisteredNotification;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  User  $user
     * @return void
     */
    public function creating(User $user): void
    {
        $user->username = Helper::generateUsernameFor($user->name);
    }


    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // Send verification email to user
        event(new Registered($user));

        $admins = Admin::all();
        Notification::send($admins, new UserRegisteredNotification($user));

        event(new UserRegisteredEvent($user));
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
