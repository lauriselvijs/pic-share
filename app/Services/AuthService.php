<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Session\Session;

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
