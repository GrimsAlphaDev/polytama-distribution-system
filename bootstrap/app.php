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
        $middleware->alias([
            'marketing' => \App\Http\Middleware\RoleMiddleware::class . ':marketing',
            'transporter' => \App\Http\Middleware\RoleMiddleware::class . ':transporter',
            'driver' => \App\Http\Middleware\RoleMiddleware::class . ':driver',
            'logistik' => \App\Http\Middleware\RoleMiddleware::class . ':logistik',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
