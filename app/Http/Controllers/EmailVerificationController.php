<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Notifies user about email verification
     *
     * @return RedirectResponse|View
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail() ? redirect()->route('posts.index') : view('email-verification.verify');
    }

    /**
     * Verify user email
     *
     * @return RedirectResponse
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('posts.index')->with('message', __('email.verified'));
    }

    /**
     * Resend email verification
     *
     * @return RedirectResponse
     */
    public function send(Request $request)
    {
        $user = $request->user();
        // TODO:
        // [ ] - move business logic to service class
        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return back()->with('message', __('email.sent'));
        }

        return redirect()->route('posts.index')->with('message', __('email.already_verified'));
    }
}
