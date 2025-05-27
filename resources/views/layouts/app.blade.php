<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK COPRAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quantico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            background-color: rgb(245, 244, 244);
        }

        .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
            padding: 0.5rem;
        }

        .sidebar-item.active i,
        .sidebar-item.active h1 {
            opacity: 1 !important;
        }

        /* Animation for logout confirmation popup */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }

            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .slide-up {
            animation: slideUp 0.3s ease-out forwards;
        }
    </style>
</head>

<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-1/6 bg-[#FFAE00] px-4 py-6 opacity-[80%] flex flex-col space-y-6 h-screen overflow-y-auto">
            <div class="flex flex-row items-center px-2 space-x-4">
                <div class="text-white text-4xl">
                    <i class="fas fa-database" style="transform: rotate(-20deg);"></i>
                </div>
                <div class="text-lg font-black text-white">
                    SPK COPRAS
                </div>
            </div>
            <div class="flex flex-col border-b-2 border-t-2 border-[#FBCE6D] py-6">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="flex flex-row space-x-2 justify-start items-center text-white text-base group font-bold">
                        <i class="fas fa-house-chimney opacity-25 group-hover:opacity-100"></i>
                        <h1 class="opacity-75 group-hover:opacity-100">Dashboard</h1>
                    </div>
                </a>
            </div>
            <div class="flex flex-col space-y-6">
                <div class="opacity-50 text-white opacity-25 font-bold">
                    <h1 class="text-xs">MASTER DATA</h1>
                </div>
                <div class="flex flex-col space-y-10 font-semibold">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('kriteria.index') }}" class="sidebar-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-cube w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Kriteria</h1>
                        </div>
                    </a>
                    <a href="{{ route('subkriteria.index') }}" class="sidebar-item {{ request()->routeIs('subkriteria.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-cubes w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Sub Kriteria</h1>
                        </div>
                    </a>
                    <a href="{{ route('alternatif.index') }}" class="sidebar-item {{ request()->routeIs('alternatif.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-users w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Alternatif</h1>
                        </div>
                    </a>
                    <a href="{{ route('penilaian.index') }}" class="sidebar-item {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-pen-to-square w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Penilaian</h1>
                        </div>
                    </a>
                    <a href="{{ route('perhitungan.index') }}" class="sidebar-item {{ request()->routeIs('perhitungan.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-calculator w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Perhitungan</h1>
                        </div>
                    </a>
                    @endif
                    <a href="{{ route('hasilakhir.index') }}" class="sidebar-item {{ request()->routeIs('hasilakhir.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-chart-line w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Hasil Akhir</h1>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex flex-col space-y-6 border-b-2 border-t-2 border-[#FBCE6D] py-6">
                <div class="opacity-50 text-white opacity-25 font-bold">
                    <h1 class="text-xs">MASTER USER</h1>
                </div>
                <div class="flex flex-col space-y-10 font-semibold">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('user.index') }}" class="sidebar-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-users-gear w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data User</h1>
                        </div>
                    </a>
                    @endif
                    <a href="{{ route('profile.index') }}" class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-4 text-white group">
                            <i class="fas fa-user w-6 text-center opacity-25 group-hover:opacity-100"></i>
                            <h1 class="opacity-75 group-hover:opacity-100">Data Profile</h1>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex flex-col space-y-6">
                <button type="button" id="logoutButton" class="w-full">
                    <div class="flex items-center space-x-4 text-white group">
                        <i class="fas fa-sign-out-alt w-6 text-center opacity-25 group-hover:opacity-100"></i>
                        <h1 class="opacity-75 group-hover:opacity-100">Logout</h1>
                    </div>
                </button>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <div class="w-full h-20 bg-white flex items-center justify-end space-x-2 pr-8 shadow-lg">
                <!-- User profile dropdown -->
                <div class="relative inline-block">
                    <div class="flex items-center space-x-2 cursor-pointer" id="profileDropdown">
                        <div class="flex items-center space-x-2">
                            <h1 class="text-gray-500 font-bold text-base">{{ auth()->user()->nama_lengkap }}</h1>
                        </div>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-base"></i>
                        </div>
                    </div>
                    <div class="hidden absolute right-0 mt-7 bg-white rounded-md shadow-lg py-1 w-48 z-10" id="profileDropdownContent">
                        <a href="{{ route('profile.index') }}" class="flex items-center px-6 py-3 text-base text-gray-700 hover:bg-gray-100 border-b-2 border-gray-100">
                            <i class="fas fa-user-circle mr-2 font-bold text-gray-500"></i>
                            <span>Profile</span>
                        </a>
                        <button type="button" id="dropdownLogoutButton" class="flex items-center w-full text-left px-6 py-3 text-base text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2 font-bold text-gray-500"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dynamic Content Area -->
            <div class="flex-1 overflow-y-auto p-8">
                <div id="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Logout confirmation popup -->
    <div id="logoutConfirmation" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-start justify-center z-50">
        <div class="bg-white rounded-sm shadow-xl mt-16 max-w-lg w-full transform -translate-y-full opacity-0">
            <div class="px-6 py-4 space-y-6">
                <div class="flex justify-between items-center">
                    <h1 class="font-semibold opacity-50 text-xl">Ready to Leave</h1>
                    <button type="button" id="closeLogoutPopup" class="text-lg font-bold opacity-60 hover:opacity-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="border-t border-b py-6">
                    <h1 class="text-base font-semibold opacity-50">Apakah Anda yakin ingin keluar dari sistem?</h1>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancelLogout" class="flex justify-center items-center py-2 w-24 bg-[#FFAE00] rounded-sm hover:bg-[#F4A600] space-x-2">
                        <span class="text-white font-bold">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                        <span class="text-white font-semibold">
                            <h1>Cancel</h1>
                        </span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex justify-center items-center py-2 w-24 bg-red-600 hover:bg-red-700 rounded-sm space-x-2">
                            <span class="text-white font-bold">
                                <i class="fa-solid fa-sign-out-alt"></i>
                            </span>
                            <span class="text-white font-semibold">
                                <h1>Logout</h1>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- JavaScript for dropdown and logout confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle dropdown when clicking on the profile
            const profileDropdown = document.getElementById('profileDropdown');
            const dropdownContent = document.getElementById('profileDropdownContent');

            profileDropdown.addEventListener('click', function() {
                dropdownContent.classList.toggle('hidden');
            });

            // Close the dropdown when clicking outside
            window.addEventListener('click', function(event) {
                if (!profileDropdown.contains(event.target)) {
                    if (!dropdownContent.classList.contains('hidden')) {
                        dropdownContent.classList.add('hidden');
                    }
                }
            });

            // Logout confirmation popup
            const logoutButton = document.getElementById('logoutButton');
            const dropdownLogoutButton = document.getElementById('dropdownLogoutButton');
            const logoutConfirmation = document.getElementById('logoutConfirmation');
            const logoutPopup = logoutConfirmation.querySelector('.bg-white');
            const closeLogoutPopup = document.getElementById('closeLogoutPopup');
            const cancelLogout = document.getElementById('cancelLogout');

            function openLogoutPopup() {
                logoutConfirmation.classList.remove('hidden');
                setTimeout(() => {
                    logoutPopup.classList.add('slide-down');
                }, 10);
            }

            function closeLogoutPopupHandler() {
                logoutPopup.classList.remove('slide-down');
                logoutPopup.classList.add('slide-up');
                setTimeout(() => {
                    logoutConfirmation.classList.add('hidden');
                    logoutPopup.classList.remove('slide-up');
                }, 300);
            }

            logoutButton.addEventListener('click', openLogoutPopup);
            dropdownLogoutButton.addEventListener('click', function() {
                dropdownContent.classList.add('hidden');
                openLogoutPopup();
            });

            closeLogoutPopup.addEventListener('click', closeLogoutPopupHandler);
            cancelLogout.addEventListener('click', closeLogoutPopupHandler);

            // Close popup when clicking outside
            logoutConfirmation.addEventListener('click', function(event) {
                if (event.target === logoutConfirmation) {
                    closeLogoutPopupHandler();
                }
            });
        });
    </script>
</body>

</html>