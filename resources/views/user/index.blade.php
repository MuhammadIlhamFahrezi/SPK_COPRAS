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
            <a href="{{ route('user.create') }}">
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
                    <h1 class="text-lg font-semibold opacity-75">Daftar Data User</h1>
                </div>
                <div class="px-6 py-6 space-y-4 bg-white">
                    <div class="flex justify-between">
                        <form action="{{ route('user.index') }}" method="GET" class="flex items-center space-x-2 font-semibold opacity-50">
                            <!-- ENTRIES -->
                            <h1>Show</h1>
                            <select name="entries" id="entries" onchange="this.form.submit()" class="border border-gray-400 rounded px-2 py-1 text-sm">
                                @foreach([5, 10, 15, 20] as $value)
                                <option value="{{ $value }}" {{ request('entries', 10) == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <h1>entries</h1>
                        </form>

                        <form action="{{ route('user.index') }}" method="GET" class="flex items-center space-x-2 font-semibold opacity-50">
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
                                    <th class="px-4 py-2 border">Nama Lengkap</th>
                                    <th class="px-4 py-2 border">E-Mail</th>
                                    <th class="px-4 py-2 border">Role</th>
                                    <th class="px-4 py-2 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                <tr class="font-semibold">
                                    <td class="px-4 py-2 border opacity-50">{{ $index + $users->firstItem() }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $user->nama_lengkap }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border opacity-50">{{ ucfirst($user->role) }}</td>
                                    <td class="px-4 py-2 border">
                                        <!-- VIEW DATA  -->
                                        <a href="{{ route('user.show', $user->id_user) }}">
                                            <button class="bg-blue-700 w-8 h-8 rounded-sm">
                                                <i class="fas fa-eye text-base text-center text-white"></i>
                                            </button>
                                        </a>
                                        <!-- EDIT DATA -->
                                        <a href="{{ route('user.edit', $user->id_user) }}">
                                            <button class="bg-[#FFAE00] w-8 h-8 rounded-sm">
                                                <i class="fas fa-pen-to-square text-base text-center text-white"></i>
                                            </button>
                                        </a>
                                        <!-- HAPUS DATA -->
                                        <button class="bg-red-500 w-8 h-8 rounded-sm" onclick="confirmDelete('{{ $user->id_user }}', '{{ $user->nama_lengkap }}')">
                                            <i class="fas fa-trash text-base text-center text-white"></i>
                                        </button>
                                        <form id="delete-form-{{ $user->id_user }}" action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border text-center">Tidak ada data user</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between font-semibold ">
                        <h1 class="opacity-50">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
                        </h1>
                        <!-- PAGINATION -->
                        <div class="flex">
                            {{ $users->appends(request()->query())->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Dialog -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-md shadow-lg max-w-lg w-full space-y-6">
        <h2 class="font-semibold opacity-50 text-xl">Konfirmasi Penghapusan</h2>
        <div class="border-t border-b py-6">
            <p class="text-gray-600">Apakah Anda yakin ingin menghapus user <span id="deleteItemName" class="font-bold"></span>?</p>
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="closeDeleteModal()" class="flex justify-center items-center py-2 w-24 rounded-sm border border-[#FFAE00]">
                <span class="text-[#FFAE00] font-semibold">
                    <h1>Cancel</h1>
                </span>
            </button>
            <button type="button" onclick="submitDelete()" class="flex justify-center items-center py-2 w-24 rounded-sm bg-red-600 hover:bg-red-700">
                <span class="text-white font-semibold">
                    <h1>Hapus</h1>
                </span>
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