<?php

use App\Http\Middleware\BlockSpamBots;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'honeypot' => BlockSpamBots::class,
        ]);

        // Hosting platforms terminate HTTPS at their proxy; trust its
        // X-Forwarded-* headers so the app knows requests were secure.
        $middleware->trustProxies(at: '*');

        $middleware->append(SecurityHeaders::class);
        $middleware->web(append: [SetLocale::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Sends errors to Sentry when SENTRY_LARAVEL_DSN is set; otherwise a no-op.
        Integration::handles($exceptions);

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
