<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    public final const LOCAL_SESSION_KEY = 'local';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the session has a "local" key
        if ($request->session()->has(self::LOCAL_SESSION_KEY)) {
            // Set the app locale
            app()->setLocale($request->session()->get(self::LOCAL_SESSION_KEY));
        } else {
            // Set the "local" key with the value of HTTP_ACCEPT_LANGUAGE
            $acceptLanguage = $request->server('HTTP_ACCEPT_LANGUAGE');
            $locales = explode(',', $acceptLanguage);
            $locale = $locales[0];

            // Set the app locale
            app()->setLocale($locale);
        }


        return $next($request);
    }
}
