<?php

namespace App\Observers;

use App\Events\UserRegisteredEvent;
use App\Models\Post;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Auth\Events\Registered;

class UserObserver
{
    public function __construct(private Post $post) {}

    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        $user->username = Helper::generateUsernameFrom($user->email);
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created(User $user)
    {
        // Send verification email to user
        event(new Registered($user));

        // Log user
        event(new UserRegisteredEvent($user));
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated(User $user) {}

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted(User $user) {}

    /**
     * Handle the User "restored" event.
     *
     * @return void
     */
    public function restored(User $user) {}

    /**
     * Handle the User "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(User $user) {}
}
