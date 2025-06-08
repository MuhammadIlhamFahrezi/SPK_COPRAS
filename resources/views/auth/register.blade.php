<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SPK COPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/montserrat.css') }}">
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#FFAE00] via-[#FFC947] to-[#FF6F00]">
    <!-- Header -->
    <div class="w-full h-20 bg-white px-8 md:px-16 flex flex-row justify-between">
        <div class="text-[#FFAE00] flex items-center space-x-4">
            <i class="fas fa-database text-xl" style="transform: rotate(-20deg);"></i>
            <h1 class="font-bold text-xl">
                Sistem Pendukung Keputusan Metode COPRAS
            </h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-white font-black bg-[#FFAE00] px-8 py-2 rounded-full hover:bg-[#e69d00] transition-all duration-300">Sign In</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full min-h-[calc(100vh-5rem)] py-16 md:py-32 px-4 md:px-32">
        <div class="flex flex-col md:flex-row justify-between items-center md:space-x-36 space-y-8 md:space-y-0">
            <!-- Left Side - Register Form -->
            <div class="w-full md:w-1/2 bg-white/95 backdrop-blur-sm p-8 md:p-14 flex flex-col space-y-8 rounded-2xl shadow-2xl">
                <div class="flex justify-center items-center space-x-20">
                    <div class="group flex justify-center items-center px-4 py-4 border-b-4 border-gray-300 transition-colors duration-300 hover:border-[#FFAE00] opacity-50">
                        <a href="{{ route('login') }}" class="text-gray-300 text-3xl font-black opacity-50 transition-colors duration-300 group-hover:text-[#FFAE00]">
                            Sign In
                        </a>
                    </div>
                    <div class="border-b-4 border-[#FFAE00] flex justify-center items-center px-4 py-4 text-[#FFAE00] text-3xl font-black">
                        <button>Sign Up</button>
                    </div>
                </div>

                <form action="{{ route('register') }}" method="POST" class="py-4">
                    @csrf
                    <div class="space-y-2">
                        <!-- Full Name -->
                        <div class="w-full">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-user text-2xl"></i>
                                </div>
                                <input type="text" name="nama_lengkap" placeholder="Full Name" required
                                    class="w-full pl-20 pr-4 py-3 rounded-full focus:outline-none 
                                   text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
                                   shadow-bottom @error('nama_lengkap') border-red-500 @enderror"
                                    value="{{ old('nama_lengkap') }}" />
                            </div>
                            <!-- Error Message Container -->
                            <div class="h-5 mt-1">
                                @error('nama_lengkap')
                                <span class="font-bold text-red-500 text-xs italic opacity-50">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="w-full">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-at text-2xl"></i>
                                </div>
                                <input type="text" name="username" placeholder="Username" required
                                    class="w-full pl-20 pr-4 py-3 rounded-full focus:outline-none 
                                   text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
                                   shadow-bottom @error('username') border-red-500 @enderror"
                                    value="{{ old('username') }}" />
                            </div>
                            <!-- Error Message Container -->
                            <div class="h-5 mt-1">
                                @error('username')
                                <span class="font-bold text-red-500 text-xs italic opacity-50">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="w-full">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-envelope text-2xl"></i>
                                </div>
                                <input type="email" name="email" placeholder="Email Address" required
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

                        <!-- Password -->
                        <div class="w-full">
                            <div class="relative">
                                <!-- Icon -->
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-lock text-2xl"></i>
                                </div>

                                <!-- Input -->
                                <input id="passwordInput" type="password" name="password" placeholder="Password" required
                                    class="w-full pl-20 pr-12 py-3 rounded-full focus:outline-none 
            text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
            shadow-bottom @error('password') border-red-500 @enderror" />

                                <!-- Toggle Password Visibility -->
                                <div class="absolute inset-y-0 right-4 flex items-center pr-4 cursor-pointer" onclick="togglePassword('passwordInput', 'eyePassword')">
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

                        <!-- Confirm Password -->
                        <div class="w-full">
                            <div class="relative">
                                <!-- Icon -->
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-key text-2xl"></i>
                                </div>

                                <!-- Input -->
                                <input id="confirmPasswordInput" type="password" name="password_confirmation" placeholder="Confirm Password" required
                                    class="w-full pl-20 pr-12 py-3 rounded-full focus:outline-none 
            text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
            shadow-bottom @error('password_confirmation') border-red-500 @enderror" />

                                <!-- Toggle Confirm Visibility -->
                                <div class="absolute inset-y-0 right-4 flex items-center pr-4 cursor-pointer" onclick="togglePassword('confirmPasswordInput', 'eyeConfirm')">
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


                        <style>
                            .shadow-bottom {
                                box-shadow: 0 4px 6px -4px rgba(255, 174, 0, 0.8);
                            }

                            .placeholder-bold::placeholder {
                                font-weight: 600;
                            }

                            @keyframes float {

                                0%,
                                100% {
                                    transform: translateY(0px);
                                }

                                50% {
                                    transform: translateY(-20px);
                                }
                            }

                            .floating {
                                animation: float 6s ease-in-out infinite;
                            }

                            .floating:nth-child(2) {
                                animation-delay: 2s;
                            }

                            .floating:nth-child(3) {
                                animation-delay: 4s;
                            }
                        </style>

                        <div class="flex justify-between items-center space-x-8 pt-4">
                            <a href="{{ route('login') }}" class="w-1/2 text-left text-[#FFAE00] hover:text-[#e69d00] transition-colors duration-300">
                                Already have an account?
                            </a>
                            <button type="submit"
                                class="w-1/3 py-2 bg-[#FFAE00] rounded-full flex justify-center items-center space-x-3 hover:bg-[#e69d00] transition-all duration-300 text-white font-bold text-lg">
                                <i class="fas fa-user-plus"></i>
                                <span>Daftar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Side - Content with Background -->
            <div class="w-full md:w-1/2 flex flex-col space-y-8 relative">
                <!-- Background decorative elements -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="absolute top-10 right-10 w-20 h-20 bg-blue-500/30 rounded-full floating"></div>
                    <div class="absolute top-40 left-10 w-16 h-16 bg-purple-400/20 rounded-lg rotate-45 floating"></div>
                    <div class="absolute bottom-32 right-20 w-12 h-12 bg-green-400/30 rounded-full floating"></div>
                    <div class="absolute bottom-10 left-32 w-8 h-8 bg-pink-300/40 rounded-full floating"></div>

                    <div class="absolute top-20 left-1/3 text-blue-600/30 floating">
                        <i class="fas fa-user-plus text-4xl"></i>
                    </div>
                    <div class="absolute bottom-20 right-1/3 text-purple-500/30 floating">
                        <i class="fas fa-chart-bar text-3xl"></i>
                    </div>
                    <div class="absolute top-1/2 right-10 text-green-600/30 floating">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>

                <!-- Content -->
                <div class="w-full relative z-10">
                    <h1 class="font-black justify text-2xl text-white text-justify drop-shadow-lg" style="word-spacing: 1.5rem;">
                        Bergabunglah dengan Sistem Pendukung Keputusan
                    </h1>
                </div>
                <div class="flex flex-col font-semibold text-white space-y-6 relative z-10">
                    <p class="text-justify drop-shadow-md backdrop-blur-sm bg-white/5 p-4 rounded-lg border border-white/10">
                        Daftarkan diri Anda untuk mengakses sistem pendukung keputusan yang
                        canggih dengan metode COPRAS. Dapatkan analisis yang akurat dan
                        rekomendasi terbaik untuk keputusan bisnis Anda.
                    </p>
                    <p class="text-justify drop-shadow-md backdrop-blur-sm bg-white/5 p-4 rounded-lg border border-white/10">
                        Dengan mendaftar, Anda akan mendapatkan akses penuh ke fitur-fitur
                        analisis multi-kriteria yang membantu dalam pengambilan keputusan
                        yang objektif dan terstruktur berdasarkan data yang valid.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>