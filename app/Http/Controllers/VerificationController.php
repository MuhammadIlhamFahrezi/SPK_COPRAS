<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Http\Requests\ResendVerificationRequest;
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
    public function resendVerification(ResendVerificationRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return back()->with('error', 'Akun dengan alamat email ini tidak ada di Sistem Kami.')
                ->withInput($request->only('email'));
        }

        if ($user->isActive()) {
            return back()->with('info', 'Akun ini sudah terverifikasi.');
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

            return back()->with('success', 'Email verifikasi telah dikirim! Silakan cek inbox Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi nanti.')
                ->withInput($request->only('email'));
        }
    }
}
