<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate verification token
        $verificationToken = Str::random(64);
        $verificationExpiry = now()->addHours(24); // Token expires in 24 hours

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'Inactive',
            'verification_token' => $verificationToken,
            'verification_expiry' => $verificationExpiry,
        ]);

        // Send verification email
        try {
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationToken));

            return redirect()->route('verify.sent')
                ->with('message', 'Registration successful! Please check your email to verify your account.');
        } catch (\Exception $e) {
            // If email fails, we can still let user know registration was successful
            return redirect()->route('verify.sent')
                ->with('warning', 'Registration successful! However, there was an issue sending the verification email. Please try to resend it.');
        }
    }

    /**
     * Show verification sent page.
     */
    public function showVerificationSent()
    {
        return view('auth.verify');
    }
}
