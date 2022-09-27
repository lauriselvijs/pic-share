<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Session\Session;

class AuthService
{
    /**
     * Hash password for givin password field
     *
     * @param array<mix> $userData
     * @return User
     */
    public function store(array $userData): User
    {
        // TODO: 
        // [] - add agreement checked to user table as column
        // Hash password
        $userData['password'] = bcrypt($userData['password']);

        // Create user
        $user = User::create($userData);

        return $user;
    }

    public function login(User $user): void
    {
        auth()->login($user);
    }

    /**
     * Logout current user
     *
     * @param Session $session
     * @return void
     */
    public function logout(Session $session): void
    {
        auth()->logout();

        $session->invalidate();
        $session->regenerateToken();
    }

    /**
     * Auth user
     *
     * @param Session $session
     * @param array $userData
     * @param string $remember
     * @return bool
     */
    public function auth(Session $session, array $userData, string|null $remember): bool
    {
        if (auth()->attempt($userData, $remember)) {
            $session->regenerate();
            return true;
        }

        return false;
    }
}
