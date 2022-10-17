<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class EmailVerificationController extends Controller
{
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail() ? redirect()->route('posts.index') : view('email-verification.verify');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('posts.index')->with('message', __('email.verified'));
    }

    // TODO:
    // [ ] - implement email send email verification option in user profile
    public function send(Request $request)
    {
        // TODO: 
        // [ ] - move BS to service class
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();

            return back()->with('message', __('email.sent'));
        }

        return  redirect()->route('posts.index')->with('message', __('email.already_verified'));
    }
}
