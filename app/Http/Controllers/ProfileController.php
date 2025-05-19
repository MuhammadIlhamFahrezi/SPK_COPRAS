<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display user profile page
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Update user profile information
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama_lengkap' => 'required|max:100',
            'username' => ['required', 'max:50', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id_user, 'id_user'),
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
        ];

        $messages = [
            'email.regex' => 'Email harus menggunakan @gmail.com',
        ];

        // Only validate password if it's provided
        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
            $messages['password.min'] = 'Password minimal harus 6 karakter';
        }

        $validated = $request->validate($rules, $messages);

        // Only update password if it's provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Remove password from validated data if not provided
            unset($validated['password']);
        }

        // Update user profile - with debug option
        try {
            // Find the user explicitly
            $user = User::findOrFail($user->id_user);

            // Update each field individually to avoid mass assignment issues
            $user->nama_lengkap = $validated['nama_lengkap'];
            $user->username = $validated['username'];
            $user->email = $validated['email'];

            if (isset($validated['password'])) {
                $user->password = $validated['password'];
            }

            $user->save();

            return redirect()->route('profile.index')
                ->with('success', 'Profile berhasil diupdate');
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            return redirect()->route('profile.index')
                ->with('error', 'Gagal mengupdate profile: ' . $e->getMessage());
        }
    }
}
