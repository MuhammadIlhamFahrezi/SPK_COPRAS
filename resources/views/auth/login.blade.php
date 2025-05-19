<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK COPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quantico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#FFAE00]">
    <div class="w-full h-20 bg-white px-8 md:px-32 shadow-lg">
        <div class="text-[#FFAE00] w-full h-full flex items-center space-x-4">
            <i class="fas fa-database text-xl" style="transform: rotate(-20deg);"></i>
            <h1 class="font-bold text-xl">
                Sistem Pendukung Keputusan Metode COPRAS
            </h1>
        </div>
    </div>
    <div class="w-full h-full py-16 md:py-32 px-4 md:px-32">
        <div class="flex flex-col md:flex-row justify-between items-center md:space-x-36 space-y-8 md:space-y-0">
            <div class="w-full md:w-1/2 flex flex-col space-y-8">
                <div class="w-full">
                    <h1 class="font-black justify text-2xl text-white text-justify" style="word-spacing: 1.5rem;">
                        Sistem Pendukung Keputusan Metode COPRAS
                    </h1>
                </div>
                <div class="flex flex-col font-semibold text-white space-y-6">
                    <p class="text-justify">
                        Sistem Pendukung Keputusan (SPK) merupakan suatu sistem informasi
                        spesifik yang ditujukan untuk membantu manajemen dalam mengambil
                        keputusan yang berkaitan dengan persoalan yang bersifat semi terstruktur.
                    </p>
                    <p class="text-justify">
                        Metode Complex Proportional Assessment (COPRAS) mengasumsikan ketergantungan
                        langsung dan proporsional dari tingkat signifikansi dan utilitas dari
                        alternatif yang ada dengan adanya kriteria yang saling bertentangan.
                        Ini memperhitungkan kinerja alternatif sehubungan dengan kriteria yang
                        berbeda dan juga bobot kriteria yang sesuai. Metode ini memilih keputusan
                        terbaik mengingat solusi ideal dan ideal-terburuk
                    </p>
                </div>
            </div>
            <div class="w-full md:w-1/2 bg-white p-8 md:p-14 rounded-lg shadow-lg flex flex-col space-y-8">
                <div class="flex justify-center items-center">
                    <h1 class="text-3xl">
                        Login Account
                    </h1>
                </div>
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="w-full">
                        <input type="email" name="email" placeholder="Email" required
                            class="w-full p-3 px-8 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <input type="password" name="password" placeholder="Password" required
                            class="w-full p-3 px-8 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-center items-center">
                        <button type="submit"
                            class="w-full py-4 bg-[#FFAE00] rounded-full flex justify-center items-center space-x-4">
                            <div class="text-white">
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div class="text-white text-lg font-bold">
                                Masuk
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>