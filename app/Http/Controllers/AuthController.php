<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Middleware\LoginThrottle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login page
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $ip = $request->ip();

        // Check if IP is blocked
        if (LoginThrottle::isBlocked($ip)) {
            $remainingTime = LoginThrottle::getRemainingBlockTime($ip);

            Log::warning('Blocked IP attempted login', [
                'ip' => $ip,
                'remaining_minutes' => $remainingTime,
                'timestamp' => now(),
            ]);

            return response()->view('errors.blocked', [
                'minutes' => $remainingTime,
                'ip' => $ip
            ], 429);
        }

        // Additional validation for login format
        $request->validateLogin();

        // Get sanitized credentials
        $credentials = $request->getCredentials();
        $loginField = $request->input('login');
        $password = $request->input('password');

        // Find user based on login type
        $user = null;
        if ($request->isEmail()) {
            $user = User::where('email', $loginField)->first();
        } else {
            $user = User::where('username', $loginField)->first();
        }

        $errors = [];
        $userExists = false;
        $isActive = false;
        $passwordCorrect = false;

        // Check if user exists
        if (!$user) {
            $errors['login'] = 'Email atau username tidak ditemukan';
        } else {
            $userExists = true;

            // Check if account is active
            if (!$user->isActive()) {
                // Store user email/username in session for resend verification
                $request->session()->put('unverified_user', $loginField);

                // Create error message with resend verification link
                $resendUrl = route('verification.resend');
                $errors['login'] = 'Akun Anda belum diaktivasi. <a href="' . $resendUrl . '" class="text-[#007BFF] hover:text-[#0000EE] underline font-semibold">Kirim ulang email verifikasi</a>';
            } else {
                $isActive = true;

                // Check password
                if (!Hash::check($password, $user->password)) {
                    $errors['password'] = 'Password salah';
                } else {
                    $passwordCorrect = true;
                }
            }
        }

        // Handle error scenarios
        if (!$userExists) {
            // User doesn't exist - show errors on both fields for security
            $errors['login'] = 'Email atau username tidak ditemukan';
            $errors['password'] = 'Password salah';
        } else if ($userExists && !$isActive) {
            // User exists but inactive - still check password to show both errors if needed
            if (!Hash::check($password, $user->password)) {
                $errors['password'] = 'Password salah';
            }
        }

        // If there are errors, record failed attempt and throw validation exception
        if (!empty($errors)) {
            // Record failed login attempt for throttling
            LoginThrottle::recordFailedAttempt($ip);

            $remainingAttempts = LoginThrottle::getRemainingAttempts($ip);

            // Log failed login attempt with remaining attempts info
            Log::info('Failed login attempt', [
                'ip' => $ip,
                'login_field' => $loginField,
                'user_exists' => $userExists,
                'is_active' => $isActive,
                'password_correct' => $passwordCorrect,
                'remaining_attempts' => $remainingAttempts,
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            // Add warning message if attempts are running low
            if ($remainingAttempts <= 2 && $remainingAttempts > 0) {
                $errors['warning'] = "Peringatan: Tersisa {$remainingAttempts} percobaan lagi. IP akan diblokir selama 15 menit jika gagal terus.";
            } elseif ($remainingAttempts === 0) {
                // This should trigger the block, but just in case
                return response()->view('errors.blocked', [
                    'minutes' => LoginThrottle::BLOCK_DURATION,
                    'ip' => $ip
                ], 429);
            }

            throw ValidationException::withMessages($errors);
        }

        // Attempt login
        if (Auth::attempt($credentials)) {
            // Clear failed attempts on successful login
            LoginThrottle::clearFailedAttempts($ip);

            // Regenerate session for security
            $request->session()->regenerate();

            // Log successful login
            Log::info('Successful login', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'username' => Auth::user()->username,
                'ip' => $ip,
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            return redirect()->intended('dashboard');
        }

        // Fallback error - this should rarely happen due to our checks above
        LoginThrottle::recordFailedAttempt($ip);

        Log::error('Unexpected login failure', [
            'ip' => $ip,
            'login_field' => $loginField,
            'remaining_attempts' => LoginThrottle::getRemainingAttempts($ip),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
        ]);

        throw ValidationException::withMessages([
            'login' => 'Login gagal, silakan coba lagi',
            'password' => 'Login gagal, silakan coba lagi',
        ]);
    }

    /**
     * Handle logout request
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log logout
        if ($user) {
            Log::info('User logout', [
                'user_id' => $user->id_user,
                'email' => $user->email,
                'username' => $user->username,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
