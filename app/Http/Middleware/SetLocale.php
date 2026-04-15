<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', config('app.locale', 'ps'));

        if (! in_array($locale, ['en', 'ps', 'fa'])) {
            $locale = 'ps';
        }

        App::setLocale($locale);

        return $next($request);
    }
}