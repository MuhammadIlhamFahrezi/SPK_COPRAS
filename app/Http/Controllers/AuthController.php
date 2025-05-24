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
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.regex' => 'Email harus menggunakan @gmail.com',
            'password.min' => 'Password minimal harus 8 karakter',
        ]);

        // Cek apakah email ada di database
        $user = User::where('email', $credentials['email'])->first();

        $errors = [];

        // Jika user tidak ditemukan, email salah
        if (!$user) {
            $errors['email'] = 'Email salah';
        } else {
            // Jika user ditemukan, cek password
            if (!Hash::check($credentials['password'], $user->password)) {
                $errors['password'] = 'Password salah';
            }
        }

        // Jika ada error, kembalikan dengan pesan error
        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        // Jika semua benar, login user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Fallback jika terjadi error tidak terduga
        throw ValidationException::withMessages([
            'email' => 'Login gagal, silakan coba lagi',
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
