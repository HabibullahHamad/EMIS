<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {

        /*
        |--------------------------------------------------------------------------
        | 🌐 GLOBAL WEB MIDDLEWARE (VERY IMPORTANT)
        |--------------------------------------------------------------------------
        */

        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class, // 🌍 Language (EN / PS / FA)
        ]);

        /*
        |--------------------------------------------------------------------------
        | 🔐 CUSTOM MIDDLEWARE ALIASES
        |--------------------------------------------------------------------------
        */

        $middleware->alias([

            // Permission system (used like: ->middleware('permission:users.view'))
            'permission' => \App\Http\Middleware\CheckPermission::class,

            // Optional: if you want role-based middleware later
            // 'role' => \App\Http\Middleware\CheckRole::class,

        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();