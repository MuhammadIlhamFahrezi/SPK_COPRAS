<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        /*
         * MENGAPA HANYA TAILWIND CDN YANG DIIZINKAN:
         * 
         * 1. Tailwind CSS CDN (https://cdn.tailwindcss.com) - DIIZINKAN
         *    - Hanya untuk development/prototyping cepat
         *    - CDN yang relatif terpercaya dari Tailwind Labs
         *    - Untuk production, tetap disarankan self-host
         * 
         * RESOURCE YANG TETAP TIDAK DIIZINKAN:
         * 
         * 2. Google Fonts - TIDAK DIIZINKAN
         *    - Tracking oleh Google
         *    - Solusi: Self-host fonts
         * 
         * 3. Font Awesome CDN - TIDAK DIIZINKAN
         *    - External dependency risk
         *    - Solusi: Download dan host lokal
         * 
         * 4. jQuery CDN - TIDAK DIIZINKAN
         *    - High security risk untuk JavaScript CDN
         *    - Solusi: Bundle dengan build tools
         * 
         * 5. Inline styles - TIDAK DIIZINKAN (kecuali development)
         *    - XSS risk
         *    - Solusi: External CSS atau nonce
         */

        // CSP Header yang mengizinkan hanya Tailwind CDN
        $cspDirectives = [
            // Script sources - hanya domain sendiri dan Tailwind CDN
            "script-src 'self' https://cdn.tailwindcss.com",

            // Style sources - hanya dari domain sendiri
            // Tailwind CDN menggunakan JavaScript untuk inject styles, bukan CSS link
            "style-src 'self'",

            // Image sources - izinkan dari domain sendiri dan data URLs
            "img-src 'self' data:",

            // Font sources - hanya dari domain sendiri
            "font-src 'self'",

            // Connect sources - untuk AJAX requests, hanya ke domain sendiri
            "connect-src 'self'",

            // Media sources - untuk audio/video
            "media-src 'self'",

            // Object sources - disabled untuk security
            "object-src 'none'",

            // Base URI - mencegah injection base tag
            "base-uri 'self'",

            // Form action - hanya izinkan submit ke domain sendiri
            "form-action 'self'",

            // Frame ancestors - mencegah clickjacking
            "frame-ancestors 'none'",

            // Default fallback
            "default-src 'self'",

            // Upgrade insecure requests - paksa HTTPS
            "upgrade-insecure-requests"
        ];

        // Alternative CSP untuk development (sedikit lebih longgar)
        if (app()->environment('local')) {
            $cspDirectives = [
                // Development: izinkan Tailwind CDN + beberapa inline untuk debugging
                "script-src 'self' https://cdn.tailwindcss.com 'unsafe-inline'",
                "style-src 'self' 'unsafe-inline'",
                "img-src 'self' data:",
                "font-src 'self'",
                "connect-src 'self'",
                "media-src 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'none'",
                "default-src 'self'"
            ];
        }

        // CSP dengan nonce untuk inline scripts yang aman (recommended untuk production)
        // Uncomment jika Anda perlu inline scripts selain Tailwind:
        /*
        $nonce = base64_encode(random_bytes(16));
        session(['csp_nonce' => $nonce]);
        
        $cspDirectives = [
            "script-src 'self' https://cdn.tailwindcss.com 'nonce-{$nonce}'",
            "style-src 'self' 'nonce-{$nonce}'",
            "img-src 'self' data:",
            "font-src 'self'",
            "connect-src 'self'",
            "media-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
            "default-src 'self'"
        ];
        */

        $csp = implode('; ', $cspDirectives);

        // Set CSP header
        $response->headers->set('Content-Security-Policy', $csp);

        // Additional security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }

    /**
     * Generate nonce untuk inline scripts/styles yang aman
     * Gunakan helper ini di blade templates: {{ csp_nonce() }}
     */
    public static function generateNonce(): string
    {
        return session('csp_nonce', '');
    }
}
