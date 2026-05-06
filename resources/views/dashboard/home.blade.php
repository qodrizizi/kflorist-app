@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Welcome -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
        Selamat Datang, {{ Auth::user()->name ?? 'Admin' }} 👋
    </h2>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Ringkasan keseluruhan dari toko bonsai Anda hari ini.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="dash-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Bonsai</p>
                <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $totalBonsai }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                <i class="fas fa-seedling text-emerald-500"></i>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-2">
            <span class="text-emerald-500 font-medium">{{ $totalCategories }} kategori</span> tersedia
        </p>
    </div>

    <div class="dash-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Pesanan</p>
                <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $totalOrders }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                <i class="fas fa-shopping-bag text-blue-500"></i>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-2">
            <span class="text-amber-500 font-medium">{{ $ordersPending }} pending</span> perlu diproses
        </p>
    </div>

    <div class="dash-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Pendapatan</p>
                <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                <i class="fas fa-wallet text-amber-500"></i>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-2">
            Dari <span class="text-emerald-500 font-medium">{{ $ordersSelesai }} pesanan</span> selesai
        </p>
    </div>

    <div class="dash-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Perawatan</p>
                <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $perawatanDijadwalkan }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                <i class="fas fa-hand-holding-water text-purple-500"></i>
            </div>
        </div>
        <p class="text-xs text-slate-400 mt-2">
            <span class="text-purple-500 font-medium">Dijadwalkan</span> menunggu aksi
        </p>
    </div>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Bonsai per Kategori -->
    <div class="dash-card p-5">
        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-200 mb-4">
            <i class="fas fa-tags text-emerald-500 mr-2"></i>Bonsai per Kategori
        </h3>
        <div class="space-y-3">
            @foreach($bonsaiPerKategori as $cat)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm
                        @if($cat->color === 'green') bg-emerald-50 text-emerald-500 dark:bg-emerald-900/30
                        @elseif($cat->color === 'orange') bg-orange-50 text-orange-500 dark:bg-orange-900/30
                        @elseif($cat->color === 'purple') bg-purple-50 text-purple-500 dark:bg-purple-900/30
                        @else bg-teal-50 text-teal-500 dark:bg-teal-900/30
                        @endif">
                        <i class="{{ $cat->icon ?? 'fas fa-leaf' }}"></i>
                    </div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $cat->name }}</span>
                </div>
                <span class="text-sm font-bold text-slate-800 dark:text-white">{{ $cat->bonsais_count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="dash-card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                <i class="fas fa-clock text-blue-500 mr-2"></i>Pesanan Terbaru
            </h3>
            <a href="{{ route('dashboard.orders') }}" class="text-xs text-emerald-500 hover:underline font-medium">Lihat Semua →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 uppercase border-b border-slate-100 dark:border-slate-700">
                        <th class="pb-3 font-medium">Kode</th>
                        <th class="pb-3 font-medium">Pelanggan</th>
                        <th class="pb-3 font-medium">Bonsai</th>
                        <th class="pb-3 font-medium">Total</th>
                        <th class="pb-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr class="border-b border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="py-3 font-mono text-xs text-slate-500 dark:text-slate-400">{{ $order->order_code }}</td>
                        <td class="py-3 text-slate-700 dark:text-slate-300">{{ $order->user->name ?? '-' }}</td>
                        <td class="py-3 text-slate-700 dark:text-slate-300">{{ Str::limit($order->bonsai->name ?? '-', 20) }}</td>
                        <td class="py-3 font-medium text-slate-800 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="py-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'diproses' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'dikirim' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                    'selesai' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'dibatalkan' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                ];
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-500' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Perawatan Terbaru -->
    <div class="dash-card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                <i class="fas fa-hand-holding-water text-purple-500 mr-2"></i>Perawatan Terbaru
            </h3>
            <a href="{{ route('dashboard.perawatan') }}" class="text-xs text-emerald-500 hover:underline font-medium">Lihat Semua →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentPerawatan as $p)
            <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm
                    @if($p->jenis_perawatan === 'Penyiraman') bg-blue-50 text-blue-500 dark:bg-blue-900/30
                    @elseif($p->jenis_perawatan === 'Pemupukan') bg-amber-50 text-amber-500 dark:bg-amber-900/30
                    @elseif($p->jenis_perawatan === 'Pemangkasan') bg-emerald-50 text-emerald-500 dark:bg-emerald-900/30
                    @else bg-purple-50 text-purple-500 dark:bg-purple-900/30
                    @endif">
                    @if($p->jenis_perawatan === 'Penyiraman') <i class="fas fa-tint"></i>
                    @elseif($p->jenis_perawatan === 'Pemupukan') <i class="fas fa-flask"></i>
                    @elseif($p->jenis_perawatan === 'Pemangkasan') <i class="fas fa-cut"></i>
                    @else <i class="fas fa-sync"></i>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">{{ $p->bonsai->name ?? '-' }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500">{{ $p->jenis_perawatan }} · {{ $p->tanggal_perawatan->format('d M Y') }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $p->status === 'selesai' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' }}">
                    {{ ucfirst($p->status) }}
                </span>
            </div>
            @empty
            <p class="text-center text-sm text-slate-400 py-4">Belum ada data perawatan</p>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dash-card p-5">
        <h3 class="text-sm font-semibold text-slate-700 dark:text-slate-200 mb-4">
            <i class="fas fa-bolt text-amber-500 mr-2"></i>Aksi Cepat
        </h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('dashboard.manajemen') }}"
               class="flex flex-col items-center gap-2 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition group">
                <i class="fas fa-plus-circle text-xl text-emerald-500 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-300">Tambah Bonsai</span>
            </a>
            <a href="{{ route('dashboard.orders') }}"
               class="flex flex-col items-center gap-2 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition group">
                <i class="fas fa-list-alt text-xl text-blue-500 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-300">Kelola Pesanan</span>
            </a>
            <a href="{{ route('dashboard.perawatan') }}"
               class="flex flex-col items-center gap-2 p-4 rounded-xl bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition group">
                <i class="fas fa-hand-holding-water text-xl text-purple-500 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-300">Perawatan</span>
            </a>
            <a href="{{ route('dashboard.laporan') }}"
               class="flex flex-col items-center gap-2 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 transition group">
                <i class="fas fa-chart-bar text-xl text-amber-500 group-hover:scale-110 transition-transform"></i>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-300">Lihat Laporan</span>
            </a>
        </div>

        <!-- Info Card -->
        <div class="mt-4 p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-users text-lg"></i>
                <h4 class="font-semibold text-sm">Total Pengguna</h4>
            </div>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            <p class="text-xs text-emerald-100 mt-1">Pengguna terdaftar di toko Anda</p>
        </div>
    </div>
</div>
@endsection