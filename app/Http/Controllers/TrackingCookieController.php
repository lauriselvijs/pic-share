<?php

namespace App\Http\Controllers;

use App\Services\TrackingCookieService;

class TrackingCookieController extends Controller
{
    public function __construct(private TrackingCookieService $trackingCookieService)
    {
    }

    public function allow()
    {
        $cookie = $this->trackingCookieService->allowTracking();

        return redirect()->back()->withCookie($cookie); // Redirect to the desired page after adding the cookie
    }
}
