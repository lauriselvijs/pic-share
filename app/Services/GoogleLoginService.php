<?php

namespace App\Services;

use App\Models\User;
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
        $findUser = User::where('google_id', $userId)->first();

        return $findUser;
    }

    /**
     * Create new user
     */
    public function createUser(SocialiteUser $user): User
    {
        $newUser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
            'password' => bcrypt(Str::random(10))
        ]);

        return $newUser;
    }
}
