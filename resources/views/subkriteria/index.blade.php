@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex flex-row items-center">
            <div class="flex items-center space-x-3">
                <i class="fas fa-cubes text-3xl opacity-60"></i>
                <h1 class="text-3xl opacity-50">Data Sub Kriteria</h1>
            </div>
        </div>
        <div class="flex flex-col space-y-4">
            <!-- Notifikasi -->
            @if(session('success'))
            <div id="successAlert" class="flex justify-between items-center bg-green-200 py-4 px-6 rounded-md">
                <p class="font-semibold opacity-50">
                    {{ session('success') }}
                </p>
                <button onclick="document.getElementById('successAlert').style.display='none'" class="text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Loop through each kriteria and its sub-kriteria -->
            @foreach($kriterias as $kriteria)
            <div class="flex flex-col space-y-8">
                <div class="w-full h-full shadow-xl">
                    <div class="flex items-center justify-between px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                        <div class="flex items-center space-x-2">
                            <i class="text-base fa-solid fa-table"></i>
                            <h1 class="text-lg font-semibold opacity-75">{{ $kriteria->nama }} ({{ $kriteria->kode }})</h1>
                        </div>
                        <a href="{{ route('subkriteria.create', ['kriteria_id' => $kriteria->id_kriteria]) }}" class="flex flex-row text-white bg-teal-600 px-4 py-2 space-x-2 rounded-md">
                            <i class="fa-solid fa-plus font-bold text-lg"></i>
                            <h1>Tambah Data</h1>
                        </a>
                    </div>
                    <div class="px-6 py-6 space-y-4 bg-white">
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">Nama Sub Kriteria</th>
                                    <th class="px-4 py-2 border">Nilai</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kriteria->subkriterias as $index => $subkriteria)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $subkriteria->nama_subkriteria }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $subkriteria->nilai }}</td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('subkriteria.edit', $subkriteria->id_subkriteria) }}" class="bg-[#FFAE00] w-8 h-8 rounded-sm inline-flex items-center justify-center">
                                            <i class="fas fa-pen-to-square text-base text-center text-white"></i>
                                        </a>
                                        <button type="button" onclick="showDeleteConfirmation('{{ $subkriteria->id_subkriteria }}')" class="bg-red-500 w-8 h-8 rounded-sm inline-flex items-center justify-center">
                                            <i class="fas fa-trash text-base text-center text-white"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 border text-center opacity-50">Tidak ada data sub kriteria</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan</h2>
        <p class="mb-6">Apakah Anda yakin ingin menghapus data ini? Proses ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="hideDeleteConfirmation()" class="px-4 py-2 bg-gray-300 rounded-md">Batal</button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function showDeleteConfirmation(id) {
        document.getElementById('deleteForm').action = `/subkriteria/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteConfirmation() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Auto-hide success alert after 5 seconds
    setTimeout(function() {
        const alertElement = document.getElementById('successAlert');
        if (alertElement) {
            alertElement.style.display = 'none';
        }
    }, 5000);
</script>
@endsection