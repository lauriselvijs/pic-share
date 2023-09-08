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

    private function login(User $user): void
    {
        auth()->login($user);
        session()->regenerate();
    }

    /**
     * Create and auth or auth user
     */
    public function auth(SocialiteUser $googleUser): string|array|null
    {
        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            $this->login($user);

            return __('user.logged_in');
        }

        $this->createAndLoginUser($googleUser);

        return __('user.created');
    }

    /**
     * Create and authenticate new user
     */
    public function createAndLoginUser(SocialiteUser $user): void
    {
        $newUser = User::updateOrCreate([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'google_id' => $user->getId(),
            'password' => Hash::make(Str::random(10))
        ]);

        $this->login($newUser);
    }
}
