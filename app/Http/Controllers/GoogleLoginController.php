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
    }

    /**
     * Redirects to Google callback.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }

    /**
     * Checks if user exists in DB if not create new user instance.
     */
    public function callback(): Redirector|RedirectResponse
    {
        try {
            $user = $this->googleLoginService->getUser();
        } catch (\Exception $_error) {
            return redirect()->route('home')->with('message', __('error.primary'));
        }

        $message = $this->googleLoginService->auth($user);

        return redirect()->route('posts.index')->with('message', $message);
    }
}
