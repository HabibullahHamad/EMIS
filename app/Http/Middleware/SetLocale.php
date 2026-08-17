<?php

namespace App\Http\Middleware;

use App\Services\Settings\SystemSettingService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SetLocale
{
    /**
     * Languages supported by EMIS.
     */
    private const SUPPORTED_LOCALES = [
        'en',
        'ps',
        'fa',
    ];

    public function __construct(
        private readonly SystemSettingService $settings
    ) {
    }

    /**
     * Select the language for the current request.
     *
     * Priority:
     *
     * 1. Language supplied through ?lang=
     * 2. Language stored in the session
     * 3. Authenticated user's locale
     * 4. Default language saved in Settings Center
     * 5. Application configuration
     * 6. English fallback
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | Explicit language selection
        |--------------------------------------------------------------------------
        |
        | Examples:
        |
        | ?lang=en
        | ?lang=ps
        | ?lang=fa
        |
        */

        $requestedLocale = $request->query('lang');

        if (
            is_string($requestedLocale) &&
            in_array(
                $requestedLocale,
                self::SUPPORTED_LOCALES,
                true
            )
        ) {
            $request->session()->put(
                'locale',
                $requestedLocale
            );
        }

        /*
        |--------------------------------------------------------------------------
        | System default language
        |--------------------------------------------------------------------------
        |
        | Do not allow a database or cache problem to prevent the entire
        | application from loading.
        |
        */

        $systemDefaultLocale = null;

        try {
            $savedLocale = $this->settings->get(
                'localization.default_language'
            );

            if (
                is_string($savedLocale) &&
                in_array(
                    $savedLocale,
                    self::SUPPORTED_LOCALES,
                    true
                )
            ) {
                $systemDefaultLocale = $savedLocale;
            }
        } catch (Throwable $exception) {
            report($exception);
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve final locale
        |--------------------------------------------------------------------------
        */

        $locale =
            $request->session()->get('locale')
            ?: $request->user()?->locale
            ?: $systemDefaultLocale
            ?: config('app.locale', 'ps');

        if (
            !is_string($locale) ||
            !in_array(
                $locale,
                self::SUPPORTED_LOCALES,
                true
            )
        ) {
            $locale = config(
                'app.fallback_locale',
                'en'
            );
        }

        if (
            !is_string($locale) ||
            !in_array(
                $locale,
                self::SUPPORTED_LOCALES,
                true
            )
        ) {
            $locale = 'en';
        }

        App::setLocale($locale);

        /*
         * Make the current locale available to every Blade view.
         */
        view()->share(
            'currentLocale',
            $locale
        );

        return $next($request);
    }
}