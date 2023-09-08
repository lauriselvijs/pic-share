<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ValidatedInput;

class AuthService
{
    /**
     * Store new user in database and log in user
     *
     * @param ValidatedInput $user
     */
    public function storeAndLogIn(ValidatedInput $user): void
    {
        // Hash password.
        $user->password = Hash::make($user->password);

        // Create user
        $user = User::create($user->toArray());

        auth()->login($user);

        session()->regenerate();
    }

    /**
     * Invalidate current session and regenerate CSRF token
     */
    public function logout(): void
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();
    }

    /**
     * Auth user
     */
    public function authenticate(array $credentials, bool $remember): bool
    {
        if (auth()->attempt($credentials, $remember)) {
            session()->regenerate();
            return true;
        }

        return false;
    }
}
