<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\SanitizeInput;
use App\Http\Middleware\AppFirewall;
use App\Http\Middleware\ContentSecurityPolicy;
use App\Http\Middleware\LoginThrottle;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middleware - dijalankan di semua request
        // URUTAN PENTING: LoginThrottle harus dijalankan pertama untuk memblokir IP
        $middleware->append(LoginThrottle::class);  // Blokir IP yang bermasalah
        $middleware->append(AppFirewall::class);    // Firewall aplikasi
        $middleware->append(ContentSecurityPolicy::class); // CSP

        // Middleware aliases untuk selective use
        $middleware->alias([
            'admin' => IsAdmin::class,
            'auth.user' => IsUser::class,
            'sanitize' => SanitizeInput::class,
            'firewall' => AppFirewall::class,
            'csp' => ContentSecurityPolicy::class,
            'login.throttle' => LoginThrottle::class, // Alias jika diperlukan selective use
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
