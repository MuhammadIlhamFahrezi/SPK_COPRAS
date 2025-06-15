<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK COPRAS</title>
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
            <a href="{{ route('register') }}" class="text-white font-black bg-[#FFAE00] px-8 py-2 rounded-full hover:bg-[#e69d00] transition-all duration-300">Sign Up</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full min-h-[calc(100vh-5rem)] py-16 md:py-32 px-4 md:px-32">
        <div class="flex flex-col md:flex-row justify-between items-center md:space-x-36 space-y-8 md:space-y-0">
            <!-- Left Side - Login Form -->
            <div class="w-full md:w-1/2 bg-white/95 backdrop-blur-sm p-8 md:p-14 flex flex-col space-y-8 rounded-2xl shadow-2xl">
                <div class="flex justify-center items-center space-x-20">
                    <div class="border-b-4 border-[#FFAE00] flex justify-center items-center px-4 py-4 text-[#FFAE00] text-3xl font-black">
                        <button>Sign In</button>
                    </div>
                    <div class="group flex justify-center items-center px-4 py-4 border-b-4 border-gray-300 transition-colors duration-300 hover:border-[#FFAE00] opacity-80">
                        <a href="{{ route('register') }}" class="text-gray-300 text-3xl font-black opacity-50 transition-colors duration-300 group-hover:text-[#FFAE00]">
                            Sign Up
                        </a>
                    </div>
                </div>

                <!-- Display Success Message -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Display Error Message -->
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="py-4">
                    @csrf
                    <div class="space-y-8">
                        <!-- Login Field Container -->
                        <div class="w-full">
                            <div class="relative">
                                <!-- Ikon -->
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-circle-user text-2xl"></i>
                                </div>

                                <!-- Input -->
                                <input type="text" name="login" placeholder="Email atau Username"
                                    class="w-full pl-20 pr-4 py-3 rounded-full focus:outline-none 
                   text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
                   shadow-bottom @error('login') border-red-500 @enderror"
                                    value="{{ old('login') }}" />
                            </div>

                            <!-- Error Message -->
                            @error('login')
                            <span class="font-bold text-red-500 text-xs italic opacity-50">
                                {!! $message !!}
                            </span>
                            @enderror
                        </div>

                        <!-- Password Field Container -->
                        <div class="w-full">
                            <div class="relative">
                                <!-- Ikon Kunci -->
                                <div class="absolute inset-y-0 left-4 flex items-center pl-4 pointer-events-none text-[#FFAE00]">
                                    <i class="fas fa-lock text-2xl"></i>
                                </div>

                                <!-- Input -->
                                <input id="passwordInput" type="password" name="password" placeholder="Password"
                                    class="w-full pl-20 pr-12 py-3 rounded-full focus:outline-none 
            text-gray-400 text-base placeholder:text-gray-400 placeholder:text-base placeholder-bold
            shadow-bottom @error('password') border-red-500 @enderror" />

                                <!-- Tombol Tampilkan/Sembunyikan -->
                                <div class="absolute inset-y-0 right-4 flex items-center pr-4 cursor-pointer" onclick="togglePassword()">
                                    <i id="eyeIcon" class="fas fa-eye text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Error Message -->
                            @error('password')
                            <span class="font-bold text-red-500 text-xs italic opacity-50">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Script Toggle -->
                        <script>
                            function togglePassword() {
                                const input = document.getElementById('passwordInput');
                                const icon = document.getElementById('eyeIcon');
                                if (input.type === 'password') {
                                    input.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    input.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            }
                        </script>


                        <style>
                            /* Shadow hanya di bawah, dengan warna kuning #FFAE00 */
                            .shadow-bottom {
                                box-shadow: 0 4px 6px -4px rgba(255, 174, 0, 0.8);
                            }

                            .placeholder-bold::placeholder {
                                font-weight: 600;
                            }

                            /* Background animations */
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

                        <div class="flex justify-between items-center space-x-8">
                            <a href="{{ route('password.request') }}" class="w-1/2 text-left text-[#FFAE00] hover:text-[#e69d00] transition-colors duration-300">
                                Forgot your Password?
                            </a>
                            <button type="submit"
                                class="w-1/3 py-2 bg-[#FFAE00] rounded-full flex justify-center items-center space-x-3 hover:bg-[#e69d00] transition-all duration-300 text-white font-bold text-lg">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Masuk</span>
                            </button>
                        </div>

                    </div>

                </form>
            </div>

            <!-- Right Side - Content with Background -->
            <div class="w-full md:w-1/2 flex flex-col space-y-8 relative">
                <!-- Background decorative elements -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <!-- Floating geometric shapes -->
                    <div class="absolute top-10 right-10 w-20 h-20 bg-red-500/30 rounded-full floating"></div>
                    <div class="absolute top-40 left-10 w-16 h-16 bg-pink-400/20 rounded-lg rotate-45 floating"></div>
                    <div class="absolute bottom-32 right-20 w-12 h-12 bg-green-400/30 rounded-full floating"></div>
                    <div class="absolute bottom-10 left-32 w-8 h-8 bg-yellow-300/40 rounded-full floating"></div>

                    <!-- Database icons scattered -->
                    <div class="absolute top-20 left-1/3 text-red-600/30 floating">
                        <i class="fas fa-database text-4xl"></i>
                    </div>
                    <div class="absolute bottom-20 right-1/3 text-pink-500/30 floating">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                    <div class="absolute top-1/2 right-10 text-green-600/30 floating">
                        <i class="fas fa-cogs text-2xl"></i>
                    </div>
                </div>


                <!-- Content -->
                <div class="w-full relative z-10">
                    <h1 class="font-black justify text-2xl text-white text-justify drop-shadow-lg" style="word-spacing: 1.5rem;">
                        Sistem Pendukung Keputusan Metode COPRAS
                    </h1>
                </div>
                <div class="flex flex-col font-semibold text-white space-y-6 relative z-10">
                    <p class="text-justify drop-shadow-md backdrop-blur-sm bg-white/5 p-4 rounded-lg border border-white/10">
                        Sistem Pendukung Keputusan (SPK) merupakan suatu sistem informasi
                        spesifik yang ditujukan untuk membantu manajemen dalam mengambil
                        keputusan yang berkaitan dengan persoalan yang bersifat semi terstruktur.
                    </p>
                    <p class="text-justify drop-shadow-md backdrop-blur-sm bg-white/5 p-4 rounded-lg border border-white/10">
                        Metode Complex Proportional Assessment (COPRAS) mengasumsikan ketergantungan
                        langsung dan proporsional dari tingkat signifikansi dan utilitas dari
                        alternatif yang ada dengan adanya kriteria yang saling bertentangan.
                        Ini memperhitungkan kinerja alternatif sehubungan dengan kriteria yang
                        berbeda dan juga bobot kriteria yang sesuai. Metode ini memilih keputusan
                        terbaik mengingat solusi ideal dan ideal-terburuk
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>