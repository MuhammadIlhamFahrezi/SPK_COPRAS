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
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                    <i class="fa-solid fa-eye text-base"></i>
                    <h1 class="text-lg font-semibold opacity-75">Detail Data User</h1>
                </div>
                <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                    <!-- Tabel Detail User -->
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2 w-1/3 font-bold opacity-75 h-12 text-gray-700 bg-gray-100 whitespace-nowrap">Nama Lengkap</td>
                                <td class="border px-4 py-2 font-semibold opacity-50">{{ $user->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 w-1/3 font-bold opacity-75 h-12 text-gray-700 bg-gray-100 whitespace-nowrap">Username</td>
                                <td class="border px-4 py-2 font-semibold opacity-50">{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 w-1/3 font-bold opacity-75 h-12 text-gray-700 bg-gray-100 whitespace-nowrap">E-Mail</td>
                                <td class="border px-4 py-2 font-semibold opacity-50">{{ $user->email }}</td>
                            </tr>

                            <tr>
                                <td class="border px-4 py-2 w-1/3 font-bold opacity-75 h-12 text-gray-700 bg-gray-100 whitespace-nowrap">Role</td>
                                <td class="border px-4 py-2 font-semibold opacity-50">
                                    <span class="px-2 py-1 rounded text-xs {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2 w-1/3 font-bold opacity-75 h-12 text-gray-700 bg-gray-100 whitespace-nowrap">Status</td>
                                <td class="border px-4 py-2 font-semibold opacity-50">
                                    <span class="px-2 py-1 rounded text-xs {{ $user->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                    <a href="{{ route('user.edit', $user->id) }}" class="flex items-center text-white space-x-2 px-4 py-2 bg-teal-600 rounded-md">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <h1>Edit</h1>
                    </a>
                    <a href="{{ route('user.index') }}" class="flex items-center text-white space-x-2 px-4 py-2 bg-cyan-400 rounded-md">
                        <i class="fa-solid fa-list"></i>
                        <h1>Daftar User</h1>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection