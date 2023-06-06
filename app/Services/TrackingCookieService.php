<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Cookie;

class TrackingCookieService
{
    public final const ALLOW_TRACKING_SESSION_KEY  = 'allow_tracking';
    public final const ALLOW_TRACKING_COOKIE_KEY = 'tracking_cookie';

    public function allowTracking(): Cookie
    {
        session([self::ALLOW_TRACKING_SESSION_KEY => true]);
        $cookie = cookie(self::ALLOW_TRACKING_COOKIE_KEY, 0);

        return $cookie;
    }
}
