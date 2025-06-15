<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for resetting the password.
     *
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function showResetForm($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    /**
     * Reset the given user's password.
     *
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        // Additional validation for email format
        $request->validateEmail();

        // Get sanitized data
        $email = $request->getEmail();
        $token = $request->getToken();
        $password = $request->getPassword();

        // Find user by email and token
        $user = User::where('email', $email)
            ->where('reset_pass_token', $token)
            ->first();

        $errors = [];
        $userExists = false;
        $tokenValid = false;

        // Check if user exists with the provided email and token
        if (!$user) {
            $errors['email'] = 'Token reset password tidak valid atau email tidak ditemukan';
        } else {
            $userExists = true;

            // Check if token is still valid (not expired)
            if (!$user->isResetTokenValid()) {
                $errors['token'] = 'Token reset password sudah kadaluarsa. Silakan minta token baru.';
            } else {
                $tokenValid = true;
            }
        }

        // Handle error scenarios
        if (!$userExists) {
            // User doesn't exist or token is wrong
            $errors['email'] = 'Token reset password tidak valid atau email tidak ditemukan';
            $errors['token'] = 'Token reset password tidak valid';
        }

        // If there are errors, log and throw validation exception
        if (!empty($errors)) {
            // Log failed password reset attempt
            Log::warning('Failed password reset attempt', [
                'ip' => $request->ip(),
                'email' => $email,
                'token' => $token,
                'user_exists' => $userExists,
                'token_valid' => $tokenValid,
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            throw ValidationException::withMessages($errors);
        }

        try {
            // Update password and clear reset token
            $user->update([
                'password' => Hash::make($password),
                'reset_pass_token' => null,
                'reset_pass_token_expiry' => null,
            ]);

            // Log successful password reset
            Log::info('Successful password reset', [
                'user_id' => $user->id_user,
                'email' => $user->email,
                'username' => $user->username,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            return redirect()->route('login')
                ->with('success', 'Password Anda berhasil direset! Silakan login dengan password baru Anda.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Password reset database error', [
                'user_id' => $user->id_user ?? null,
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now(),
            ]);

            // Return with error message
            return back()->withErrors([
                'email' => 'Terjadi kesalahan saat mereset password. Silakan coba lagi.',
            ])->withInput($request->only('email'));
        }
    }
}
