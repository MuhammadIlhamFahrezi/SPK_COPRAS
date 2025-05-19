<!-- views/hasilakhir/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-chart-line text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Hasil Akhir Perangkingan</h1>
                </div>
            </div>
            <div>
                <a href="{{ route('perhitungan.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded shadow flex items-center space-x-2">
                    <i class="fas fa-calculator"></i>
                    <span>Lihat Detail Perhitungan</span>
                </a>
            </div>
        </div>

        @if($noData)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
            <p>{{ $message }}</p>
        </div>
        @else
        <div class="flex flex-col space-y-8">
            <!-- Hasil Akhir Perangkingan -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Hasil Akhir Perangkingan</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-16 px-4 py-2 border">Peringkat</th>
                                    <th class="w-16 px-4 py-2 border">Kode</th>
                                    <th class="px-4 py-2 border">Alternatif</th>
                                    <th class="w-48 px-4 py-2 border">Nilai Utilitas (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($finalRanking as $index => $row)
                                <tr>
                                    <td class="px-4 py-2 border font-bold opacity-75">
                                        {{ $row['rank'] }}
                                    </td>
                                    <td class="px-4 py-2 border opacity-75">{{ $row['kode_alternatif'] }}</td>
                                    <td class="px-4 py-2 border opacity-75 text-left">{{ $row['nama_alternatif'] }}</td>
                                    <td class="px-4 py-2 border font-semibold opacity-75">
                                        {{ $row['nilai_u'] }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection