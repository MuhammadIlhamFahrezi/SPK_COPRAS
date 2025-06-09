<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resend Verification - SPK COPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/montserrat.css') }}">
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#17a2b8] via-[#20c997] to-[#28a745]">
    <!-- Header -->
    <div class="w-full h-20 bg-white px-8 md:px-16 flex flex-row justify-between">
        <div class="text-[#17a2b8] flex items-center space-x-4">
            <i class="fas fa-paper-plane text-xl" style="transform: rotate(-15deg);"></i>
            <h1 class="font-bold text-xl">
                Sistem Pendukung Keputusan Metode COPRAS
            </h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-white font-black bg-[#17a2b8] px-8 py-2 rounded-full hover:bg-[#138496] transition-all duration-300">Back to Login</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full min-h-[calc(100vh-5rem)] py-16 px-4 flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#17a2b8]/10 rounded-full mb-4">
                        <i class="fas fa-paper-plane text-[#17a2b8] text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-[#17a2b8] mb-2">Resend Verification</h2>
                    <p class="text-gray-600">
                        Enter your email address to receive a new verification link.
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

                @if (session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('info') }}</span>
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
                <form method="POST" action="{{ route('verification.resend.post') }}" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-4 flex items-center pl-2 pointer-events-none text-[#17a2b8]">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <input type="email"
                            class="w-full pl-16 pr-4 py-4 rounded-full focus:outline-none focus:ring-2 focus:ring-[#17a2b8]/50 text-gray-700 placeholder:text-gray-400 shadow-lg border border-gray-200 @error('email') border-red-500 @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email address"
                            required>
                        @error('email')
                        <p class="text-red-500 text-sm mt-2 ml-4">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full py-4 bg-[#17a2b8] text-white font-bold text-lg rounded-full hover:bg-[#138496] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Verification Email</span>
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
                        class="text-[#17a2b8] hover:text-[#138496] transition-colors duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Login</span>
                    </a>
                </div>

                <!-- Tips Section -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-lightbulb text-yellow-500 mt-0.5"></i>
                        <div class="text-sm text-gray-700">
                            <p class="font-semibold mb-2">Tips:</p>
                            <ul class="space-y-1">
                                <li>• Check your spam/junk folder if you don't see the email</li>
                                <li>• Make sure you're using the same email address you registered with</li>
                                <li>• Verification links expire after 24 hours</li>
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