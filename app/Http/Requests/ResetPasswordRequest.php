<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends FormRequest
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
            'token' => [
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],
            'password_confirmation' => [
                'required',
                'string',
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
            // Token
            'token.required' => 'Token reset password harus diisi',
            'token.string' => 'Token reset password harus berupa teks',
            'token.min' => 'Token reset password tidak valid',
            'token.max' => 'Token reset password tidak valid',

            // Email
            'email.required' => 'Email harus diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',

            // Password
            'password.required' => 'Password baru harus diisi',
            'password.string' => 'Password harus berupa teks',
            'password.confirmed' => 'Konfirmasi password tidak cocok',

            // Password confirmation
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.string' => 'Konfirmasi password harus berupa teks',
        ];
    }

    /**
     * Prepare the data for validation.
     * This method sanitizes input to prevent XSS and other attacks.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => $this->sanitizeEmail($this->email),
            'token' => $this->sanitizeToken($this->token),
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
            $validated['email'] = $this->sanitizeEmail($validated['email']);
            $validated['token'] = $this->sanitizeToken($validated['token']);
            // Note: We don't sanitize passwords as they might contain special characters
        }

        return $validated;
    }

    /**
     * Sanitize email input.
     *
     * @param string|null $value
     * @return string|null
     */
    private function sanitizeEmail(?string $value): ?string
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

        // Sanitize email
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);

        return $value;
    }

    /**
     * Sanitize token input.
     *
     * @param string|null $value
     * @return string|null
     */
    private function sanitizeToken(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Remove HTML tags and PHP tags
        $value = strip_tags($value);

        // Trim whitespace
        $value = trim($value);

        // Remove potentially dangerous characters but keep alphanumeric and common token characters
        $value = preg_replace('/[^a-zA-Z0-9\-_]/', '', $value);

        return $value;
    }

    /**
     * Validate the email format.
     *
     * @return void
     */
    public function validateEmail(): void
    {
        $email = $this->input('email');

        if (!$email) {
            return;
        }

        // Validate Gmail format
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
            throw ValidationException::withMessages([
                'email' => 'Email harus menggunakan domain @gmail.com',
            ]);
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
            'token' => 'token reset password',
            'email' => 'email',
            'password' => 'password baru',
            'password_confirmation' => 'konfirmasi password',
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
            Log::warning('Suspicious password reset attempt detected', [
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'patterns' => $suspiciousPatterns,
                'email' => $this->input('email'),
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
        $inputs = $this->only(['email', 'token', 'password', 'password_confirmation']);

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
     * Get the sanitized email for password reset.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->input('email');
    }

    /**
     * Get the sanitized token for password reset.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->input('token');
    }

    /**
     * Get the new password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->input('password');
    }
}
