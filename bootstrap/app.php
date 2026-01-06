<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'loginrequired' => \App\Http\Middleware\LoginRequired::class,
            'api.auth' => \App\Http\Middleware\ApiAuthMiddleware::class,
            // alias lainnya...
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
