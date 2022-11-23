<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use App\Services\GoogleLoginService;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{

    public function __construct(private GoogleLoginService $googleLoginService)
    {
        $this->googleLoginService = $googleLoginService;
    }

    /**
     * Redirects to Google callback.
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Checks if user exists in DB if not create new user instance.
     *
     * @return Redirector|RedirectResponse
     */
    public function callback(): Redirector|RedirectResponse
    {
        $user = $this->googleLoginService->getUser();
        $findUser = $this->googleLoginService->findUser($user->id);

        if ($findUser) {
            auth()->login($findUser);

            return redirect()->route('posts.index')->with('message',  __('user.logged_in'));
        } else if (!$findUser) {
            auth()->login($this->googleLoginService->createUser($user));

            return redirect()->route('verification.notice')->with('message',  __('user.created'));
        }

        back()->with('message',  __('error.primary'));
    }
}
