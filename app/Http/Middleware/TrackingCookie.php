<?php

namespace App\Http\Middleware;

use App\Services\TrackingCookieService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackingCookie
{
    public function __construct(private TrackingCookieService $trackingCookieService)
    {
        $this->trackingCookieService = $trackingCookieService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has($this->trackingCookieService::ALLOW_TRACKING_SESSION_KEY)) {

            if ($request->hasCookie($this->trackingCookieService::ALLOW_TRACKING_COOKIE_KEY)) {
                $count = $request->cookie($this->trackingCookieService::ALLOW_TRACKING_COOKIE_KEY);
                // Increment the request count
                $count++;
            } else {
                $count = 0;
            }

            // Set the updated count as a cookie
            $response = $next($request);

            return $response->withCookie(cookie($this->trackingCookieService::ALLOW_TRACKING_COOKIE_KEY, $count));
        }

        return $next($request);
    }
}
