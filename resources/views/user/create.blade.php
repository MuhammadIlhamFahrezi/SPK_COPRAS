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
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="w-full h-full shadow-xl">
                    <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <i class="fa-solid fa-pen-to-square text-base"></i>
                        <h1 class="text-lg font-semibold opacity-75">Tambah Data User</h1>
                    </div>
                    <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                        <div class="flex items-start justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Nama Lengkap</h1>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                    required>
                                @error('nama_lengkap')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Username</h1>
                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror"
                                    required>
                                @error('username')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-start justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Email</h1>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                    required>
                                @error('email')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Role</h1>
                                <select
                                    name="role"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                                    required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-start justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Password</h1>
                                <input
                                    type="password"
                                    name="password"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                    required>
                                @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Konfirmasi Password</h1>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                                    required>
                                @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-start justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Status</h1>
                                <select
                                    name="status"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror"
                                    required>
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih Status</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <!-- Empty div to maintain layout balance -->
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
                </div>
            </form>
        </div>
    </div>
</div>
@endsection