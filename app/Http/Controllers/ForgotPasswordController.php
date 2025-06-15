<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ResetPasswordMail;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan formulir untuk meminta tautan reset password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot_password');
    }

    /**
     * Mengirimkan tautan reset password ke pengguna.
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            // Tampilkan pesan error khusus jika email tidak ditemukan
            return back()->with('error', 'Akun dengan alamat email ini tidak ada di Sistem Kami.')
                ->withInput($request->only('email'));
        }

        if (!$user->isActive()) {
            return back()->with('error', 'Akun Anda belum diverifikasi. Silakan verifikasi akun terlebih dahulu.')
                ->withInput($request->only('email'));
        }

        // Generate token reset password
        $resetToken = Str::random(64);
        $resetTokenExpiry = now()->addHours(1); // Token berlaku selama 1 jam

        $user->update([
            'reset_pass_token' => $resetToken,
            'reset_pass_token_expiry' => $resetTokenExpiry,
        ]);

        // Kirim email reset password
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user, $resetToken));

            return back()->with('success', 'Tautan reset password telah dikirim ke alamat email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email reset. Silakan coba lagi nanti.')
                ->withInput($request->only('email'));
        }
    }
}
