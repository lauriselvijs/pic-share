<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class EmailVerificationController extends Controller
{

    /**
     * Notifies user about email verification
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail() ? redirect()->route('posts.index') : view('email-verification.verify');
    }

    /**
     * Verify user email
     *
     * @param EmailVerificationRequest $request
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
     * @param Request $request
     * @return  RedirectResponse
     */
    public function send(Request $request)
    {
        // TODO: 
        // [ ] - move BL to service class
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();

            return back()->with('message', __('email.sent'));
        }

        return  redirect()->route('posts.index')->with('message', __('email.already_verified'));
    }
}
