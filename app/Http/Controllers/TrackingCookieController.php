<?php

namespace App\Http\Controllers;

use App\Services\TrackingCookieService;
use Illuminate\Http\Request;

class TrackingCookieController extends Controller
{
    public function __construct(private TrackingCookieService $trackingCookieService)
    {
    }

    public function allow(Request $request)
    {
        $cookie = $this->trackingCookieService->allowTracking();

        return redirect()->back()->withCookie($cookie); // Redirect to the desired page after adding the cookie
    }
}
