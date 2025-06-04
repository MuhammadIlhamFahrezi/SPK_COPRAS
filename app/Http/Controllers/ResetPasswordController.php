<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for resetting the password.
     */
    public function showResetForm($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)
            ->where('reset_pass_token', $request->token)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid reset token or email address.']);
        }

        if (!$user->isResetTokenValid()) {
            return back()->withErrors(['token' => 'Password reset token has expired. Please request a new one.']);
        }

        // Update password and clear reset token
        $user->update([
            'password' => Hash::make($request->password),
            'reset_pass_token' => null,
            'reset_pass_token_expiry' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Your password has been reset successfully! You can now login with your new password.');
    }
}
