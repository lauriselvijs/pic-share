<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class GoogleLoginService
{
    /**
     * Returns Google user info
     */
    public function getUser(): SocialiteUser
    {
        $user = Socialite::driver('google')->user();

        return $user;
    }

    /**
     * Find user in DB
     */
    public function findUser(string $userId): ?User
    {
        $user = User::where('google_id', $userId)->first();

        return $user;
    }

    /**
     * Create and authenticate new user
     */
    public function createAndAuthUser(SocialiteUser $user): void
    {
        $newUser = User::updateOrCreate([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'google_id' => $user->getId(),
            'password' => Hash::make(Str::random(10))
        ]);

        auth()->login($newUser);
    }
}
