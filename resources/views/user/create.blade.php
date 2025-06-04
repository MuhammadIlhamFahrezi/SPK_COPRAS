@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users-gear text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Data User</h1>
                </div>
            </div>
            <!-- KEMBALI KE INDEX -->
            <a href="{{ route('user.index') }}">
                <button class="flex flex-row text-white rounded-md">
                    <i class="fa-solid fa-angle-left rounded-tl-md rounded-bl-md px-4 py-2 bg-gray-600 font-bold text-lg"></i>
                    <h1 class="bg-gray-500 px-4 py-2 rounded-tr-md rounded-br-md">Kembali</h1>
                </button>
            </a>
        </div>
        <div class="flex flex-col space-y-4">
            <!-- Validation Errors -->
            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="mt-2 ml-4 list-disc">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="w-full h-full shadow-xl">
                    <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <i class="fa-solid fa-pen-to-square text-base"></i>
                        <h1 class="text-lg font-semibold opacity-75">Tambah Data User</h1>
                    </div>
                    <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Nama Lengkap <span class="text-red-500">*</span></h1>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap"
                                    maxlength="100"
                                    required>
                                @error('nama_lengkap')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Username <span class="text-red-500">*</span></h1>
                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror"
                                    placeholder="Masukkan username"
                                    maxlength="50"
                                    required>
                                @error('username')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Email <span class="text-red-500">*</span></h1>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                    placeholder="Masukkan email"
                                    maxlength="100"
                                    required>
                                @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Role <span class="text-red-500">*</span></h1>
                                <select
                                    name="role"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                                    required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Password <span class="text-red-500">*</span></h1>
                                <input
                                    type="password"
                                    name="password"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                    placeholder="Masukkan password (minimal 6 karakter)"
                                    minlength="6"
                                    required>
                                @error('password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Konfirmasi Password <span class="text-red-500">*</span></h1>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Konfirmasi password"
                                    minlength="6"
                                    required>
                            </div>
                        </div>

                        <!-- Status Field (Optional) -->
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Status <span class="text-gray-400 text-sm font-normal">(Default: Inactive)</span></h1>
                                <select
                                    name="status"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="Inactive" {{ old('status', 'Inactive') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                            <div class="w-full">
                                <!-- Empty div for spacing -->
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                                <div class="text-sm text-blue-700">
                                    <p class="font-semibold mb-1">Informasi:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Password minimal 6 karakter</li>
                                        <li>Username dan email harus unik</li>
                                        <li>Status default adalah Inactive</li>
                                        <li>Field yang bertanda (*) wajib diisi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <button type="submit" class="flex items-center text-white space-x-2 px-4 py-2 bg-teal-600 rounded-md hover:bg-teal-700 transition-colors">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <h1>Simpan</h1>
                        </button>
                        <button type="reset" class="flex items-center text-white space-x-2 px-4 py-2 bg-cyan-400 rounded-md hover:bg-cyan-500 transition-colors">
                            <i class="fa-solid fa-rotate"></i>
                            <h1>Reset</h1>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add some client-side validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');

        // Password confirmation validation
        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Password tidak cocok');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });

        // Password strength indicator
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const strength = {
                length: password.length >= 6,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            // You can add visual feedback here if needed
        });
    });
</script>
@endsection