<?php

namespace App\Services;

use App\Events\UserRegisteredEvent;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegisteredNotification;

class AuthService
{
    /**
     * Store new user in database
     *
     * @param array<string, mixed> $userData
     * @return User
     */
    public function store(array $userData): User
    {
        // TODO: 
        // [ ] - Add agreement checked to user table as column.
        // Hash password.
        $userData['password'] = bcrypt($userData['password']);

        // Create user
        $user = User::create($userData);

        // Notify users when user created
        // TODO:
        // [ ] - Move to separate function (SRP)
        $admins = Admin::all();
        Notification::send($admins, new UserRegisteredNotification($user));

        // Events
        // Facade
        // UserRegisteredEvent::dispatch($user);
        // Helper function
        event(new UserRegisteredEvent($user));
        event(new Registered($user));

        return $user;
    }

    /**
     * Invalidate current session and regenerate CSRF token
     *
     * @param Session $session
     * @return void
     */
    public function invalidate(Session $session): void
    {
        $session->invalidate();
        $session->regenerateToken();
    }

    /**
     * Auth user
     *
     * @param Session $session
     * @param array<string, string> $userData
     * @param mixed $remember
     * @return bool
     */
    public function authenticate(Session $session, array $credentials, bool $remember): bool
    {
        if (auth()->attempt($credentials, $remember)) {
            $session->regenerate();
            return true;
        }

        return false;
    }
}
