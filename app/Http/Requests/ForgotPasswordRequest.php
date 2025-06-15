<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ForgotPasswordRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:100',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/', // Only Gmail addresses
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
            // Email
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.regex' => 'Email harus menggunakan domain @gmail.com',
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
            // Sanitize all validated data
            $validated['email'] = $this->sanitizeEmail($validated['email']);
        }

        return $validated;
    }

    /**
     * Sanitize email input.
     * Ensures email is in proper format and safe.
     *
     * @param string|null $value
     * @return string|null
     */
    private function sanitizeEmail(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Convert to lowercase
        $value = strtolower($value);

        // Remove HTML tags
        $value = strip_tags($value);

        // Trim whitespace
        $value = trim($value);

        // Use PHP's filter to sanitize email
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);

        return $value;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'email',
        ];
    }

    /**
     * Handle a failed validation attempt.
     * This method can be used to log security attempts or add additional security measures.
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
            Log::warning('Suspicious forgot password attempt detected', [
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'patterns' => $suspiciousPatterns,
                'input_data' => $this->only(['email']),
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
        $email = $this->input('email');

        if (!is_string($email)) {
            return $patterns;
        }

        // Check for SQL injection patterns
        if (preg_match('/(\bSELECT\b|\bINSERT\b|\bUPDATE\b|\bDELETE\b|\bDROP\b|\bUNION\b|\bOR\b|\bAND\b)/i', $email)) {
            $patterns[] = "SQL injection pattern in email";
        }

        // Check for XSS patterns
        if (preg_match('/<script|javascript:|on\w+\s*=/i', $email)) {
            $patterns[] = "XSS pattern in email";
        }

        // Check for command injection patterns
        if (preg_match('/(\||;|&|\$\(|\`)/i', $email)) {
            $patterns[] = "Command injection pattern in email";
        }

        // Check for path traversal patterns
        if (preg_match('/(\.\.|\/\.\.|\\\.\.)/i', $email)) {
            $patterns[] = "Path traversal pattern in email";
        }

        return $patterns;
    }
}
