@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-cube text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Data Kriteria</h1>
                </div>
            </div>
            <!-- KEMBALI KE INDEX -->
            <a href="{{ route('kriteria.index') }}">
                <button class="flex flex-row text-white rounded-md">
                    <i class="fa-solid fa-angle-left rounded-tl-md rounded-bl-md px-4 py-2 bg-gray-600 font-bold text-lg"></i>
                    <h1 class="bg-gray-500 px-4 py-2 rounded-tr-md rounded-br-md">Kembali</h1>
                </button>
            </a>
        </div>
        <div class="flex flex-col space-y-4">
            <form action="{{ route('kriteria.store') }}" method="POST">
                @csrf
                <div class="w-full h-full shadow-xl">
                    <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <i class="fa-solid fa-pen-to-square text-base"></i>
                        <h1 class="text-lg font-semibold opacity-75">Tambah Data Kriteria</h1>
                    </div>
                    <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Kode Kriteria</h1>
                                <input
                                    type="text"
                                    name="kode"
                                    value="{{ old('kode') }}"
                                    class="w-full border @error('kode') border-red-500 @else border-gray-400 @enderror rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('kode')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Nama Kriteria</h1>
                                <input
                                    type="text"
                                    name="nama"
                                    value="{{ old('nama') }}"
                                    class="w-full border @error('nama') border-red-500 @else border-gray-400 @enderror rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('nama')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex items-center justify-between space-x-8">
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Bobot Kriteria</h1>
                                <input
                                    type="number"
                                    name="bobot"
                                    value="{{ old('bobot') }}"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    class="w-full border @error('bobot') border-red-500 @else border-gray-400 @enderror rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('bobot')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                                <h1>Jenis Kriteria</h1>
                                <select
                                    name="jenis"
                                    class="w-full border @error('jenis') border-red-500 @else border-gray-400 @enderror rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>-- Pilih --</option>
                                    <option value="Benefit" {{ old('jenis') == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                                    <option value="Cost" {{ old('jenis') == 'Cost' ? 'selected' : '' }}>Cost</option>
                                </select>
                                @error('jenis')
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