<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicybbb
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
         * MENGAPA RESOURCE BERIKUT TIDAK DIIZINKAN DALAM CSP KETAT:
         * 
         * 1. <script src="https://cdn.tailwindcss.com"></script>
         *    - CDN external dapat berubah tanpa kontrol kita
         *    - Risiko supply chain attack jika CDN dikompromikan
         *    - Solusi: Download dan host lokal, atau gunakan build process
         * 
         * 2. <link href="https://fonts.googleapis.com/css2?family=Quantico&display=swap" rel="stylesheet">
         *    - External font loading dapat dilacak oleh Google
         *    - Ketergantungan pada layanan eksternal
         *    - Solusi: Self-host fonts atau gunakan system fonts
         * 
         * 3. <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
         *    - Same issue dengan CDN external
         *    - Dapat berubah atau tidak tersedia kapan saja
         *    - Solusi: Download dan host lokal
         * 
         * 4. <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
         *    - CDN external dengan risiko keamanan tinggi untuk JavaScript
         *    - Jika CDN dikompromikan, seluruh aplikasi terpengaruh
         *    - Solusi: Bundle dengan build tools atau host lokal
         * 
         * 5. <style> inline styles
         *    - Dapat dimanipulasi melalui XSS
         *    - Sulit dikontrol dan diaudit
         *    - Solusi: Gunakan external CSS files atau nonce/hash
         */

        // CSP Header yang sangat ketat untuk maksimal security
        $cspDirectives = [
            // Script sources - hanya izinkan dari domain sendiri
            "script-src 'self'",

            // Style sources - hanya izinkan dari domain sendiri
            "style-src 'self'",

            // Image sources - izinkan dari domain sendiri dan data URLs untuk base64 images
            "img-src 'self' data:",

            // Font sources - hanya dari domain sendiri
            "font-src 'self'",

            // Connect sources - untuk AJAX requests, hanya ke domain sendiri
            "connect-src 'self'",

            // Media sources - untuk audio/video
            "media-src 'self'",

            // Object sources - untuk plugins seperti Flash (disabled untuk security)
            "object-src 'none'",

            // Base URI - mencegah injection base tag
            "base-uri 'self'",

            // Form action - hanya izinkan submit ke domain sendiri
            "form-action 'self'",

            // Frame ancestors - mencegah clickjacking
            "frame-ancestors 'none'",

            // Default fallback - jika directive tidak didefinisikan
            "default-src 'self'",

            // Upgrade insecure requests - paksa HTTPS
            "upgrade-insecure-requests"
        ];

        // Alternative CSP untuk development (sedikit lebih longgar)
        if (app()->environment('local')) {
            $cspDirectives = [
                // Untuk development, izinkan beberapa inline styles dengan unsafe-inline
                // CATATAN: Ini tidak aman untuk production!
                "script-src 'self' 'unsafe-inline'",
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

        // CSP dengan nonce untuk inline scripts yang aman (recommended approach)
        // Uncomment dan gunakan ini jika Anda perlu inline scripts:
        /*
        $nonce = base64_encode(random_bytes(16));
        session(['csp_nonce' => $nonce]);
        
        $cspDirectives = [
            "script-src 'self' 'nonce-{$nonce}'",
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
