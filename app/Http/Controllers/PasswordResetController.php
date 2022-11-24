<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Services\PasswordResetService;
use App\Http\Requests\EmailPasswordResetRequest;
use App\Http\Requests\UpdatePasswordResetRequest;

class PasswordResetController extends Controller
{

    public function __construct(private PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }


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
     * @param EmailPasswordResetRequest $request
     * @return RedirectResponse
     */
    public function email(EmailPasswordResetRequest $request): RedirectResponse
    {
        $sent = $this->passwordResetService->email($request->validated());

        if ($sent) {
            return redirect()->route('posts.index')->with(['message' => __('passwords.sent_alert')]);
        }

        return back()->withErrors(['email' => __($sent['status'])]);
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
     * @param UpdatePasswordResetRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePasswordResetRequest $request)
    {
        $request->validated();

        $sent = $this->passwordResetService->update($request->only('email', 'password', 'password_confirmation', 'token'));

        if ($sent) {
            return redirect()->route('auth.login')->with('message', __('passwords.reset_alert'));
        }

        return back()->withErrors(['email' => __($sent['status'])]);
    }
}
