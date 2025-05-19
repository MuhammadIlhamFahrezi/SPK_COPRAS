@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-pen-to-square text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Data Penilaian</h1>
                </div>
            </div>
            <!-- KEMBALI KE INDEX -->
            <a href="{{ route('penilaian.index') }}">
                <button class="flex flex-row text-white rounded-md">
                    <i class="fa-solid fa-angle-left rounded-tl-md rounded-bl-md px-4 py-2 bg-gray-600 font-bold text-lg"></i>
                    <h1 class="bg-gray-500 px-4 py-2 rounded-tr-md rounded-br-md">Kembali</h1>
                </button>
            </a>
        </div>
        <div class="flex flex-col space-y-4">
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                    <i class="fa-solid fa-pen-to-square text-base"></i>
                    <h1 class="text-lg font-semibold opacity-75">Edit Penilaian {{ $alternatif->nama_alternatif }}</h1>
                </div>
                <form action="{{ route('penilaian.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_alternatif" value="{{ $alternatif->id_alternatif }}">
                    <div class="flex flex-col px-6 py-4 bg-white space-y-8">
                        @foreach($kriterias as $kriteria)
                        <div class="flex flex-col font-bold opacity-50 space-y-4 w-full">
                            <h1>{{ $kriteria->nama }}</h1>
                            <select name="nilai[{{ $kriteria->id_kriteria }}]" class="w-full border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="" disabled>--Pilih--</option>
                                @foreach($kriteria->subkriterias as $subkriteria)
                                <option value="{{ $subkriteria->id_subkriteria }}" {{ isset($kriteria->selected_subkriteria) && $kriteria->selected_subkriteria == $subkriteria->id_subkriteria ? 'selected' : '' }}>
                                    {{ $subkriteria->nama_subkriteria }} (Nilai: {{ $subkriteria->nilai }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
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
@endsection