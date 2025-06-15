<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                'max:100',
                'min:3',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
            ],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Login (email atau username)
            'login.required' => 'Email atau username wajib diisi',
            'login.string' => 'Email atau username harus berupa teks',
            'login.max' => 'Email atau username maksimal 100 karakter',
            'login.min' => 'Email atau username minimal 3 karakter',

            // ✨ Custom login rules
            'login.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
            'login.not_regex' => 'Username tidak boleh hanya berupa angka',

            // Email khusus Gmail (jika applicable)
            'login.email' => 'Format email tidak valid',
            'login.ends_with' => 'Email harus menggunakan domain @gmail.com',

            // Password
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 255 karakter',
        ];
    }


    /**
     * Prepare the data for validation.
     * This method sanitizes input to prevent XSS and other attacks.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'login' => $this->sanitizeLogin($this->login),
        ]);
    }

    /**
     * Get the validated data from the request.
     * Override to ensure data is properly sanitized.
     *
     * @param array|int|string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if (is_null($key)) {
            // Sanitize validated data
            $validated['login'] = $this->sanitizeLogin($validated['login']);
            // Note: We don't sanitize password as it might contain special characters
        }

        return $validated;
    }

    /**
     * Sanitize login input (email or username).
     * Ensures login field is safe and properly formatted.
     *
     * @param string|null $value
     * @return string|null
     */
    private function sanitizeLogin(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Remove HTML tags and PHP tags
        $value = strip_tags($value);

        // Trim whitespace
        $value = trim($value);

        // Convert to lowercase for consistency
        $value = strtolower($value);

        // If it looks like an email, sanitize as email
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $value = filter_var($value, FILTER_SANITIZE_EMAIL);
        } else {
            // If it's a username, remove non-alphanumeric characters except underscore
            $value = preg_replace('/[^a-z0-9_]/', '', $value);
        }

        return $value;
    }

    /**
     * Validate the login field format.
     *
     * @return void
     */
    public function validateLogin(): void
    {
        $login = $this->input('login');

        if (!$login) {
            return;
        }

        // Check if it's an email
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Validate Gmail format
            if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $login)) {
                throw ValidationException::withMessages([
                    'login' => 'Email harus menggunakan domain @gmail.com',
                ]);
            }
        } else {
            // Validate username format
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
                throw ValidationException::withMessages([
                    'login' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
                ]);
            }
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'login' => 'email atau username',
            'password' => 'password',
        ];
    }

    /**
     * Handle a failed validation attempt.
     * This method logs security attempts.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log potential security threats
        $suspiciousPatterns = $this->detectSuspiciousPatterns();

        if (!empty($suspiciousPatterns)) {
            Log::warning('Suspicious login attempt detected', [
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'patterns' => $suspiciousPatterns,
                'login_field' => $this->input('login'),
                'timestamp' => now(),
            ]);
        }

        parent::failedValidation($validator);
    }

    /**
     * Detect suspicious patterns in input data that might indicate malicious intent.
     *
     * @return array
     */
    private function detectSuspiciousPatterns(): array
    {
        $patterns = [];
        $inputs = $this->only(['login', 'password']);

        foreach ($inputs as $field => $value) {
            if (!is_string($value)) {
                continue;
            }

            // Check for SQL injection patterns
            if (preg_match('/(\bSELECT\b|\bINSERT\b|\bUPDATE\b|\bDELETE\b|\bDROP\b|\bUNION\b|\bOR\b.*=|\bAND\b.*=)/i', $value)) {
                $patterns[] = "SQL injection pattern in {$field}";
            }

            // Check for XSS patterns
            if (preg_match('/<script|javascript:|on\w+\s*=|<iframe|<object|<embed/i', $value)) {
                $patterns[] = "XSS pattern in {$field}";
            }

            // Check for command injection patterns
            if (preg_match('/(\||;|&|\$\(|\`|>\s*\/|<\s*\/)/i', $value)) {
                $patterns[] = "Command injection pattern in {$field}";
            }

            // Check for path traversal patterns
            if (preg_match('/(\.\.|\/\.\.|\\\.\.)/i', $value)) {
                $patterns[] = "Path traversal pattern in {$field}";
            }

            // Check for common attack strings
            if (preg_match('/(union.*select|concat\(|char\(|0x[0-9a-f]+)/i', $value)) {
                $patterns[] = "Attack pattern in {$field}";
            }
        }

        return $patterns;
    }

    /**
     * Determine if the login field is an email.
     *
     * @return bool
     */
    public function isEmail(): bool
    {
        return filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Get the sanitized login credentials for authentication.
     *
     * @return array
     */
    public function getCredentials(): array
    {
        $login = $this->input('login');
        $password = $this->input('password');

        $credentials = ['password' => $password];

        if ($this->isEmail()) {
            $credentials['email'] = $login;
        } else {
            $credentials['username'] = $login;
        }

        return $credentials;
    }
}
