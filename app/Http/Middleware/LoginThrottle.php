<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LoginThrottle
{
    /**
     * Maximum login attempts allowed
     */
    const MAX_ATTEMPTS = 5;

    /**
     * Block duration in minutes
     */
    const BLOCK_DURATION = 15;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $blockKey = "blocked_ip_{$ip}";
        $attemptKey = "login_attempts_{$ip}";

        // Check if IP is currently blocked
        if (Cache::has($blockKey)) {
            $remainingTime = Cache::get($blockKey);
            $minutesLeft = ceil($remainingTime / 60);

            Log::warning('Blocked IP attempted access', [
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'remaining_minutes' => $minutesLeft,
                'timestamp' => now(),
            ]);

            return response()->view('errors.blocked', [
                'minutes' => $minutesLeft,
                'ip' => $ip
            ], 429);
        }

        return $next($request);
    }

    /**
     * Record a failed login attempt
     *
     * @param string $ip
     * @return void
     */
    public static function recordFailedAttempt(string $ip)
    {
        $attemptKey = "login_attempts_{$ip}";
        $blockKey = "blocked_ip_{$ip}";

        // Get current attempts count
        $attempts = Cache::get($attemptKey, 0);
        $attempts++;

        // Store attempts count for 15 minutes
        Cache::put($attemptKey, $attempts, now()->addMinutes(self::BLOCK_DURATION));

        Log::info('Failed login attempt recorded', [
            'ip' => $ip,
            'attempts' => $attempts,
            'max_attempts' => self::MAX_ATTEMPTS,
            'timestamp' => now(),
        ]);

        // If max attempts reached, block the IP
        if ($attempts >= self::MAX_ATTEMPTS) {
            $blockDuration = self::BLOCK_DURATION * 60; // Convert to seconds
            Cache::put($blockKey, $blockDuration, now()->addMinutes(self::BLOCK_DURATION));

            // Clear attempts counter since IP is now blocked
            Cache::forget($attemptKey);

            Log::warning('IP blocked due to excessive failed login attempts', [
                'ip' => $ip,
                'attempts' => $attempts,
                'block_duration_minutes' => self::BLOCK_DURATION,
                'timestamp' => now(),
            ]);
        }
    }

    /**
     * Clear failed attempts for successful login
     *
     * @param string $ip
     * @return void
     */
    public static function clearFailedAttempts(string $ip)
    {
        $attemptKey = "login_attempts_{$ip}";
        Cache::forget($attemptKey);

        Log::info('Failed login attempts cleared for IP', [
            'ip' => $ip,
            'timestamp' => now(),
        ]);
    }

    /**
     * Get remaining attempts for an IP
     *
     * @param string $ip
     * @return int
     */
    public static function getRemainingAttempts(string $ip): int
    {
        $attemptKey = "login_attempts_{$ip}";
        $attempts = Cache::get($attemptKey, 0);
        return max(0, self::MAX_ATTEMPTS - $attempts);
    }

    /**
     * Check if IP is currently blocked
     *
     * @param string $ip
     * @return bool
     */
    public static function isBlocked(string $ip): bool
    {
        $blockKey = "blocked_ip_{$ip}";
        return Cache::has($blockKey);
    }

    /**
     * Get remaining block time in minutes
     *
     * @param string $ip
     * @return int
     */
    public static function getRemainingBlockTime(string $ip): int
    {
        $blockKey = "blocked_ip_{$ip}";
        if (Cache::has($blockKey)) {
            return ceil(Cache::get($blockKey) / 60);
        }
        return 0;
    }
}
