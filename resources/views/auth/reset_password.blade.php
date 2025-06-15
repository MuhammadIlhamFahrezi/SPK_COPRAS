<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SPK COPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/montserrat.css') }}">
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <style>
        .shadow-bottom {
            box-shadow: 0 4px 6px -4px rgba(111, 66, 193, 0.8);
        }

        .placeholder-bold::placeholder {
            font-weight: 600;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#6f42c1] via-[#8b5cf6] to-[#a855f7]">
    <!-- Header -->
    <div class="w-full h-20 bg-white px-8 md:px-16 flex flex-row justify-between">
        <div class="text-[#6f42c1] flex items-center space-x-4">
            <i class="fas fa-key text-xl" style="transform: rotate(-15deg);"></i>
            <h1 class="font-bold text-xl">
                Sistem Pendukung Keputusan Metode COPRAS
            </h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-white font-black bg-[#6f42c1] px-8 py-2 rounded-full hover:bg-[#5a2d91] transition-all duration-300">Back to Login</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full min-h-[calc(100vh-5rem)] py-16 px-4 flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#6f42c1]/10 rounded-full mb-4">
                        <i class="fas fa-key text-[#6f42c1] text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-[#6f42c1] mb-2">Reset Password</h2>
                    <p class="text-gray-600">
                        Enter your new password below to reset your account password.
                    </p>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-2">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Input -->
                    <div class="w-full">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#6f42c1]">
                                <i class="fas fa-envelope text-2xl"></i>
                            </div>
                            <input type="email" name="email" placeholder="Email Address"
                                class="w-full pl-20 pr-4 py-3 rounded-full focus:outline-none 
                               text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
                               shadow-bottom @error('email') border-red-500 @enderror"
                                value="{{ old('email') }}" />
                        </div>
                        <!-- Error Message Container -->
                        <div class="h-5 mt-1">
                            @error('email')
                            <span class="font-bold text-red-500 text-xs italic opacity-50">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="w-full">
                        <div class="relative">
                            <!-- Icon -->
                            <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#6f42c1]">
                                <i class="fas fa-lock text-2xl"></i>
                            </div>

                            <!-- Input -->
                            <input id="password" type="password" name="password" placeholder="New Password"
                                class="w-full pl-20 pr-12 py-3 rounded-full focus:outline-none 
                text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
                shadow-bottom @error('password') border-red-500 @enderror" />

                            <!-- Toggle Password Visibility -->
                            <div class="absolute inset-y-0 right-4 flex items-center pr-4 cursor-pointer" onclick="togglePassword('password', 'eyePassword')">
                                <i id="eyePassword" class="fas fa-eye text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Error Message Container -->
                        <div class="h-5 mt-1">
                            @error('password')
                            <span class="font-bold text-red-500 text-xs italic opacity-50">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="w-full">
                        <div class="relative">
                            <!-- Icon -->
                            <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#6f42c1]">
                                <i class="fas fa-key text-2xl"></i>
                            </div>

                            <!-- Input -->
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm New Password"
                                class="w-full pl-20 pr-12 py-3 rounded-full focus:outline-none 
                text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
                shadow-bottom" />

                            <!-- Toggle Confirm Visibility -->
                            <div class="absolute inset-y-0 right-4 flex items-center pr-4 cursor-pointer" onclick="togglePassword('password_confirmation', 'eyeConfirm')">
                                <i id="eyeConfirm" class="fas fa-eye text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Error Message Container -->
                        <div class="h-5 mt-1">
                            @error('password_confirmation')
                            <span class="font-bold text-red-500 text-xs italic opacity-50">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Script for toggling password visibility -->
                    <script>
                        function togglePassword(inputId, iconId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(iconId);
                            if (input.type === "password") {
                                input.type = "text";
                                icon.classList.remove("fa-eye");
                                icon.classList.add("fa-eye-slash");
                            } else {
                                input.type = "password";
                                icon.classList.remove("fa-eye-slash");
                                icon.classList.add("fa-eye");
                            }
                        }
                    </script>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-[#6f42c1] text-white font-bold text-lg rounded-full hover:bg-[#5a2d91] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3">
                            <i class="fas fa-key"></i>
                            <span>Reset Password</span>
                        </button>
                    </div>
                </form>

                <!-- Footer Links -->
                <div class="mt-8 text-center space-y-4">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="h-px bg-gray-300 flex-1"></div>
                        <span class="text-gray-500 text-sm">or</span>
                        <div class="h-px bg-gray-300 flex-1"></div>
                    </div>

                    <a href="{{ route('login') }}"
                        class="text-[#6f42c1] hover:text-[#5a2d91] transition-colors duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Login</span>
                    </a>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-shield-alt text-purple-500 mt-0.5"></i>
                        <div class="text-sm text-purple-700">
                            <p class="font-semibold mb-2">Security Tips:</p>
                            <ul class="space-y-1">
                                <li>• Use a strong, unique password</li>
                                <li>• Don't share your password with anyone</li>
                                <li>• Log out from shared devices</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Animation -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-12 h-12 bg-white/20 rounded-full animate-pulse"></div>
                <div class="absolute top-3/4 right-1/4 w-8 h-8 bg-white/10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-1/4 left-3/4 w-6 h-6 bg-white/15 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
            </div>
        </div>
    </div>
</body>

</html>