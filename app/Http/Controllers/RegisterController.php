<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Http\Requests\RegisterRequest; // Import the Form Request
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
    public function register(RegisterRequest $request) // Use RegisterRequest instead of Request
    {
        // Get validated and sanitized data
        $validatedData = $request->validated();

        // Generate verification token
        $verificationToken = Str::random(64);
        $verificationExpiry = now()->addHours(24); // Token expires in 24 hours

        $user = User::create([
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
            'status' => 'Inactive',
            'verification_token' => $verificationToken,
            'verification_expiry' => $verificationExpiry,
        ]);

        // Send verification email
        try {
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationToken));

            return redirect()->route('verify.sent')
                ->with('message', 'Pendaftaran berhasil! Silakan periksa email Anda untuk memverifikasi akun Anda.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Failed to send verification email', [
                'user_id' => $user->id_user,
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);

            // If email fails, we can still let user know registration was successful
            return redirect()->route('verify.sent')
                ->with('warning', 'Pendaftaran berhasil! Namun, terjadi masalah saat mengirim email verifikasi. Silakan coba kirim ulang.');
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
