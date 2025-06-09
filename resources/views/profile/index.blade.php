@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-user text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Data Profile</h1>
                </div>
            </div>
            <!-- KEMBALI KE DASHBOARD -->
            <a href="{{ route('dashboard') }}">
                <button class="flex flex-row text-white rounded-md">
                    <i class="fa-solid fa-angle-left rounded-tl-md rounded-bl-md px-4 py-2 bg-gray-600 font-bold text-lg"></i>
                    <h1 class="bg-gray-500 px-4 py-2 rounded-tr-md rounded-br-md">Kembali</h1>
                </button>
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
        <div id="notificationAlert" class="flex justify-between items-center border-l-4 border-green-500 bg-green-200 py-4 px-6 rounded-sm">
            <p class="font-semibold opacity-50">
                {{ session('success') }}
            </p>
            <button onclick="document.getElementById('notificationAlert').style.display='none'" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Error Alert -->
        @elseif(session('error'))
        <div id="errorAlert" class="flex justify-between items-center bg-red-200 py-4 px-6 rounded-md transition-all duration-300">
            <p class="font-semibold opacity-75 text-red-800">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </p>
            <button onclick="document.getElementById('errorAlert').style.display='none'" class="text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <div class="flex flex-col space-y-4">
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                    <i class="fa-solid fa-pen-to-square text-base"></i>
                    <h1 class="text-lg font-semibold opacity-75">Edit Data Profile</h1>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>E-Mail</h1>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ auth()->user()->email }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Username</h1>
                                <input
                                    type="text"
                                    name="username"
                                    value="{{ auth()->user()->username }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror">
                                @error('username')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Password <span class="text-xs font-normal text-gray-500">(Biarkan kosong jika tidak ingin mengubah)</span></h1>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Masukkan password baru"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Konfirmasi Password</h1>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Konfirmasi password baru"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Nama Lengkap</h1>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    value="{{ auth()->user()->nama_lengkap }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror">
                                @error('nama_lengkap')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <!-- This div is kept for layout symmetry -->
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <button type="submit" class="flex items-center text-white space-x-2 px-4 py-2 bg-teal-600 rounded-md">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <h1>Simpan</h1>
                        </button>
                        <button type="reset" class="flex items-center text-white space-x-2 px-4 py-2 bg-cyan-400 rounded-md">
                            <i class="fa-solid fa-rotate"></i>
                            <h1>Reset</h1>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script for auto-hiding notifications after 5 seconds -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationAlert = document.getElementById('notificationAlert');
        const errorAlert = document.getElementById('errorAlert');

        if (notificationAlert) {
            setTimeout(function() {
                notificationAlert.classList.add('opacity-0');
                setTimeout(function() {
                    notificationAlert.style.display = 'none';
                }, 300);
            }, 5000); // 5 seconds before starting fade out
        }

        if (errorAlert) {
            setTimeout(function() {
                errorAlert.classList.add('opacity-0');
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 300);
            }, 5000); // 5 seconds before starting fade out
        }
    });
</script>
@endsection