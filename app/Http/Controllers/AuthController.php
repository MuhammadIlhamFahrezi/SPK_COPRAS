<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'], // Can be email or username
            'password' => ['required', 'string', 'min:8'],
        ], [
            'login.required' => 'Email atau username harus diisi',
            'password.min' => 'Password minimal harus 8 karakter',
        ]);

        $loginField = $credentials['login'];
        $password = $credentials['password'];

        // Determine if login field is email or username
        $user = null;
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            // It's an email - validate gmail format
            if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $loginField)) {
                throw ValidationException::withMessages([
                    'login' => 'Email harus menggunakan @gmail.com',
                ]);
            }
            $user = User::where('email', $loginField)->first();
        } else {
            // It's a username
            $user = User::where('username', $loginField)->first();
        }

        $errors = [];

        // Check if user exists
        if (!$user) {
            $errors['login'] = 'Email atau username tidak ditemukan';
        } else {
            // Check if account is active
            if (!$user->isActive()) {
                $errors['login'] = 'Akun Anda belum diaktivasi. Silakan hubungi administrator.';
            } else {
                // Check password
                if (!Hash::check($password, $user->password)) {
                    $errors['password'] = 'Password salah';
                }
            }
        }

        // If there are errors, return with validation messages
        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        // Attempt login with the correct field
        $loginCredentials = [
            'password' => $password
        ];

        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $loginCredentials['email'] = $loginField;
        } else {
            $loginCredentials['username'] = $loginField;
        }

        if (Auth::attempt($loginCredentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Fallback error
        throw ValidationException::withMessages([
            'login' => 'Login gagal, silakan coba lagi',
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
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
