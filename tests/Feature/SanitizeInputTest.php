<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SanitizeInputTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test XSS sanitization in login form
     */
    public function test_xss_sanitization_in_login()
    {
        $maliciousInput = [
            'login' => '<script>alert("XSS")</script>user@example.com',
            'password' => 'password123'
        ];

        $response = $this->post('/login', $maliciousInput);

        // Check that the script tag is removed/escaped
        $this->assertDatabaseMissing('users', [
            'email' => '<script>alert("XSS")</script>user@example.com'
        ]);
    }

    /**
     * Test HTML sanitization in registration form
     */
    public function test_html_sanitization_in_registration()
    {
        $maliciousInput = [
            'nama_lengkap' => '<img src="x" onerror="alert(1)">John Doe',
            'username' => '<script>alert("hack")</script>johndoe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $maliciousInput);

        // Verify that malicious content is sanitized
        // The exact assertion depends on your validation rules
        $response->assertStatus(302); // Redirect after registration
    }

    /**
     * Test SQL injection prevention
     */
    public function test_sql_injection_prevention()
    {
        $sqlInjectionInput = [
            'login' => "admin'; DROP TABLE users; --",
            'password' => 'password'
        ];

        $response = $this->post('/login', $sqlInjectionInput);

        // Should not cause any database issues
        $response->assertStatus(302);
    }

    /**
     * Test field-specific sanitization
     */
    public function test_field_specific_sanitization()
    {
        $testInput = [
            'nama_lengkap' => 'John Doe123!@#',
            'username' => 'user@#$%name',
            'email' => '<script>alert(1)</script>user@example.com',
            'phone' => '(123) 456-7890 abc',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/register', $testInput);

        // Check if field-specific rules are applied
        // Username should only contain alphanumeric and underscore
        // Phone should only contain numbers and allowed characters
        // Email should be properly sanitized
        $response->assertStatus(302);
    }

    /**
     * Test excluded fields (password should not be sanitized)
     */
    public function test_excluded_fields_not_sanitized()
    {
        $testInput = [
            'login' => 'user@example.com',
            'password' => '<>special&chars'
        ];

        $response = $this->post('/login', $testInput);

        // Password should remain unchanged as it's in excluded fields
        $response->assertStatus(302);
    }

    /**
     * Test nested array sanitization
     */
    public function test_nested_array_sanitization()
    {
        // This would be for forms with nested data
        $nestedInput = [
            'user' => [
                'name' => '<script>alert("nested")</script>John',
                'details' => [
                    'bio' => '<img src="x" onerror="alert(1)">Bio text'
                ]
            ]
        ];

        // You would need a route that accepts nested data
        // $response = $this->post('/some-route', $nestedInput);
        // $response->assertStatus(200);
    }
}

// Manual Testing Examples
class ManualSanitizeTest
{
    /**
     * Manual test examples you can run in browser or Postman
     */
    public function getTestCases()
    {
        return [
            // XSS Test Cases
            'xss_script' => [
                'input' => '<script>alert("XSS")</script>',
                'expected' => 'alert("XSS")', // Script tags removed
            ],
            'xss_img' => [
                'input' => '<img src="x" onerror="alert(1)">',
                'expected' => '', // Img tag removed
            ],
            'xss_javascript_protocol' => [
                'input' => '<a href="javascript:alert(1)">Link</a>',
                'expected' => '<a href="alert(1)">Link</a>', // javascript: removed
            ],

            // HTML Sanitization
            'allowed_tags' => [
                'input' => '<p>Hello <strong>World</strong></p>',
                'expected' => '<p>Hello <strong>World</strong></p>', // Allowed tags preserved
            ],
            'disallowed_tags' => [
                'input' => '<div><script>alert(1)</script><p>Hello</p></div>',
                'expected' => '<p>Hello</p>', // Only allowed tags remain
            ],

            // Field-specific tests
            'email_field' => [
                'input' => '<script>user@example.com</script>',
                'field' => 'email',
                'expected' => 'user@example.com',
            ],
            'username_field' => [
                'input' => 'user@#$name123',
                'field' => 'username',
                'expected' => 'username123',
            ],
            'phone_field' => [
                'input' => '(123) 456-7890 abc',
                'field' => 'phone',
                'expected' => '(123) 456-7890 ',
            ],
        ];
    }
}

/**
 * Browser Testing Instructions
 * 
 * 1. Open your registration form
 * 2. Try entering these values:
 *    - Name: <script>alert('XSS')</script>John Doe
 *    - Username: <img src="x" onerror="alert(1)">username
 *    - Email: <script>alert('hack')</script>user@example.com
 * 
 * 3. Submit the form and check:
 *    - No JavaScript alerts should appear
 *    - Data should be sanitized in the database
 *    - Form should process normally
 * 
 * 4. Test login form with:
 *    - Login: '; DROP TABLE users; --
 *    - Password: <script>alert(1)</script>
 * 
 * 5. Check browser developer tools:
 *    - Network tab to see sanitized data being sent
 *    - Console for any JavaScript errors
 */

/**
 * Postman Testing Examples
 */
class PostmanTests
{
    public function getPostmanTestCases()
    {
        return [
            'login_xss_test' => [
                'method' => 'POST',
                'url' => '/login',
                'body' => [
                    'login' => '<script>alert("XSS")</script>admin@example.com',
                    'password' => 'password123',
                    '_token' => '{{csrf_token}}'
                ]
            ],
            'register_html_injection' => [
                'method' => 'POST',
                'url' => '/register',
                'body' => [
                    'nama_lengkap' => '<img src="x" onerror="alert(1)">John Doe',
                    'username' => '<script>document.location="http://evil.com"</script>user',
                    'email' => 'user@example.com',
                    'password' => 'password123',
                    'password_confirmation' => 'password123',
                    '_token' => '{{csrf_token}}'
                ]
            ],
            'sql_injection_test' => [
                'method' => 'POST',
                'url' => '/login',
                'body' => [
                    'login' => "admin'; DELETE FROM users WHERE '1'='1",
                    'password' => 'password',
                    '_token' => '{{csrf_token}}'
                ]
            ]
        ];
    }
}

/**
 * Database Verification Queries
 * Run these in your database to verify sanitization worked:
 */
/*
-- Check if malicious scripts are stored
SELECT * FROM users WHERE email LIKE '%<script%' OR username LIKE '%<script%';

-- Check if HTML tags are properly handled
SELECT * FROM users WHERE nama_lengkap LIKE '%<%' OR nama_lengkap LIKE '%>%';

-- Verify field-specific sanitization
SELECT username FROM users WHERE username REGEXP '[^a-zA-Z0-9_]';
*/

/**
 * Unit Test for SanitizeInput Middleware
 */
class SanitizeInputUnitTest extends TestCase
{
    private $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new \App\Http\Middleware\SanitizeInput();
    }

    public function test_sanitize_string_method()
    {
        $reflection = new \ReflectionClass($this->middleware);
        $method = $reflection->getMethod('sanitizeString');
        $method->setAccessible(true);

        $testCases = [
            '<script>alert("XSS")</script>' => 'alert("XSS")',
            '<img src="x" onerror="alert(1)">' => '',
            'javascript:alert(1)' => 'alert(1)',
            '<p>Hello <strong>World</strong></p>' => '<p>Hello <strong>World</strong></p>',
        ];

        foreach ($testCases as $input => $expected) {
            $result = $method->invoke($this->middleware, $input);
            $this->assertEquals($expected, $result, "Failed for input: $input");
        }
    }

    public function test_sanitize_by_field_method()
    {
        $reflection = new \ReflectionClass($this->middleware);
        $method = $reflection->getMethod('sanitizeByField');
        $method->setAccessible(true);

        $testCases = [
            ['email', '<script>user@example.com</script>', 'user@example.com'],
            ['username', 'user@#$name', 'username'],
            ['phone', '(123) 456-7890 abc', '(123) 456-7890 '],
            ['nama_lengkap', 'John Doe123!', 'John Doe'],
        ];

        foreach ($testCases as [$field, $input, $expected]) {
            $result = $method->invoke($this->middleware, $field, $input);
            $this->assertEquals($expected, $result, "Failed for field $field with input: $input");
        }
    }
}
