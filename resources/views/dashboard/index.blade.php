@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <i class="fas fa-house-chimney text-3xl opacity-60"></i>
            <h1 class="text-3xl opacity-50">Dashboard</h1>
        </div>
        <div id="welcomeAlert" class="flex justify-between items-center border-l-4 border-green-500 bg-green-200 py-4 px-6 rounded-sm">
            <p class="font-semibold opacity-50">
                Selamat Datang <span class="font-bold">{{ auth()->user()->nama_lengkap }}!</span>.
                Silakan gunakan menu di sidebar untuk mengakses fitur yang tersedia.
            </p>
            <i class="fa-solid fa-xmark opacity-50 cursor-pointer" onclick="document.getElementById('welcomeAlert').remove()"></i>
        </div>
    </div>

    <div class="flex flex-col space-y-8">
        @if(auth()->user()->isAdmin())
        <!-- Menu untuk Admin -->
        <div class="flex flex-row justify-between">
            <a href="{{ route('kriteria.index') }}" class="sidebar-item {{ request()->routeIs('kriteria.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-cyan-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Kriteria</h1>
                    <i class="fas fa-cube text-3xl text-center opacity-25"></i>
                </div>
            </a>
            <a href="{{ route('subkriteria.index') }}" class="sidebar-item {{ request()->routeIs('subkriteria.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-blue-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Sub Kriteria</h1>
                    <i class="fas fa-cubes text-3xl text-center opacity-25"></i>
                </div>
            </a>
            <a href="{{ route('alternatif.index') }}" class="sidebar-item {{ request()->routeIs('alternatif.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-green-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Alternatif</h1>
                    <i class="fas fa-users text-3xl text-center opacity-25"></i>
                </div>
            </a>
        </div>
        <div class="flex flex-row justify-between">
            <a href="{{ route('penilaian.index') }}" class="sidebar-item {{ request()->routeIs('penilaian.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-gray-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Penilaian</h1>
                    <i class="fas fa-pen-to-square text-3xl text-center opacity-25"></i>
                </div>
            </a>
            <a href="{{ route('perhitungan.index') }}" class="sidebar-item {{ request()->routeIs('perhitungan.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-orange-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Perhitungan</h1>
                    <i class="fas fa-calculator text-3xl text-center opacity-25"></i>
                </div>
            </a>
            <a href="{{ route('hasilakhir.index') }}" class="sidebar-item {{ request()->routeIs('hasilakhir.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-red-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Hasil Akhir</h1>
                    <i class="fas fa-chart-line text-3xl text-center opacity-25"></i>
                </div>
            </a>
        </div>
        @else
        <!-- Menu untuk User -->
        <div class="flex flex-row justify-between">
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-red-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Dashboard</h1>
                    <i class="fas fa-house-chimney text-3xl text-center opacity-25"></i>
                </div>
            </a>
            <a href="{{ route('hasilakhir.index') }}" class="sidebar-item {{ request()->routeIs('hasilakhir.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-red-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Data Hasil Akhir</h1>
                    <i class="fas fa-chart-line text-3xl text-center opacity-25"></i>
                </div>
            </a>
            <a href="{{ route('profile.index') }}" class="sidebar-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <div class="flex justify-between items-center shadow-xl w-96 px-6 py-8 border-l-4 border-blue-400 bg-white rounded-md">
                    <h1 class="text-xl font-bold opacity-50">Profile</h1>
                    <i class="fas fa-user text-3xl text-center opacity-25"></i>
                </div>
            </a>
        </div>
        @endif
    </div>
</div>

@endsection