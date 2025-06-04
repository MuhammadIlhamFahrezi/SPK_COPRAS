<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form to request a password reset link.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:100'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // For security, we don't reveal if email exists or not
            return back()->with('success', 'If an account with that email exists, we have sent a password reset link.');
        }

        if (!$user->isActive()) {
            return back()->with('error', 'Your account is not verified yet. Please verify your account first.');
        }

        // Generate reset token
        $resetToken = Str::random(64);
        $resetTokenExpiry = now()->addHours(1); // Token expires in 1 hour

        $user->update([
            'reset_pass_token' => $resetToken,
            'reset_pass_token_expiry' => $resetTokenExpiry,
        ]);

        // Send reset email
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user, $resetToken));

            return back()->with('success', 'If an account with that email exists, we have sent a password reset link.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reset email. Please try again later.');
        }
    }
}
