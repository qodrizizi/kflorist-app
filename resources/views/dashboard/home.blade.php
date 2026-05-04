@extends('layouts.app')
@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('title', 'Dashboard Home')

@section('content')
<div class="mb-6 md:mb-8">
<h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-slate-200 mb-2">
Selamat Datang Kembali, {{ Auth::user()->name ?? 'John Doe' }} 👋
</h2>
<p class="text-sm md:text-base text-gray-600 dark:text-slate-400 font-medium">Kelola kebun bonsai Anda dengan mudah dan efisien hari ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">
    <div class="stat-card bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md dark:shadow-xl border-l-4 border-bonsai-500 dark:border-bonsai-400 hover:shadow-xl group transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-slate-500 mb-1 font-medium uppercase tracking-wide">Total Bonsai</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-slate-200 mb-0.5">{{ $totalBonsai ?? 24 }}</p>
                <div class="flex items-center text-xs text-bonsai-600 dark:text-bonsai-400 font-semibold">
                    <span class="mr-1">↗</span>
                    <span>+2 minggu ini</span>
                </div>
            </div>
            <div class="bg-gradient-to-br from-bonsai-50 to-bonsai-100 dark:from-bonsai-900 dark:to-bonsai-800 p-3 md:p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <span class="text-2xl md:text-3xl">🌳</span>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md dark:shadow-xl border-l-4 border-blue-500 dark:border-blue-400 hover:shadow-xl group transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-slate-500 mb-1 font-medium uppercase tracking-wide">Perlu Penyiraman</p>
                <p class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-slate-200 mb-0.5">{{ $needWatering ?? 7 }}</p>
                <div class="flex items-center text-xs text-blue-600 dark:text-blue-400 font-semibold">
                    <span class="mr-1">🚨</span>
                    <span>Segera siram</span>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 p-3 md:p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <span class="text-2xl md:text-3xl">💧</span>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md dark:shadow-xl border-l-4 border-amber-500 dark:border-amber-400 hover:shadow-xl group transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs md:text-sm text-gray-500 dark:text-slate-500 mb-1 font-medium uppercase tracking-wide">Keuntungan Bulan Ini</p>
                <p class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-slate-200 mb-0.5">{{ $monthlyProfit ?? 'Rp 2.500.000' }}</p>
                <div class="flex items-center text-xs text-amber-600 dark:text-amber-400 font-semibold">
                    <span class="mr-1">📈</span>
                    <span>+15% dari bulan lalu</span>
                </div>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900 dark:to-amber-800 p-3 md:p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                <span class="text-2xl md:text-3xl">💰</span>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes grow-y {
        from { transform: scaleY(0); }
        to { transform: scaleY(1); }
    }
    @keyframes grow-x {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }
    .animate-grow-y {
        animation: grow-y 0.6s ease-out forwards;
        transform-origin: bottom;
    }
    .animate-grow-x {
        animation: grow-x 0.6s ease-out forwards;
        transform-origin: left;
    }
</style>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 md:mb-12">
    <div class="bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl shadow-md dark:shadow-xl p-4 md:p-6 border border-white/20 dark:border-dark-700/50">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-slate-200 mb-4 flex items-center">
            <span class="text-xl md:text-2xl mr-2">📊</span>
            Ringkasan Keuangan
        </h3>
        <div class="flex justify-between items-end h-48 md:h-64 pt-4 border-b border-gray-200 dark:border-dark-700">
            <div class="flex-1 flex flex-col items-center mx-2">
                <div class="w-8 md:w-10 bg-bonsai-500 rounded-t-full animate-grow-y" style="height: 85%; animation-delay: 0.1s;"></div>
                <span class="text-xs mt-2 text-gray-500 dark:text-slate-400">Pemasukan</span>
            </div>
            <div class="flex-1 flex flex-col items-center mx-2">
                <div class="w-8 md:w-10 bg-red-400 rounded-t-full animate-grow-y" style="height: 50%; animation-delay: 0.2s;"></div>
                <span class="text-xs mt-2 text-gray-500 dark:text-slate-400">Pengeluaran</span>
            </div>
        </div>
        <div class="mt-4 flex justify-between text-xs text-gray-500 dark:text-slate-400 font-medium">
            <span>Rp 1.500.000</span>
            <span>Rp 800.000</span>
        </div>
    </div>

    <div class="bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl shadow-md dark:shadow-xl p-4 md:p-6 border border-white/20 dark:border-dark-700/50">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-slate-200 mb-4 flex items-center">
            <span class="text-xl md:text-2xl mr-2">📈</span>
            Penjualan per Kategori
        </h3>
        <div class="space-y-4 pt-2">
            <div class="flex items-center">
                <span class="w-24 text-sm text-gray-600 dark:text-slate-400 font-medium">Juniper</span>
                <div class="flex-1 h-3 rounded-full bg-bonsai-500 animate-grow-x" style="width: 80%; animation-delay: 0.1s;"></div>
                <span class="ml-2 text-sm text-gray-500 dark:text-slate-500">80%</span>
            </div>
            <div class="flex items-center">
                <span class="w-24 text-sm text-gray-600 dark:text-slate-400 font-medium">Ficus</span>
                <div class="flex-1 h-3 rounded-full bg-blue-500 animate-grow-x" style="width: 65%; animation-delay: 0.2s;"></div>
                <span class="ml-2 text-sm text-gray-500 dark:text-slate-500">65%</span>
            </div>
            <div class="flex items-center">
                <span class="w-24 text-sm text-gray-600 dark:text-slate-400 font-medium">Pine</span>
                <div class="flex-1 h-3 rounded-full bg-amber-500 animate-grow-x" style="width: 50%; animation-delay: 0.3s;"></div>
                <span class="ml-2 text-sm text-gray-500 dark:text-slate-500">50%</span>
            </div>
            <div class="flex items-center">
                <span class="w-24 text-sm text-gray-600 dark:text-slate-400 font-medium">Maple</span>
                <div class="flex-1 h-3 rounded-full bg-purple-500 animate-grow-x" style="width: 30%; animation-delay: 0.4s;"></div>
                <span class="ml-2 text-sm text-gray-500 dark:text-slate-500">30%</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 md:mb-12">
    <div class="bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl shadow-md dark:shadow-xl p-4 md:p-6 border border-white/20 dark:border-dark-700/50">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-slate-200 mb-4 flex items-center">
            <span class="text-xl md:text-2xl mr-2">📋</span>
            Aktivitas Terbaru
        </h3>
        <div class="space-y-3">
            @forelse($recentActivities ?? [] as $activity)
                <div class="flex items-center p-3 bg-gray-50 dark:bg-dark-700 rounded-lg">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-{{ $activity['color'] ?? 'bonsai' }}-100 rounded-full flex items-center justify-center mr-3">
                        <span>{{ $activity['icon'] ?? '🌱' }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-slate-200">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">{{ $activity['time'] }}</p>
                    </div>
                </div>
            @empty
                <div class="flex items-center p-3 bg-gray-50 dark:bg-dark-700 rounded-lg">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-bonsai-50 dark:bg-bonsai-900 rounded-full flex items-center justify-center mr-3">
                        <span>🌱</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-slate-200">Bonsai Juniper ditambahkan</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">2 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-gray-50 dark:bg-dark-700 rounded-lg">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-50 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                        <span>💧</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-slate-200">Penyiraman 5 bonsai selesai</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">5 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-gray-50 dark:bg-dark-700 rounded-lg">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-amber-50 dark:bg-amber-900 rounded-full flex items-center justify-center mr-3">
                        <span>💰</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800 dark:text-slate-200">Penjualan Bonsai Pine - Rp 500.000</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400">1 hari yang lalu</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white/80 dark:bg-dark-800/80 backdrop-blur-sm rounded-xl shadow-md dark:shadow-xl p-4 md:p-6 border border-white/20 dark:border-dark-700/50">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-slate-200 mb-4 flex items-center">
            <span class="text-xl md:text-2xl mr-2">⚡</span>
            Aksi Cepat
        </h3>
        <div class="grid grid-cols-2 gap-3 md:gap-4">
            <button class="bg-gradient-to-r from-bonsai-500 to-bonsai-600 dark:from-bonsai-700 dark:to-bonsai-800 text-white p-3 rounded-lg hover:from-bonsai-600 hover:to-bonsai-700 dark:hover:from-bonsai-800 dark:hover:to-bonsai-900 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <span class="text-xl md:text-2xl mb-1 block">🌱</span>
                <span class="text-xs md:text-sm font-medium">Tambah Bonsai</span>
            </button>
            <button class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-700 dark:to-blue-800 text-white p-3 rounded-lg hover:from-blue-600 hover:to-blue-700 dark:hover:from-blue-800 dark:hover:to-blue-900 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <span class="text-xl md:text-2xl mb-1 block">💧</span>
                <span class="text-xs md:text-sm font-medium">Jadwal Siram</span>
            </button>
            <button class="bg-gradient-to-r from-purple-500 to-purple-600 dark:from-purple-700 dark:to-purple-800 text-white p-3 rounded-lg hover:from-purple-600 hover:to-purple-700 dark:hover:from-purple-800 dark:hover:to-purple-900 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <span class="text-xl md:text-2xl mb-1 block">📊</span>
                <span class="text-xs md:text-sm font-medium">Lihat Laporan</span>
            </button>  
            <button class="bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-700 dark:to-amber-800 text-white p-3 rounded-lg hover:from-amber-600 hover:to-amber-700 dark:hover:from-amber-800 dark:hover:to-amber-900 transition-all duration-300 hover:scale-105 hover:shadow-lg">
                <span class="text-xl md:text-2xl mb-1 block">💰</span>
                <span class="text-xs md:text-sm font-medium">Catat Penjualan</span>
            </button>
        </div>
    </div>
</div>

<div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-dark-800 dark:to-dark-900 rounded-xl p-4 md:p-6 border border-blue-200 dark:border-dark-700">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-slate-200 flex items-center">
            <span class="text-xl md:text-2xl mr-2">🌤️</span>
            Cuaca Hari Ini & Tips Perawatan
        </h3>
        <div class="text-right">
            <p class="text-xl md:text-2xl font-bold text-gray-800 dark:text-slate-200">{{ $weather['temperature'] ?? '28°C' }}</p>
            <p class="text-xs md:text-sm text-gray-600 dark:text-slate-400">{{ $weather['condition'] ?? 'Cerah berawan' }}</p>
        </div>
    </div>
    <div class="bg-white/70 dark:bg-dark-700/70 backdrop-blur-sm rounded-lg p-3 md:p-4">
        <p class="text-sm text-gray-700 dark:text-slate-300">
            <span class="font-semibold">💡 Tips hari ini:</span> 
            {{ $dailyTip ?? 'Cuaca cerah cocok untuk memindahkan bonsai ke area dengan sinar matahari pagi. Pastikan penyiraman dilakukan pagi hari sebelum pukul 9 AM.' }}
        </p>
    </div>
</div>

@endsection