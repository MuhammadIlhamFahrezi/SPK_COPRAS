<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\SanitizeInput;
use App\Http\Middleware\AppFirewall;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware - AppFirewall akan dijalankan di semua request
        $middleware->append(AppFirewall::class);

        // Middleware aliases
        $middleware->alias([
            'admin' => IsAdmin::class,
            'auth.user' => IsUser::class,
            'sanitize' => SanitizeInput::class,
            'firewall' => AppFirewall::class, // Jika ingin menggunakan secara selective
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
