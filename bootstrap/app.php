<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\SanitizeInput;
use App\Http\Middleware\AppFirewall;
use App\Http\Middleware\ContentSecurityPolicy; // Import CSP middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware - AppFirewall akan dijalankan di semua request
        $middleware->append(AppFirewall::class);

        // Tambahkan CSP middleware secara global untuk semua web routes
        // atau bisa dipindahkan ke selective jika diperlukan
        $middleware->append(ContentSecurityPolicy::class);

        // Middleware aliases
        $middleware->alias([
            'admin' => IsAdmin::class,
            'auth.user' => IsUser::class,
            'sanitize' => SanitizeInput::class,
            'firewall' => AppFirewall::class,
            'csp' => ContentSecurityPolicy::class, // Alias untuk selective use
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
