<?php

namespace App\Services;

use App\Http\Middleware\SetAppLocale;

class UserService
{
    public function setLocal($locale): void
    {
        session(SetAppLocale::LOCAL_SESSION_KEY, $locale);
    }
}
