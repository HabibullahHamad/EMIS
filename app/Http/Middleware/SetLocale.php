<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', config('app.locale', 'en'));

        if (! in_array($locale, ['en', 'ps', 'fa'])) {
            $locale = 'en';
        }

        config(['app.locale' => $locale]);

        return $next($request);
    }
}