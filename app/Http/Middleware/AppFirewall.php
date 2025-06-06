<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AppFirewall
{
    /**
     * Daftar IP yang diblokir (blacklist)
     */
    protected array $blacklistedIps = [
        '192.168.100.9',
    ];

    /**
     * Daftar IP yang diizinkan (whitelist)
     * Jika tidak kosong, hanya IP dalam list ini yang diizinkan
     */
    protected array $whitelistedIps = [
        // Contoh: Hanya izinkan IP tertentu
        // '192.168.1.1',
        // '127.0.0.1',
    ];

    /**
     * Daftar User-Agent yang diblokir
     */
    protected array $blockedUserAgents = [
        'sqlmap',
        'nikto',
        'nessus',
        'openvas',
        'w3af',
        'skipfish',
        'golismero',
        'grabber',
        'paros',
        'websecurify',
        'netsparker',
        'acunetix',
        'burpsuite',
        'havij',
        'pangolin',
        'beef',
        'hydra',
        'medusa',
        'brutus',
        'thc-hydra',
    ];

    /**
     * Daftar kata kunci berbahaya dalam URL atau parameter
     */
    protected array $suspiciousPatterns = [
        // SQL Injection patterns
        'union\s+select',
        'select\s+.*\s+from',
        'insert\s+into',
        'delete\s+from',
        'drop\s+table',
        'script\s*>',
        'javascript:',
        'vbscript:',
        'onload\s*=',
        'onerror\s*=',
        'onclick\s*=',
        // XSS patterns
        '<script',
        '</script>',
        'alert\(',
        'confirm\(',
        'prompt\(',
        // Path traversal - Fixed patterns
        '\.\./\.\.',
        '\.\.\\\\\.\.\\\\',
        // Command injection
        ';\s*cat\s+',
        ';\s*ls\s+',
        ';\s*pwd',
        ';\s*whoami',
        ';\s*id',
        '\|\s*cat\s+',
        '\|\s*ls\s+',
        '&\s*cat\s+',
        '&\s*ls\s+',
    ];

    /**
     * Maksimal request per menit dari satu IP
     */
    protected int $maxRequestsPerMinute = 60;

    /**
     * Maksimal request per jam dari satu IP
     */
    protected int $maxRequestsPerHour = 1000;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $this->getClientIp($request);
        $userAgent = $request->userAgent() ?? '';
        $fullUrl = $request->fullUrl();
        $requestContent = $this->getRequestContent($request);

        // 1. Cek IP Whitelist (jika ada)
        if (!empty($this->whitelistedIps) && !in_array($clientIp, $this->whitelistedIps)) {
            $this->logSecurity('IP not in whitelist', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Access denied from your IP address');
        }

        // 2. Cek IP Blacklist
        if (in_array($clientIp, $this->blacklistedIps)) {
            $this->logSecurity('Blacklisted IP attempt', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Access denied from your IP address');
        }

        // 3. Cek User-Agent yang diblokir
        if ($this->isBlockedUserAgent($userAgent)) {
            $this->logSecurity('Blocked User-Agent detected', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Access denied: Invalid user agent');
        }

        // 4. Cek pola mencurigakan dalam URL dan parameter
        if ($this->containsSuspiciousPatterns($fullUrl . ' ' . $requestContent)) {
            $this->logSecurity('Suspicious pattern detected', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Access denied: Suspicious request detected');
        }

        // 5. Rate limiting - cek jumlah request per menit
        if ($this->isRateLimitExceeded($clientIp, 'minute', $this->maxRequestsPerMinute)) {
            $this->logSecurity('Rate limit exceeded (per minute)', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Too many requests. Please try again later.');
        }

        // 6. Rate limiting - cek jumlah request per jam
        if ($this->isRateLimitExceeded($clientIp, 'hour', $this->maxRequestsPerHour)) {
            $this->logSecurity('Rate limit exceeded (per hour)', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Too many requests. Please try again later.');
        }

        // 7. Cek header yang mencurigakan
        if ($this->hasSuspiciousHeaders($request)) {
            $this->logSecurity('Suspicious headers detected', $clientIp, $userAgent, $fullUrl);
            return $this->blockRequest('Access denied: Invalid headers');
        }

        // 8. Increment counter untuk rate limiting
        $this->incrementRequestCounter($clientIp);

        // Request aman, lanjutkan
        return $next($request);
    }

    /**
     * Mendapatkan IP client yang sebenarnya
     */
    protected function getClientIp(Request $request): string
    {
        // Cek berbagai header yang mungkin berisi IP asli
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_REAL_IP',            // Nginx
            'HTTP_X_FORWARDED_FOR',      // Proxy/Load Balancer
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR',               // Standard
        ];

        foreach ($headers as $header) {
            if ($request->server($header)) {
                $ip = trim(explode(',', $request->server($header))[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }

    /**
     * Cek apakah User-Agent diblokir
     */
    protected function isBlockedUserAgent(string $userAgent): bool
    {
        $userAgent = strtolower($userAgent);

        foreach ($this->blockedUserAgents as $blocked) {
            if (str_contains($userAgent, strtolower($blocked))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cek apakah mengandung pola mencurigakan
     * FIXED: Properly escape regex patterns
     */
    protected function containsSuspiciousPatterns(string $content): bool
    {
        $content = strtolower(urldecode($content));

        foreach ($this->suspiciousPatterns as $pattern) {
            // Use preg_quote to properly escape all regex special characters
            // Then use a different delimiter (# instead of /) to avoid conflicts
            if (preg_match('#' . preg_quote($pattern, '#') . '#i', $content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Alternative method using different approach for pattern matching
     * You can use this instead of the above method if you want more control
     */
    protected function containsSuspiciousPatternsAlternative(string $content): bool
    {
        $content = strtolower(urldecode($content));

        // Simple string matching for most patterns
        $simplePatterns = [
            'union select',
            'select * from',
            'insert into',
            'delete from',
            'drop table',
            '<script',
            '</script>',
            'javascript:',
            'vbscript:',
            'alert(',
            'confirm(',
            'prompt(',
            '../..',
            '..\\..\\',
        ];

        foreach ($simplePatterns as $pattern) {
            if (str_contains($content, $pattern)) {
                return true;
            }
        }

        // Regex patterns that need special handling
        $regexPatterns = [
            '/union\s+select/i',
            '/select\s+.*\s+from/i',
            '/insert\s+into/i',
            '/delete\s+from/i',
            '/drop\s+table/i',
            '/script\s*>/i',
            '/onload\s*=/i',
            '/onerror\s*=/i',
            '/onclick\s*=/i',
            '/;\s*cat\s+/i',
            '/;\s*ls\s+/i',
            '/;\s*pwd/i',
            '/;\s*whoami/i',
            '/;\s*id/i',
            '/\|\s*cat\s+/i',
            '/\|\s*ls\s+/i',
            '/&\s*cat\s+/i',
            '/&\s*ls\s+/i',
        ];

        foreach ($regexPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cek rate limiting
     */
    protected function isRateLimitExceeded(string $ip, string $period, int $maxRequests): bool
    {
        $cacheKey = "firewall_rate_limit_{$ip}_{$period}";
        $currentCount = Cache::get($cacheKey, 0);

        return $currentCount >= $maxRequests;
    }

    /**
     * Increment counter untuk rate limiting
     */
    protected function incrementRequestCounter(string $ip): void
    {
        // Counter per menit
        $minuteKey = "firewall_rate_limit_{$ip}_minute";
        $minuteCount = Cache::get($minuteKey, 0);
        Cache::put($minuteKey, $minuteCount + 1, 60); // 60 detik

        // Counter per jam
        $hourKey = "firewall_rate_limit_{$ip}_hour";
        $hourCount = Cache::get($hourKey, 0);
        Cache::put($hourKey, $hourCount + 1, 3600); // 3600 detik (1 jam)
    }

    /**
     * Cek header yang mencurigakan
     */
    protected function hasSuspiciousHeaders(Request $request): bool
    {
        // Cek Referer yang mencurigakan
        $referer = $request->header('referer', '');
        if ($referer && $this->containsSuspiciousPatterns($referer)) {
            return true;
        }

        // Cek X-Forwarded-Host untuk Host Header Injection
        $forwardedHost = $request->header('x-forwarded-host', '');
        if ($forwardedHost && !$this->isValidHostname($forwardedHost)) {
            return true;
        }

        // Cek Content-Type yang aneh untuk request POST/PUT
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $contentType = $request->header('content-type', '');
            if (empty($contentType) && $request->getContentLength() > 0) {
                return true; // Suspicious: has content but no content-type
            }
        }

        return false;
    }

    /**
     * Validasi hostname
     */
    protected function isValidHostname(string $hostname): bool
    {
        return preg_match('/^[a-zA-Z0-9.-]+$/', $hostname) &&
            !str_contains($hostname, '..') &&
            strlen($hostname) <= 253;
    }

    /**
     * Mendapatkan konten request (POST data, JSON, dll)
     */
    protected function getRequestContent(Request $request): string
    {
        $content = '';

        // Dapatkan POST data
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $content .= ' ' . serialize($request->all());
        }

        // Dapatkan raw content jika ada
        $rawContent = $request->getContent();
        if ($rawContent) {
            $content .= ' ' . $rawContent;
        }

        return $content;
    }

    /**
     * Block request dan return response
     */
    protected function blockRequest(string $message): Response
    {
        return response($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Log aktivitas keamanan
     */
    protected function logSecurity(string $reason, string $ip, string $userAgent, string $url): void
    {
        Log::warning('AppFirewall: Request blocked', [
            'reason' => $reason,
            'ip' => $ip,
            'user_agent' => $userAgent,
            'url' => $url,
            'timestamp' => now()->toISOString(),
        ]);
    }
}
