@extends('layouts.app')
@section('title', 'Kelola Pesanan')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Pesanan</h2>
    <p class="text-sm text-slate-500 mt-1">Pantau dan kelola semua pesanan pelanggan.</p>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    @php
        $pending = $orders->where('status', 'pending')->count();
        $diproses = $orders->where('status', 'diproses')->count();
        $dikirim = $orders->where('status', 'dikirim')->count();
        $selesai = $orders->where('status', 'selesai')->count();
    @endphp
    <div class="dash-card p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
            <i class="fas fa-clock text-amber-500 text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $pending }}</p>
            <p class="text-xs text-slate-400">Pending</p>
        </div>
    </div>
    <div class="dash-card p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
            <i class="fas fa-cog text-blue-500 text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $diproses }}</p>
            <p class="text-xs text-slate-400">Diproses</p>
        </div>
    </div>
    <div class="dash-card p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
            <i class="fas fa-truck text-indigo-500 text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $dikirim }}</p>
            <p class="text-xs text-slate-400">Dikirim</p>
        </div>
    </div>
    <div class="dash-card p-4 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
            <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
        </div>
        <div>
            <p class="text-lg font-bold text-slate-800 dark:text-white">{{ $selesai }}</p>
            <p class="text-xs text-slate-400">Selesai</p>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="dash-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase bg-slate-50 dark:bg-slate-800/50">
                    <th class="px-5 py-3 font-medium">Kode Pesanan</th>
                    <th class="px-5 py-3 font-medium">Pelanggan</th>
                    <th class="px-5 py-3 font-medium">Bonsai</th>
                    <th class="px-5 py-3 font-medium">Qty</th>
                    <th class="px-5 py-3 font-medium">Total</th>
                    <th class="px-5 py-3 font-medium">Metode</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Tanggal</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition">
                    <td class="px-5 py-4 font-mono text-xs text-slate-500">{{ $order->order_code }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $order->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-slate-700 dark:text-slate-300">{{ Str::limit($order->bonsai->name ?? '-', 25) }}</td>
                    <td class="px-5 py-4 text-slate-600 dark:text-slate-400 text-center">{{ $order->quantity }}</td>
                    <td class="px-5 py-4 font-semibold text-slate-800 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">{{ $order->metode_pembayaran ?? '-' }}</td>
                    <td class="px-5 py-4">
                        @php
                            $colors = [
                                'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                'diproses' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'dikirim' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                'selesai' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                'dibatalkan' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            ];
                        @endphp
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$order->status] ?? '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-xs text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                <i class="fas fa-ellipsis-v text-slate-400 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700 py-1 z-20">
                                @foreach(['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $status)
                                    @if($order->status !== $status)
                                    <form action="{{ route('dashboard.orders.updateStatus', $order) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="{{ $status }}">
                                        <button type="submit"
                                                class="w-full text-left px-3 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                                            Set → {{ ucfirst($status) }}
                                        </button>
                                    </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-inbox text-3xl mb-2 block"></i>
                        Belum ada pesanan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-700">
        {{ $orders->links() }}
    </div>
</div>
@endsection
