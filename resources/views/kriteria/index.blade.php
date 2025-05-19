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
            <a href="{{ route('kriteria.create') }}">
                <button class="flex flex-row text-white bg-teal-600 px-4 py-2 space-x-2 rounded-md">
                    <i class="fa-solid fa-plus font-bold text-lg"></i>
                    <h1>Tambah Data</h1>
                </button>
            </a>
        </div>
        <div class="flex flex-col space-y-4">
            <!-- Notifikasi -->
            @if(session('success'))
            <div id="notificationAlert" class="flex justify-between items-center bg-green-200 py-4 px-6 rounded-md">
                <p class="font-semibold opacity-50">
                    {{ session('success') }}
                </p>
                <button onclick="document.getElementById('notificationAlert').style.display='none'" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <div class="w-full h-full shadow-xl">
                <div class="flex items-center space-x-2 px-6 py-4 bg-[#F8F8F8] text-[#FFAE00] border-b-2 border-black-100 ">
                    <i class="text-base fa-solid fa-table"></i>
                    <h1 class="text-lg font-semibold opacity-75">Daftar Data Kriteria</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="flex justify-between">
                        <form action="{{ route('kriteria.index') }}" method="GET" class="flex items-center space-x-2 font-semibold opacity-50">
                            <!-- ENTRIES -->
                            <h1>Show</h1>
                            <select name="entries" id="entries" onchange="this.form.submit()" class="border border-gray-400 rounded px-2 py-1 text-sm">
                                @foreach([5, 10, 15, 20] as $value)
                                <option value="{{ $value }}" {{ request('entries', 5) == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <h1>entries</h1>
                        </form>

                        <form action="{{ route('kriteria.index') }}" method="GET" class="flex items-center space-x-2 font-semibold opacity-50">
                            <!-- SEARCH -->
                            <h1>Search:</h1>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="border border-gray-400 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div>
                        <table class="w-full border-2 border-gray-300 text-center">
                            <thead>
                                <tr class="bg-[#FFAE00] text-white text-base font-bold">
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">Kode Kriteria</th>
                                    <th class="px-4 py-2 border">Nama Kriteria</th>
                                    <th class="px-4 py-2 border">Bobot</th>
                                    <th class="px-4 py-2 border">Jenis</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kriterias as $index => $kriteria)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + $kriterias->firstItem() }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $kriteria->kode }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $kriteria->nama }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $kriteria->bobot }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $kriteria->jenis }}</td>
                                    <td class="px-4 py-2 border">
                                        <!-- EDIT DATA -->
                                        <a href="{{ route('kriteria.edit', $kriteria->id_kriteria) }}">
                                            <button class="bg-[#FFAE00] w-8 h-8 rounded-sm">
                                                <i class="fas fa-pen-to-square text-base text-center text-white"></i>
                                            </button>
                                        </a>
                                        <!-- HAPUS DATA -->
                                        <button class="bg-red-500 w-8 h-8 rounded-sm" onclick="confirmDelete('{{ $kriteria->id_kriteria }}', '{{ $kriteria->nama }}')">
                                            <i class="fas fa-trash text-base text-center text-white"></i>
                                        </button>
                                        <form id="delete-form-{{ $kriteria->id_kriteria }}" action="{{ route('kriteria.destroy', $kriteria->id_kriteria) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 border text-center">Tidak ada data kriteria</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between font-semibold ">
                        <h1 class="opacity-50">
                            Showing {{ $kriterias->firstItem() ?? 0 }} to {{ $kriterias->lastItem() ?? 0 }} of {{ $kriterias->total() }} entries
                        </h1>
                        <!-- PAGINATION -->
                        <div class="flex">
                            {{ $kriterias->appends(request()->query())->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Dialog -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Penghapusan</h2>
        <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus kriteria <span id="deleteItemName" class="font-bold"></span>?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Batal
            </button>
            <button onclick="submitDelete()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let currentDeleteId = null;

    function confirmDelete(id, name) {
        currentDeleteId = id;
        document.getElementById('deleteItemName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
    }

    function submitDelete() {
        if (currentDeleteId) {
            document.getElementById('delete-form-' + currentDeleteId).submit();
        }
        closeDeleteModal();
    }

    // Close notification after 5 seconds
    setTimeout(function() {
        const notification = document.getElementById('notificationAlert');
        if (notification) {
            notification.style.display = 'none';
        }
    }, 5000);
</script>
@endsection