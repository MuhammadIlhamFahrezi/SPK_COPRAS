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

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Input -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-4 flex items-center pl-2 pointer-events-none text-[#6f42c1]">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <input type="email"
                            class="w-full pl-16 pr-4 py-4 rounded-full focus:outline-none focus:ring-2 focus:ring-[#6f42c1]/50 text-gray-700 placeholder:text-gray-400 shadow-lg border border-gray-200 @error('email') border-red-500 @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email Address"
                            required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-2 ml-4">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="relative mb-4">
                        <div class="absolute inset-y-0 left-4 flex items-center pl-2 pointer-events-none text-[#6f42c1]">
                            <i class="fas fa-lock text-xl"></i>
                        </div>
                        <input type="password"
                            class="w-full pl-16 pr-12 py-4 rounded-full focus:outline-none focus:ring-2 focus:ring-[#6f42c1]/50 text-gray-700 placeholder:text-gray-400 shadow-lg border border-gray-200 @error('password') border-red-500 @enderror"
                            id="password"
                            name="password"
                            placeholder="New Password"
                            required>
                        <!-- Eye icon -->
                        <div class="absolute inset-y-0 right-4 flex items-center cursor-pointer text-gray-400" onclick="togglePassword('password', 'eye-password')">
                            <i id="eye-password" class="fas fa-eye"></i>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-sm mt-2 ml-4">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-4 flex items-center pl-2 pointer-events-none text-[#6f42c1]">
                            <i class="fas fa-key text-xl"></i>
                        </div>
                        <input type="password"
                            class="w-full pl-16 pr-12 py-4 rounded-full focus:outline-none focus:ring-2 focus:ring-[#6f42c1]/50 text-gray-700 placeholder:text-gray-400 shadow-lg border border-gray-200"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirm New Password"
                            required>
                        <!-- Eye icon -->
                        <div class="absolute inset-y-0 right-4 flex items-center cursor-pointer text-gray-400" onclick="togglePassword('password_confirmation', 'eye-confirm')">
                            <i id="eye-confirm" class="fas fa-eye"></i>
                        </div>
                    </div>

                    <!-- JS for toggling password visibility -->
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
                    <button type="submit"
                        class="w-full py-4 bg-[#6f42c1] text-white font-bold text-lg rounded-full hover:bg-[#5a2d91] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3">
                        <i class="fas fa-key"></i>
                        <span>Reset Password</span>
                    </button>
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