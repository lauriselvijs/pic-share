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
     *
     * @return SocialiteUser
     */
    public function getUser(): SocialiteUser
    {
        $user = Socialite::driver('google')->user();

        return $user;
    }


    /**
     * Find user in DB
     *
     * @param string $userId
     * @return User|null
     */
    public function findUser(string $userId): User|null
    {
        $findUser = User::where('google_id', $userId)->first();

        return $findUser;
    }

    /**
     * Create new user
     *
     * @param SocialiteUser $user
     * @return User
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
