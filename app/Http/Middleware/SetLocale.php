<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED_LOCALES = [
        'en',
        'ps',
        'fa',
    ];

    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /*
         * Priority:
         * 1. Current session
         * 2. User's saved preference
         * 3. Application default
         */
        $locale = $request->session()->get('locale')
            ?: $request->user()?->locale
            ?: config('app.locale', 'ps');

        if (!in_array(
            $locale,
            self::SUPPORTED_LOCALES,
            true
        )) {
            $locale = config(
                'app.fallback_locale',
                'en'
            );
        }

        App::setLocale($locale);

        return $next($request);
    }
}