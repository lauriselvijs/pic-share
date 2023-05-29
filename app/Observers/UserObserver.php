<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Admin;
use App\Services\Helper;
use App\Events\UserRegisteredEvent;
use App\Models\Post;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegisteredNotification;

class UserObserver
{
    public function __construct(private Post $post)
    {
        $this->post = $post;
    }

    /**
     * Handle the User "creating" event.
     *
     * @param  User  $user
     * @return void
     */
    public function creating(User $user): void
    {
        $user->username = Helper::generateUsernameFrom($user->email);
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

        // Send notification to notifiable admins
        $admins = Admin::where('notify', true)->get();
        Notification::send($admins, new UserRegisteredNotification($user));

        // Log user
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
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        cache()->tags($user->id)->flush();
        cache()->tags($this->post::CACHE_PAGINATION_TAG)->flush();
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        cache()->tags($user->id)->flush();
        cache()->tags($this->post::CACHE_PAGINATION_TAG)->flush();
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        cache()->tags($user->id)->flush();
        cache()->tags($this->post::CACHE_PAGINATION_TAG)->flush();
    }
}
