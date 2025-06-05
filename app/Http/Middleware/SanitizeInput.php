<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the current request should be sanitized
        if (!$this->shouldSanitize($request)) {
            return $next($request);
        }

        $input = $request->all();

        // Sanitize all input data using the enhanced method
        $sanitized = $this->sanitizeDataWithRules($input);

        // Replace the request input with sanitized data
        $request->replace($sanitized);

        return $next($request);
    }

    /**
     * Recursively sanitize data
     *
     * @param array $data
     * @return array
     */
    private function sanitizeData(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Recursively sanitize array values
                $sanitized[$key] = $this->sanitizeData($value);
            } elseif (is_string($value)) {
                // Sanitize string values
                $sanitized[$key] = $this->sanitizeString($value);
            } else {
                // Keep non-string values as is
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize a string value
     *
     * @param string $value
     * @return string
     */
    private function sanitizeString(string $value): string
    {
        // Remove any null bytes
        $value = str_replace(chr(0), '', $value);

        // Convert special characters to HTML entities
        $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);

        // Strip potentially dangerous tags while preserving safe ones
        $allowedTags = '<p><br><strong><em><u><i><b><span>';
        $value = strip_tags($value, $allowedTags);

        // Remove any remaining script tags and their content
        $value = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $value);

        // Remove any remaining style tags and their content
        $value = preg_replace('/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/mi', '', $value);

        // Remove javascript: protocol from any remaining attributes
        $value = preg_replace('/javascript:/i', '', $value);

        // Remove vbscript: protocol from any remaining attributes
        $value = preg_replace('/vbscript:/i', '', $value);

        // Remove onload, onclick, and other event handlers
        $value = preg_replace('/on\w+\s*=\s*["\'][^"\']*["\']/i', '', $value);

        // Remove any remaining expression() CSS
        $value = preg_replace('/expression\s*\(.*?\)/i', '', $value);

        // Trim whitespace
        return trim($value);
    }

    /**
     * Check if the current request should be sanitized
     * You can customize this method to skip certain routes or fields
     *
     * @param Request $request
     * @return bool
     */
    private function shouldSanitize(Request $request): bool
    {
        // Skip sanitization for certain routes if needed
        $skipRoutes = [
            // Add routes that should not be sanitized
            // 'api/raw-content'
        ];

        $currentRoute = $request->route()?->getName();

        return !in_array($currentRoute, $skipRoutes);
    }

    /**
     * Fields that should be excluded from sanitization
     * Add field names that should preserve their original content
     *
     * @return array
     */
    private function getExcludedFields(): array
    {
        return [
            'password',
            'password_confirmation',
            'current_password',
            '_token', // Add CSRF token to excluded fields
            // Add other fields that should not be sanitized
        ];
    }

    /**
     * Enhanced sanitization with field-specific rules
     *
     * @param array $data
     * @return array
     */
    private function sanitizeDataWithRules(array $data): array
    {
        $sanitized = [];
        $excludedFields = $this->getExcludedFields();

        foreach ($data as $key => $value) {
            if (in_array($key, $excludedFields)) {
                // Skip sanitization for excluded fields
                $sanitized[$key] = $value;
            } elseif (is_array($value)) {
                // Recursively sanitize array values
                $sanitized[$key] = $this->sanitizeDataWithRules($value);
            } elseif (is_string($value)) {
                // Apply field-specific sanitization rules
                $sanitized[$key] = $this->sanitizeByField($key, $value);
            } else {
                // Keep non-string values as is
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Apply field-specific sanitization rules
     *
     * @param string $fieldName
     * @param string $value
     * @return string
     */
    private function sanitizeByField(string $fieldName, string $value): string
    {
        switch ($fieldName) {
            case 'email':
                // For email fields, be more lenient but still secure
                return filter_var(trim($value), FILTER_SANITIZE_EMAIL);

            case 'username':
                // For username, remove special characters but allow alphanumeric and underscore
                return preg_replace('/[^a-zA-Z0-9_]/', '', $value);

            case 'nama_lengkap':
            case 'full_name':
                // For names, allow letters, spaces, and common punctuation
                $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                return preg_replace('/[^a-zA-Z\s\.\-\']/', '', $value);

            case 'phone':
            case 'telephone':
                // For phone numbers, allow only numbers, spaces, dashes, and parentheses
                return preg_replace('/[^0-9\s\-\(\)\+]/', '', $value);

            default:
                // Default sanitization for other fields
                return $this->sanitizeString($value);
        }
    }
}
