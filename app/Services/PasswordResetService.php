<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetService
{
    /**
     * Sends reset password link to given email.
     *
     * @param array<string, string> $email
     * @return array<string, string>|bool
     */
    public function email(array $credentials): array|bool
    {
        $status = Password::sendResetLink($credentials);

        if ($status === Password::RESET_LINK_SENT) {
            return true;
        }

        return ['status' => $status];
    }

    /**
     * Updates user password.
     *
     * @param array<string, mixed> $credentials
     */
    public function update(array $credentials): array|bool
    {
        $status = Password::reset(
            $credentials,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return true;
        }

        return ['status' => $status];
    }
}
