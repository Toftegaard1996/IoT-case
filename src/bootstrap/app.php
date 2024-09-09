<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'http://192.168.1.125:8000//motion-sensors',
//            'http://192.168.1.125:8000/sensor-data',
            'http://192.168.1.125:8000/office/store',
//            'http://192.168.1.125:8000/device-settings',
//            'http://192.168.1.125:8000/device-settings/{id}',
//            'http://192.168.1.125:8001/sensor-data',
            'http://192.168.1.125:8000/sensor-data',
            'office/store',
        ]);
    })->create();
