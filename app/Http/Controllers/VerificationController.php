<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /**
     * Verify user account with token.
     */
    public function verifyAccount($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification token.');
        }

        if (!$user->isVerificationTokenValid()) {
            return redirect()->route('login')
                ->with('error', 'Verification token has expired. Please request a new one.');
        }

        // Activate the user account
        $user->update([
            'status' => 'Active',
            'verification_token' => null,
            'verification_expiry' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Your account has been verified successfully! You can now login.');
    }

    /**
     * Show resend verification form.
     */
    public function showResendForm()
    {
        return view('auth.resend_verification');
    }

    /**
     * Resend verification email.
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:100'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email address.');
        }

        if ($user->isActive()) {
            return back()->with('info', 'This account is already verified.');
        }

        // Generate new verification token
        $verificationToken = Str::random(64);
        $verificationExpiry = now()->addHours(24);

        $user->update([
            'verification_token' => $verificationToken,
            'verification_expiry' => $verificationExpiry,
        ]);

        // Send verification email
        try {
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationToken));

            return back()->with('success', 'Verification email has been sent! Please check your inbox.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification email. Please try again later.');
        }
    }
}
