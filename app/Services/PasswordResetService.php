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
     * @param array $email
     * @return array<string, string>
     */
    public function email(array $email): array|bool
    {
        $status = Password::sendResetLink($email);

        if ($status === Password::RESET_LINK_SENT) {
            return true;
        }

        return ['status' => $status];
    }

    /**
     * Updates user password.
     *
     * @param array<string, mixed> $credentials
     * @return array|boolean
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
