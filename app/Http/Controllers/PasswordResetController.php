<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Services\PasswordResetService;
use App\Http\Requests\EmailPasswordResetRequest;
use App\Http\Requests\UpdatePasswordResetRequest;
use Illuminate\Contracts\View\View;

class PasswordResetController extends Controller
{
    public function __construct(private PasswordResetService $passwordResetService)
    {
    }

    /**
     * Returns forget password form
     */
    public function request(): View
    {
        return view('password-reset.forgot-password');
    }

    /**
     * Sends email reset link
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
     */
    public function reset(string $token): View
    {
        return view('password-reset.reset-password', ['token' => $token]);
    }

    /**
     * Resets password
     */
    public function update(UpdatePasswordResetRequest $request): RedirectResponse
    {
        $request->validated();

        $sent = $this->passwordResetService->update($request->only('email', 'password', 'password_confirmation', 'token'));

        if ($sent) {
            return redirect()->route('auth.login')->with('message', __('passwords.reset_alert'));
        }

        return back()->withErrors(['email' => __($sent['status'])]);
    }
}
