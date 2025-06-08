<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - SPK COPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/montserrat.css') }}">
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#28a745] via-[#34ce57] to-[#20c997]">
    <!-- Header -->
    <div class="w-full h-20 bg-white px-8 md:px-16 flex flex-row justify-between">
        <div class="text-[#28a745] flex items-center space-x-4">
            <i class="fas fa-envelope-open-text text-xl" style="transform: rotate(-15deg);"></i>
            <h1 class="font-bold text-xl">
                Sistem Pendukung Keputusan Metode COPRAS
            </h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-white font-black bg-[#28a745] px-8 py-2 rounded-full hover:bg-[#218838] transition-all duration-300">Back to Login</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full min-h-[calc(100vh-5rem)] py-16 px-4 flex items-center justify-center">
        <div class="max-w-md w-full">
            <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-[#28a745]/10 rounded-full mb-4">
                        <i class="fas fa-envelope-open-text text-[#28a745] text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-[#28a745] mb-2">Check Your Email!</h2>
                    <p class="text-gray-600">
                        We've sent a verification link to your email address. Please click the link in the email to verify your account.
                    </p>
                </div>

                <!-- Alert Messages -->
                @if (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                </div>
                @endif

                @if (session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="{{ route('login') }}"
                        class="w-full py-4 bg-[#28a745] text-white font-bold text-lg rounded-full hover:bg-[#218838] transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Go to Login</span>
                    </a>

                    <a href="{{ route('verification.resend') }}"
                        class="w-full py-4 bg-gray-100 text-gray-700 font-bold text-lg rounded-full hover:bg-gray-200 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3 border border-gray-300">
                        <i class="fas fa-paper-plane"></i>
                        <span>Resend Verification Email</span>
                    </a>
                </div>

                <!-- Info Notice -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold mb-1">Tips:</p>
                            <ul class="space-y-1">
                                <li>• Check your spam/junk folder</li>
                                <li>• Verification links expire in 24 hours</li>
                                <li>• Make sure to use the same email address</li>
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