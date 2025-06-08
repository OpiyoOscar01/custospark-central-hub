<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(path: __DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 👇 Register global web group middleware
        $middleware->appendToGroup('web', \App\Http\Middleware\CaptureReferralMiddleware::class);

        // 👇 Optional: Alias for route-specific use if needed
        $middleware->alias([
            'sso.auth' => \App\Http\Middleware\SsoTokenAuth::class,
            'sso.token.logout' => \App\Http\Middleware\SSOTokenLogout::class,
            'check.app.roles' => \App\Http\Middleware\CheckAppRoles::class,
            'feature.access' => \App\Http\Middleware\CheckFeatureAccess::class,
            'capture.referral' => \App\Http\Middleware\CaptureReferralMiddleware::class, // optional
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

