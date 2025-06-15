<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
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
            'nama_lengkap' => [
                'required',
                'string',
                'max:100',
                'min:2',
                'regex:/^[a-zA-Z\s]+$/', // Only letters and spaces
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                'min:3',
                'unique:users,username',
                'regex:/^[a-zA-Z0-9_]+$/', // Only alphanumeric and underscore
                'not_regex:/^[0-9]+$/', // Cannot be only numbers
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:100',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/', // Only Gmail addresses
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
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
            // Nama Lengkap
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter',
            'nama_lengkap.min' => 'Nama lengkap minimal 2 karakter',
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh mengandung huruf dan spasi',

            // Username
            'username.required' => 'Username wajib diisi',
            'username.string' => 'Username harus berupa teks',
            'username.max' => 'Username maksimal 50 karakter',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
            'username.not_regex' => 'Username tidak boleh hanya berupa angka',

            // Email
            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah digunakan',
            'email.regex' => 'Email harus menggunakan domain @gmail.com',

            // Password
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Password dan Confirm Password harus sama',
            'password.min' => 'Password minimal 8 karakter',

            // ✨ Custom Password Rules
            'password.mixed' => 'Password harus mengandung minimal satu huruf besar dan satu huruf kecil.',
            'password.letters' => 'Password harus mengandung setidaknya satu huruf.',
            'password.numbers' => 'Password harus mengandung setidaknya satu angka.',
            'password.uncompromised' => 'Password ini telah bocor dalam kebocoran data, silakan gunakan password lain.',

            // Konfirmasi Password
            'password_confirmation.required' => 'Konfirmasi password wajib diisi',
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
            'nama_lengkap' => $this->sanitizeString($this->nama_lengkap),
            'username' => $this->sanitizeUsername($this->username),
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
            $validated['nama_lengkap'] = $this->sanitizeString($validated['nama_lengkap']);
            $validated['username'] = $this->sanitizeUsername($validated['username']);
            $validated['email'] = $this->sanitizeEmail($validated['email']);
        }

        return $validated;
    }

    /**
     * Sanitize general string input.
     * Removes HTML tags, trims whitespace, and prevents XSS.
     *
     * @param string|null $value
     * @return string|null
     */
    private function sanitizeString(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Remove HTML tags and PHP tags
        $value = strip_tags($value);

        // Convert special characters to HTML entities
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        // Trim whitespace
        $value = trim($value);

        // Remove multiple spaces and normalize
        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    /**
     * Sanitize username input.
     * Ensures username contains only safe characters.
     *
     * @param string|null $value
     * @return string|null
     */
    private function sanitizeUsername(?string $value): ?string
    {
        if (is_null($value)) {
            return null;
        }

        // Convert to lowercase
        $value = strtolower($value);

        // Remove any character that's not alphanumeric or underscore
        $value = preg_replace('/[^a-z0-9_]/', '', $value);

        // Trim whitespace
        $value = trim($value);

        return $value;
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
            'nama_lengkap' => 'nama lengkap',
            'username' => 'username',
            'email' => 'email',
            'password' => 'password',
            'password_confirmation' => 'konfirmasi password',
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
            Log::warning('Suspicious registration attempt detected', [
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'patterns' => $suspiciousPatterns,
                'input_data' => $this->only(['nama_lengkap', 'username', 'email']),
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
        $inputs = $this->only(['nama_lengkap', 'username', 'email', 'password']);

        foreach ($inputs as $field => $value) {
            if (!is_string($value)) {
                continue;
            }

            // Check for SQL injection patterns
            if (preg_match('/(\bSELECT\b|\bINSERT\b|\bUPDATE\b|\bDELETE\b|\bDROP\b|\bUNION\b|\bOR\b|\bAND\b)/i', $value)) {
                $patterns[] = "SQL injection pattern in {$field}";
            }

            // Check for XSS patterns
            if (preg_match('/<script|javascript:|on\w+\s*=/i', $value)) {
                $patterns[] = "XSS pattern in {$field}";
            }

            // Check for command injection patterns
            if (preg_match('/(\||;|&|\$\(|\`)/i', $value)) {
                $patterns[] = "Command injection pattern in {$field}";
            }

            // Check for path traversal patterns
            if (preg_match('/(\.\.|\/\.\.|\\\.\.)/i', $value)) {
                $patterns[] = "Path traversal pattern in {$field}";
            }
        }

        return $patterns;
    }
}
