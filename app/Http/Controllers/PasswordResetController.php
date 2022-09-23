<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Returns forget password form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function request()
    {
        return view('password-reset.forgot-password');
    }

    /**
     * Sends email reset link
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function email(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->route('posts.index')->with(['message' => __('passwords.sent_alert')])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Returns reset from
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\View
     */
    public function reset($token)
    {
        return view('password-reset.reset-password', ['token' => $token]);
    }

    /**
     * Resets password
     *
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // TODO:
        // [] - move to separate request class
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // TODO:
        // [] - move msg to constant file like PASSWORDS_RESET_ALERT = 'passwords.reset_alert'
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('message', __('passwords.reset_alert'))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
