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
            ? redirect("/")->with(['message' =>  array('msgTitle' => 'Success!', 'msgInfo' => 'Rest link has been sent!')])
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

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', array('msgTitle' => 'Success!', 'msgInfo' => 'Password has been reset!'))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
