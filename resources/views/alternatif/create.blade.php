@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Data Alternatif</h1>
                </div>
            </div>
            <!-- KEMBALI KE INDEX -->
            <a href="{{ route('alternatif.index') }}">
                <button class="flex flex-row text-white rounded-md">
                    <i class="fa-solid fa-angle-left rounded-tl-md rounded-bl-md px-4 py-2 bg-gray-600 font-bold text-lg"></i>
                    <h1 class="bg-gray-500 px-4 py-2 rounded-tr-md rounded-br-md">Kembali</h1>
                </button>
            </a>
        </div>
        <div class="flex flex-col space-y-4">
            <form action="{{ route('alternatif.store') }}" method="POST">
                @csrf
                <div class="w-full h-full shadow-xl">
                    <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <i class="fa-solid fa-pen-to-square text-base"></i>
                        <h1 class="text-lg font-semibold opacity-75">Tambah Data Alternatif</h1>
                    </div>
                    <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Kode Alternatif</h1>
                                <input
                                    type="text"
                                    name="kode_alternatif"
                                    value="{{ old('kode_alternatif') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('kode_alternatif')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Nama Alternatif</h1>
                                <input
                                    type="text"
                                    name="nama_alternatif"
                                    value="{{ old('nama_alternatif') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('nama_alternatif')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
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