@extends('layouts.app')

@section('title', 'Notifikasi Saya')

@section('content')
<div x-data="{
    filter: 'all',
    notifications: {{ Js::from($notifications) }},
    get unreadCount() {
        return this.notifications.filter(n => !n.is_read).length;
    },
    get totalCount() {
        return this.notifications.length;
    },
    get orderCount() {
        return this.notifications.filter(n => n.type === 'order').length;
    },
    get chatCount() {
        return this.notifications.filter(n => n.type === 'chat').length;
    },
    get maintenanceCount() {
        return this.notifications.filter(n => n.type === 'maintenance' || n.type === 'health').length;
    },
    async markAllRead() {
        if (this.unreadCount === 0) return;
        try {
            const res = await fetch('{{ route('dashboard.notifications.markAllRead') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if (data.success) {
                this.notifications.forEach(n => n.is_read = true);
                if (this.filter === 'unread') {
                    this.filter = 'all';
                }
                if (window.Swal) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Semua notifikasi ditandai telah dibaca',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        } catch (e) {
            console.error(e);
        }
    },
    async markAsRead(notif) {
        if (!notif.is_read) {
            try {
                await fetch('{{ url('dashboard/notifications') }}/' + notif.id + '/mark-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                notif.is_read = true;
            } catch(e) {}
        }
    },
    async navigateTo(notif) {
        await this.markAsRead(notif);
        window.location.href = notif.url;
    },
    get filteredNotifications() {
        if (this.filter === 'unread') {
            return this.notifications.filter(n => !n.is_read);
        }
        if (this.filter === 'order') {
            return this.notifications.filter(n => n.type === 'order');
        }
        if (this.filter === 'chat') {
            return this.notifications.filter(n => n.type === 'chat');
        }
        if (this.filter === 'maintenance') {
            return this.notifications.filter(n => n.type === 'maintenance' || n.type === 'health');
        }
        return this.notifications;
    }
}" class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">
                    Notifikasi Saya
                </h2>
                <span x-cloak x-show="unreadCount > 0" x-text="unreadCount + ' Baru'"
                      style="display: none;"
                      class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-600 dark:bg-rose-500/20 dark:text-rose-400">
                </span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Pantau pesanan masuk, pesan pelanggan, dan jadwal perawatan secara realtime.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="markAllRead()"
                    :disabled="unreadCount === 0"
                    :class="unreadCount === 0 ? 'opacity-50 cursor-not-allowed text-slate-400' : 'hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 cursor-pointer shadow-sm'"
                    class="px-4 py-2.5 text-xs font-semibold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl transition flex items-center gap-2">
                <i class="fas fa-check-double text-emerald-500"></i>
                <span>Tandai Semua Dibaca</span>
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div @click="filter = 'all'"
             :class="filter === 'all' ? 'ring-2 ring-emerald-500 bg-emerald-50/20 dark:bg-emerald-950/20' : ''"
             class="dash-card p-4 cursor-pointer hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Semua</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                    <i class="fas fa-bell text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800 dark:text-white mt-2" x-text="totalCount"></p>
        </div>

        <div @click="filter = 'unread'"
             :class="filter === 'unread' ? 'ring-2 ring-rose-500 bg-rose-50/20 dark:bg-rose-950/20' : ''"
             class="dash-card p-4 cursor-pointer hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-rose-600 dark:text-rose-400">Belum Dibaca</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-500">
                    <i class="fas fa-envelope text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-rose-600 dark:text-rose-400 mt-2" x-text="unreadCount"></p>
        </div>

        <div @click="filter = 'order'"
             :class="filter === 'order' ? 'ring-2 ring-emerald-500 bg-emerald-50/20 dark:bg-emerald-950/20' : ''"
             class="dash-card p-4 cursor-pointer hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Pesanan Masuk</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <i class="fas fa-shopping-bag text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-2" x-text="orderCount"></p>
        </div>

        <div @click="filter = 'chat'"
             :class="filter === 'chat' ? 'ring-2 ring-blue-500 bg-blue-50/20 dark:bg-blue-950/20' : ''"
             class="dash-card p-4 cursor-pointer hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">Chat Pelanggan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-comments text-xs"></i>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-2" x-text="chatCount"></p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1 border-b border-slate-200 dark:border-slate-800">
        <button @click="filter = 'all'"
                :class="filter === 'all' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium'"
                class="px-4 py-2 text-xs border-b-2 transition whitespace-nowrap cursor-pointer">
            Semua (<span x-text="totalCount"></span>)
        </button>
        <button @click="filter = 'unread'"
                :class="filter === 'unread' ? 'border-rose-500 text-rose-600 dark:text-rose-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium'"
                class="px-4 py-2 text-xs border-b-2 transition whitespace-nowrap cursor-pointer">
            Belum Dibaca (<span x-text="unreadCount"></span>)
        </button>
        <button @click="filter = 'order'"
                :class="filter === 'order' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium'"
                class="px-4 py-2 text-xs border-b-2 transition whitespace-nowrap cursor-pointer">
            Pesanan Masuk (<span x-text="orderCount"></span>)
        </button>
        <button @click="filter = 'chat'"
                :class="filter === 'chat' ? 'border-blue-500 text-blue-600 dark:text-blue-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium'"
                class="px-4 py-2 text-xs border-b-2 transition whitespace-nowrap cursor-pointer">
            Pesan Chat (<span x-text="chatCount"></span>)
        </button>
        <button @click="filter = 'maintenance'"
                :class="filter === 'maintenance' ? 'border-amber-500 text-amber-600 dark:text-amber-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium'"
                class="px-4 py-2 text-xs border-b-2 transition whitespace-nowrap cursor-pointer">
            Perawatan & Kondisi (<span x-text="maintenanceCount"></span>)
        </button>
    </div>

    {{-- Notifications List --}}
    <div class="space-y-3">
        <template x-for="notif in filteredNotifications" :key="notif.id">
            <div class="dash-card p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all duration-200 relative group overflow-hidden"
                 :class="!notif.is_read 
                    ? 'border-emerald-500/40 bg-emerald-50/20 dark:bg-emerald-950/20 shadow-sm' 
                    : 'border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900'">
                
                {{-- Left unread indicator bar --}}
                <div x-show="!notif.is_read" class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-emerald-500 to-teal-500"></div>

                <div class="flex items-start gap-4 flex-1 min-w-0">
                    {{-- Icon --}}
                    <div :class="notif.icon_color" class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm text-base">
                        <i :class="notif.icon"></i>
                    </div>

                    {{-- Text Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span :class="notif.badge_color" class="text-[10px] font-bold px-2 py-0.5 rounded-full" x-text="notif.category_label"></span>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                <i class="far fa-clock text-[10px]"></i>
                                <span x-text="notif.time"></span>
                            </span>
                            
                            {{-- Read / Unread Status Badge --}}
                            <span x-show="!notif.is_read" 
                                  class="inline-flex items-center gap-1 text-[10px] font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                Belum dibaca
                            </span>
                            <span x-show="notif.is_read" 
                                  class="inline-flex items-center gap-1 text-[10px] font-medium text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-full">
                                <i class="fas fa-check text-[9px] text-emerald-500"></i>
                                Sudah dibaca
                            </span>
                        </div>
                        <h4 class="text-sm sm:text-base font-bold text-slate-800 dark:text-white" x-text="notif.title"></h4>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-1 leading-relaxed" x-text="notif.message"></p>
                    </div>
                </div>

                {{-- Action Buttons (Stable fixed-grid structure) --}}
                <div class="flex items-center gap-2.5 sm:self-center shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800/80">
                    {{-- Status/Mark Button (Always has presence, preventing layout collapse) --}}
                    <button x-show="!notif.is_read"
                            @click="markAsRead(notif)"
                            class="px-3.5 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 border border-slate-200 dark:border-slate-700 rounded-xl transition flex items-center gap-1.5 shadow-sm active:scale-95"
                            title="Tandai telah dibaca">
                        <i class="fas fa-check text-emerald-500 text-[11px]"></i>
                        <span>Dibaca</span>
                    </button>

                    <span x-show="notif.is_read"
                          class="px-3.5 py-1.5 text-xs font-medium text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-800/60 border border-transparent rounded-xl flex items-center gap-1.5 cursor-default">
                        <i class="fas fa-check-double text-emerald-500/70 text-[11px]"></i>
                        <span>Selesai</span>
                    </span>

                    {{-- Open/Detail Button --}}
                    <button @click="navigateTo(notif)"
                            class="px-4 py-1.5 text-xs font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 rounded-xl shadow-sm hover:shadow transition flex items-center gap-1.5 active:scale-95">
                        <span>Lihat Detail</span>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </template>

        {{-- Empty State --}}
        <div x-show="filteredNotifications.length === 0" class="dash-card p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4 text-slate-300 dark:text-slate-600 text-2xl">
                <i class="fas fa-bell-slash"></i>
            </div>
            <h3 class="text-base font-bold text-slate-700 dark:text-slate-200">Tidak ada notifikasi</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                Semua pembaruan terkait pesanan, percakapan, dan jadwal perawatan akan tampil di sini saat tersedia.
            </p>
            <button x-show="filter !== 'all'" @click="filter = 'all'"
                    class="mt-4 px-4 py-2 text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl transition">
                Tampilkan Semua Notifikasi
            </button>
        </div>
    </div>

</div>
@endsection
