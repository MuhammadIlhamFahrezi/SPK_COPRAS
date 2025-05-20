<!-- views/perhitungan/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calculator text-3xl opacity-60"></i>
                    <h1 class="text-3xl opacity-50">Data Perhitungan</h1>
                </div>
            </div>
        </div>

        @if($noData)
        <div class="lex justify-between items-center border-l-4 border-green-500 bg-green-200 py-4 px-6 rounded-sm" role="alert">
            <p class="font-semibold opacity-50">{{ $message }}</p>
        </div>
        @else
        <div class="flex flex-col space-y-8">
            <!-- Membuat MATRIKS KEPUTUSAN -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Matriks Keputusan</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-4 py-2 border">{{ $kriteria->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriksKeputusan['matriks'] as $index => $alternatif)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $alternatif['nama_alternatif'] }}</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-2 border opacity-50">{{ $alternatif['nilai'][$kriteria->id_kriteria] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="font-bold bg-gray-100">
                                    <td colspan="2" class="px-4 py-2 border opacity-50">Total</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-2 border opacity-50">{{ $matriksKeputusan['total'][$kriteria->id_kriteria] }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Normalisasi Matriks -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Normalisasi Matriks</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-4 py-2 border">{{ $kriteria->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($normalisasiMatriks as $index => $alternatif)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $alternatif['nama_alternatif'] }}</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-2 border opacity-50">{{ $alternatif['nilai'][$kriteria->id_kriteria] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bobot Kriteria -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Bobot Kriteria</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-4 py-2 border">{{ $kriteria->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="font-semibold">
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-2 border opacity-50">{{ $bobotKriteria[$kriteria->id_kriteria] }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Matriks Ternormalisasi Terbobot -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Matriks Ternormalisasi Terbobot</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    @foreach($kriterias as $kriteria)
                                    <th class="px-4 py-2 border">{{ $kriteria->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriksTernormalisasiTerbobot as $index => $alternatif)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $alternatif['nama_alternatif'] }}</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-2 border opacity-50">{{ $alternatif['nilai'][$kriteria->id_kriteria] }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr class="font-bold bg-gray-100">
                                    <td colspan="2" class="px-4 py-2 border opacity-50">Jenis</td>
                                    @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-2 border opacity-50">{{ strtolower($kriteria->jenis) == 'benefit' ? 'MAX' : 'MIN' }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Nilai S+ (Benefit) -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Nilai S+ (MAX)</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    <th class="px-4 py-2 border">Nilai S+</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sPlus as $index => $row)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $row['nama_alternatif'] }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $row['nilai'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Nilai S- (Cost) -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Nilai S- (MIN)</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    <th class="px-4 py-2 border">Nilai S-</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sMinusData['sMinus'] as $index => $row)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $row['nama_alternatif'] }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $row['nilai'] }}</td>
                                </tr>
                                @endforeach
                                <tr class="font-bold bg-gray-100">
                                    <td colspan="2" class="px-4 py-2 border opacity-50">Total</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $sMinusData['total'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bobot Relatif Tiap Kriteria -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Bobot Relatif Tiap Kriteria</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    <th class="px-4 py-2 border">1/S-</th>
                                    <th class="px-4 py-2 border">S- * Total 1/S-</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relativeWeightData['weights'] as $index => $row)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $row['nama_alternatif'] }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $row['inverse'] }}</td>
                                    <td class="px-4 py-2 border opacity-50">
                                        @php
                                        $sMinusValue = $sMinusData['sMinus'][$index]['nilai'];
                                        echo round($sMinusValue * $relativeWeightData['sumInverse'], 4);
                                        @endphp
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="font-bold bg-gray-100">
                                    <td colspan="2" class="px-4 py-2 border opacity-50">Total</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $relativeWeightData['sumInverse'] }}</td>
                                    <td class="px-4 py-2 border opacity-50"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Nilai Signifikasi Prioritas Relatif (Q) -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Nilai Signifikasi Prioritas Relatif (Qi)</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    <th class="px-4 py-2 border">Nilai Qi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relativeWeightData['weights'] as $index => $row)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50 text-left">{{ $row['nama_alternatif'] }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $row['nilai'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between items-center bg-green-200 py-4 px-6 rounded-md">
                        <p class="font-semibold opacity-75">
                            Nilai Max Qi = {{ $utilityDegreeData['maxQ'] }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Nilai Utilitas Kuantitatif -->
            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Nilai Utilitas Kuantitatif (Ui)</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="w-12 px-4 py-2 border">No</th>
                                    <th class="w-64 px-4 py-2 border">Alternatif</th>
                                    <th class="px-4 py-2 border">Nilai Ui (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                // Clone the array without sorting it to maintain original order
                                $utilityDegreesUnsorted = [];
                                foreach($utilityDegreeData['utility'] as $item) {
                                $utilityDegreesUnsorted[] = $item;
                                }

                                // Sort by id_alternatif to match with original ordering
                                usort($utilityDegreesUnsorted, function ($a, $b) {
                                return $a['id_alternatif'] <=> $b['id_alternatif'];
                                    });
                                    @endphp

                                    @foreach($utilityDegreesUnsorted as $index => $row)
                                    <tr class="font-semibold">
                                        <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border opacity-50 text-left">{{ $row['nama_alternatif'] }}</td>
                                        <td class="px-4 py-2 border opacity-50">{{ $row['nilai_u'] }}</td>
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