<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Redirector;
use App\Services\GoogleLoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function callback(Request $request): Redirector|RedirectResponse
    {
        try {
            $user = $this->googleLoginService->getUser();
        } catch (\Exception $_error) {
            return redirect()->route('home')->with('message', __('error.primary'));
        }

        $foundUser = $this->googleLoginService->findUser($user->id);

        $request->session()->regenerate();

        if ($foundUser) {
            auth()->login($foundUser);
            $message = __('user.logged_in');
        } else {
            $this->googleLoginService->createAndAuthUser($user);
            $message = __('user.created');
        }

        return redirect()->route('posts.index')->with('message', $message);
    }
}
