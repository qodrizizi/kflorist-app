<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bonsai Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Apply dark mode BEFORE render to prevent flicker --}}
    <script>
        (function(){
            if(localStorage.getItem('darkMode')==='true') document.documentElement.classList.add('dark');
            if(localStorage.getItem('sidebarCollapsed')==='true') document.documentElement.classList.add('sidebar-is-collapsed');
        })();
    </script>

    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }

        /* Sidebar width transitions */
        .sidebar-wrap { width: 260px; transition: width 0.3s ease; }
        .sidebar-wrap.collapsed { width: 72px; }
        .sidebar-wrap.collapsed .sb-text { display: none; }
        .sidebar-wrap.collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
        .sidebar-wrap.collapsed .nav-item i { margin-right: 0; }

        .header-wrap { left: 260px; transition: left 0.3s ease; }
        .header-wrap.shifted, .sidebar-is-collapsed .header-wrap { left: 72px; }
        .main-wrap { margin-left: 260px; transition: margin-left 0.3s ease; }
        .main-wrap.shifted, .sidebar-is-collapsed .main-wrap { margin-left: 72px; }

        /* Early collapse support */
        .sidebar-is-collapsed .sidebar-wrap { width: 72px; }
        .sidebar-is-collapsed .sb-text { display: none; }
        .sidebar-is-collapsed .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
        .sidebar-is-collapsed .nav-item i { margin-right: 0; }

        /* Nav items */
        .nav-item {
            display: flex; align-items: center; padding: 9px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 500; text-decoration: none; margin-bottom: 1px;
            transition: all 0.15s ease;
        }
        .nav-item i { width: 18px; text-align: center; margin-right: 10px; font-size: 15px; flex-shrink: 0; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { border-radius: 3px; background: #cbd5e1; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }

        /* Dash card - used across all views */
        .dash-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
            transition: box-shadow 0.2s ease;
        }
        .dash-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .dark .dash-card { background: #1e293b; border-color: #334155; }
        .dark .dash-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.25); }

        /* Dark mode form elements */
        .dark input:not([type="checkbox"]):not([type="radio"]),
        .dark textarea, .dark select {
            background-color: #0f172a !important; border-color: #334155 !important; color: #e2e8f0 !important;
        }
        .dark input::placeholder, .dark textarea::placeholder { color: #64748b !important; }

        /* Page loader */
        #page-loader { display: none; }
        #page-loader.show { display: flex; }
        @keyframes leafSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .leaf-spin { animation: leafSpin 0.7s linear infinite; }

        /* Content enter animation */
        .page-enter { animation: fadeUp 0.35s ease both; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

        /* Toggle switch */
        .toggle-track { width: 44px; height: 24px; border-radius: 12px; position: relative; cursor: pointer; transition: background 0.25s ease; }
        .toggle-thumb { position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; border-radius: 50%; transition: transform 0.25s ease;
                         display: flex; align-items: center; justify-content: center; }
        .toggle-track.on .toggle-thumb { transform: translateX(20px); }

        /* Section label */
        .nav-section { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 0 14px; margin-bottom: 6px; }

        /* Prevent Alpine.js flicker */
        [x-cloak] { display: none !important; }

        /* Disable transitions on load */
        .no-transition * { transition: none !important; }

        /* ===================================================
           MODERN, COMPACT & ROUNDED SWEETALERT2 STYLES
           =================================================== */
        .swal2-container {
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            background-color: rgba(15, 23, 42, 0.45) !important;
            z-index: 99999 !important;
        }

        .swal2-popup {
            width: 23rem !important;
            max-width: calc(100vw - 2rem) !important;
            border-radius: 1.5rem !important; /* 24px */
            padding: 1.6rem 1.4rem 1.4rem !important;
            background: #ffffff !important;
            border: 1px solid rgba(226, 232, 240, 0.9) !important;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.18), 0 0 0 1px rgba(15, 23, 42, 0.04) !important;
            font-family: 'Inter', system-ui, sans-serif !important;
        }

        .dark .swal2-popup {
            background: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.06) !important;
        }

        /* Proportional and Elegant Icons */
        .swal2-icon {
            width: 3.5rem !important;
            height: 3.5rem !important;
            min-width: 3.5rem !important;
            margin: 0.25rem auto 1rem !important;
            border-width: 2.5px !important;
            transform: scale(0.9) !important;
        }

        /* Success Icon */
        .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            color: #10b981 !important;
            background: rgba(16, 185, 129, 0.08) !important;
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border: 2px solid rgba(16, 185, 129, 0.2) !important;
        }
        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #10b981 !important;
        }
        .swal2-icon.swal2-success .swal2-success-fix,
        .swal2-icon.swal2-success .swal2-success-circular-line-left,
        .swal2-icon.swal2-success .swal2-success-circular-line-right {
            background-color: transparent !important;
        }

        /* Error Icon */
        .swal2-icon.swal2-error {
            border-color: #f43f5e !important;
            color: #f43f5e !important;
            background: rgba(244, 63, 94, 0.08) !important;
        }
        .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
            background-color: #f43f5e !important;
            height: 2.5px !important;
            width: 22px !important;
            top: 24px !important;
        }

        /* Warning Icon */
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
            background: rgba(245, 158, 11, 0.08) !important;
        }

        /* Question Icon */
        .swal2-icon.swal2-question {
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
            background: rgba(59, 130, 246, 0.08) !important;
        }

        /* Info Icon */
        .swal2-icon.swal2-info {
            border-color: #6366f1 !important;
            color: #6366f1 !important;
            background: rgba(99, 102, 241, 0.08) !important;
        }

        /* Title */
        .swal2-title {
            font-size: 1.15rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            padding: 0 0.5rem !important;
            margin: 0 0 0.4rem 0 !important;
            line-height: 1.4 !important;
            letter-spacing: -0.01em !important;
        }
        .dark .swal2-title {
            color: #f8fafc !important;
        }

        /* Description / HTML Container */
        .swal2-html-container {
            font-size: 0.875rem !important;
            color: #64748b !important;
            line-height: 1.55 !important;
            margin: 0 0 1.25rem 0 !important;
            padding: 0 0.5rem !important;
            font-weight: 400 !important;
        }
        .swal2-html-container b,
        .swal2-html-container strong {
            color: #0f172a !important;
            font-weight: 600 !important;
        }
        .dark .swal2-html-container {
            color: #94a3b8 !important;
        }
        .dark .swal2-html-container b,
        .dark .swal2-html-container strong {
            color: #f1f5f9 !important;
        }

        /* Action Buttons */
        .swal2-actions {
            margin: 0.25rem 0 0 0 !important;
            width: 100% !important;
            gap: 0.625rem !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .swal2-styled {
            border-radius: 0.875rem !important; /* 14px */
            padding: 0.65rem 1.4rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            outline: none !important;
            box-shadow: none !important;
            cursor: pointer !important;
            min-height: 2.6rem !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .swal2-styled:hover {
            transform: translateY(-1.5px) !important;
        }
        .swal2-styled:active {
            transform: translateY(0px) scale(0.98) !important;
        }

        /* Ensure hidden buttons (Deny, Cancel) are never forced visible */
        .swal2-actions button[style*="display: none"],
        .swal2-styled[style*="display: none"],
        button.swal2-styled[style*="display: none"] {
            display: none !important;
        }

        /* Confirm Button - Emerald Gradient */
        .swal2-styled.swal2-confirm {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px -1px rgba(16, 185, 129, 0.4) !important;
            border: none !important;
        }
        .swal2-styled.swal2-confirm:hover {
            box-shadow: 0 6px 18px -1px rgba(16, 185, 129, 0.5) !important;
        }

        /* Danger Confirm Button */
        .swal2-styled.swal2-confirm[style*="#ef4444"],
        .swal2-styled.swal2-confirm[style*="rgb(239, 68, 68)"],
        .swal2-styled.swal2-confirm[style*="#f43f5e"] {
            background: linear-gradient(135deg, #f43f5e, #e11d48) !important;
            box-shadow: 0 4px 14px -1px rgba(244, 63, 94, 0.4) !important;
        }
        .swal2-styled.swal2-confirm[style*="#ef4444"]:hover,
        .swal2-styled.swal2-confirm[style*="rgb(239, 68, 68)"]:hover {
            box-shadow: 0 6px 18px -1px rgba(244, 63, 94, 0.5) !important;
        }

        /* Cancel Button */
        .swal2-styled.swal2-cancel {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
        }
        .swal2-styled.swal2-cancel:hover {
            background: #e2e8f0 !important;
            color: #1e293b !important;
        }
        .dark .swal2-styled.swal2-cancel {
            background: #334155 !important;
            color: #cbd5e1 !important;
            border-color: #475569 !important;
        }
        .dark .swal2-styled.swal2-cancel:hover {
            background: #475569 !important;
            color: #ffffff !important;
        }

        /* Sleek Modern Toasts */
        .swal2-toast {
            border-radius: 1rem !important; /* 16px */
            padding: 0.65rem 1rem !important;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08) !important;
            border: 1px solid rgba(226, 232, 240, 0.85) !important;
            background: #ffffff !important;
        }
        .swal2-toast .swal2-title {
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }
        .swal2-toast .swal2-icon {
            width: 1.75rem !important;
            height: 1.75rem !important;
            min-width: 1.75rem !important;
            margin: 0 0.5rem 0 0 !important;
        }
        .dark .swal2-toast {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-200 no-transition">
     <div x-data="{
            collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            dark: document.documentElement.classList.contains('dark')
         }"
         x-init="
            $watch('dark', v => {
                v ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
                localStorage.setItem('darkMode', v);
            });
            // Remove transition lock after a slightly longer delay to avoid toggle flicker
            setTimeout(() => document.body.classList.remove('no-transition'), 300);
         "
         class="min-h-screen">

        {{-- PAGE LOADER --}}
        <div id="page-loader" class="fixed inset-0 z-[9999] flex-col items-center justify-center bg-slate-50 dark:bg-slate-950">
            <i class="fas fa-leaf leaf-spin text-4xl text-emerald-500"></i>
            <span class="mt-3 text-xs font-medium text-slate-400">Memuat...</span>
        </div>

        {{-- SIDEBAR --}}
        <aside class="sidebar-wrap fixed top-0 left-0 h-full z-40 flex flex-col bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 overflow-hidden"
               :class="{ 'collapsed': collapsed }"
               x-init="$watch('collapsed', v => {
                   localStorage.setItem('sidebarCollapsed', v);
                   v ? document.documentElement.classList.add('sidebar-is-collapsed') : document.documentElement.classList.remove('sidebar-is-collapsed');
               })">

            {{-- Logo --}}
            <div class="flex items-center h-14 px-4 shrink-0 border-b border-slate-100 dark:border-slate-800">
                <i class="fas fa-leaf text-emerald-500 text-lg"></i>
                <span class="sb-text ml-2.5 text-base font-bold text-slate-800 dark:text-white">BonsaiKu</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-2.5 py-3">
                <p class="nav-section sb-text text-slate-400">Menu Utama</p>

                <a href="{{ route('dashboard.home') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.home') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-th-large"></i><span class="sb-text">Dashboard</span>
                </a>
                <a href="{{ route('dashboard.manajemen') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.manajemen') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-seedling"></i><span class="sb-text">Manajemen Bonsai</span>
                </a>
                <a href="{{ route('dashboard.categories') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.categories') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-tags"></i><span class="sb-text">Kategori</span>
                </a>
                <a href="{{ route('dashboard.orders') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.orders') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-shopping-bag"></i><span class="sb-text">Pesanan</span>
                </a>

                <p class="nav-section sb-text text-slate-400 mt-5">Operasional</p>

                <a href="{{ route('dashboard.perawatan') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.perawatan') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-hand-holding-water"></i><span class="sb-text">Perawatan</span>
                </a>
                <a href="{{ route('dashboard.keuangan') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.keuangan') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-wallet"></i><span class="sb-text">Keuangan</span>
                </a>
                <a href="{{ route('dashboard.laporan') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.laporan') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-chart-bar"></i><span class="sb-text">Laporan</span>
                </a>
                @php
                    $adminChatUnreadCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                @endphp
                <a href="{{ route('dashboard.chat.index') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white relative {{ request()->routeIs('dashboard.chat.*') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span class="sb-text flex-1">Pesan Chat</span>
                    @if($adminChatUnreadCount > 0)
                        <span :class="collapsed ? 'absolute top-1.5 right-1.5' : 'ml-2'"
                              class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center">
                            {{ $adminChatUnreadCount }}
                        </span>
                    @endif
                </a>
            </nav>

            {{-- Hidden logout form for navbar --}}
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </aside>

        {{-- HEADER --}}
        <header class="header-wrap fixed top-0 right-0 h-14 z-30 flex items-center justify-between px-6 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800"
                :class="{ 'shifted': collapsed }"
                x-data="{
                    notifOpen: false,
                    userMenuOpen: false,
                    notifications: [],
                    totalCount: 0,
                    async fetchNotifications() {
                        try {
                            const res = await fetch('{{ route('dashboard.notifications') }}', {
                                headers: { 'Accept': 'application/json' }
                            });
                            const data = await res.json();
                            this.notifications = data.notifications || [];
                            this.totalCount = data.total_count || 0;
                        } catch (e) {}
                    },
                    async markAllRead() {
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
                                this.totalCount = 0;
                                this.notifications.forEach(n => n.is_read = true);
                                if (window.Swal) {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Semua notifikasi ditandai dibaca',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            }
                        } catch (e) {}
                    },
                    async navigateTo(notif) {
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
                            } catch (e) {}
                        }
                        window.location.href = notif.url;
                    },
                    init() {
                        this.fetchNotifications();
                    }
                }">

            <div class="flex items-center gap-3">
                <button @click="collapsed = !collapsed; localStorage.setItem('sidebarCollapsed', collapsed)"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-600 dark:hover:text-slate-200 transition">
                    <i class="fas fa-bars text-sm"></i>
                </button>
                <div>
                    <h1 class="text-sm font-semibold text-slate-800 dark:text-white">@yield('title', 'Dashboard')</h1>
                    <p class="text-[11px] text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Toggle Dark/Light --}}
                <div class="toggle-track bg-slate-200 dark:bg-slate-700" :class="{ 'on': dark }" @click="dark = !dark">
                    <div class="toggle-thumb bg-white dark:bg-slate-900 shadow-sm">
                        <i x-show="!dark" class="fas fa-sun text-amber-400" style="font-size: 10px;"></i>
                        <i x-show="dark"  class="fas fa-moon text-blue-300" style="font-size: 10px;"></i>
                    </div>
                </div>

                {{-- Notifications Dropdown --}}
                <div class="relative">
                    <button @click="notifOpen = !notifOpen; if (notifOpen) fetchNotifications(); userMenuOpen = false" 
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition relative">
                        <i class="fas fa-bell text-sm"></i>
                        <span x-cloak x-show="totalCount > 0" x-text="totalCount" 
                              style="display: none;"
                              class="absolute -top-1 -right-1 bg-rose-500 text-white text-[9px] font-bold min-w-4 h-4 px-1 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-900 animate-pulse">
                        </span>
                    </button>

                    <div x-cloak x-show="notifOpen" @click.away="notifOpen = false" 
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden z-50">
                        
                        <div class="p-3.5 border-b border-slate-100 dark:border-slate-700/80 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800 dark:text-white">Notifikasi</span>
                                <span x-cloak x-show="totalCount > 0" x-text="totalCount + ' Baru'"
                                      style="display: none;"
                                      class="text-[10px] px-2 py-0.5 bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-full font-semibold"></span>
                            </div>
                            <button :disabled="totalCount === 0" 
                                    @click="markAllRead()"
                                    :class="totalCount > 0 ? 'text-emerald-600 dark:text-emerald-400 hover:underline cursor-pointer' : 'text-slate-400 dark:text-slate-500 opacity-60 cursor-default'"
                                    class="text-[11px] font-medium transition">
                                Tandai semua dibaca
                            </button>
                        </div>

                        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700/50">
                            <template x-for="notif in notifications" :key="notif.id">
                                <a href="javascript:void(0)" @click="navigateTo(notif)"
                                   :class="!notif.is_read ? 'bg-emerald-50/25 dark:bg-emerald-950/20' : ''"
                                   class="flex gap-3 p-3.5 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition group relative">
                                    
                                    <div x-show="!notif.is_read" class="absolute left-0 top-2 bottom-2 w-1 rounded-r bg-emerald-500"></div>

                                    <div :class="notif.icon_color" class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0">
                                        <i :class="notif.icon" class="text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between gap-1">
                                            <h5 class="text-[11px] font-bold text-slate-800 dark:text-white truncate" x-text="notif.title"></h5>
                                            <span class="text-[9px] text-slate-400 shrink-0" x-text="notif.time"></span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 mt-0.5" x-text="notif.message"></p>
                                    </div>
                                </a>
                            </template>
                            
                            <div x-show="notifications.length === 0" class="p-8 text-center">
                                <i class="fas fa-bell-slash text-slate-300 dark:text-slate-600 text-2xl mb-2"></i>
                                <p class="text-xs text-slate-400">Tidak ada notifikasi baru</p>
                            </div>
                        </div>

                        <div class="p-2.5 bg-slate-50 dark:bg-slate-900/60 border-t border-slate-100 dark:border-slate-700/60 text-center">
                            <a href="{{ route('dashboard.notifications.index') }}"
                               class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 flex items-center justify-center gap-1.5 transition">
                                <span>Lihat Semua Notifikasi</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div class="relative">
                    <button @click="userMenuOpen = !userMenuOpen; notifOpen = false"
                            class="flex items-center gap-2 p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <div class="w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="hidden md:block text-xs font-medium text-slate-700 dark:text-slate-200">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                        <i class="fas fa-chevron-down text-slate-400 transition-transform duration-200" style="font-size: 9px;" :class="{ 'rotate-180': userMenuOpen }"></i>
                    </button>

                    <div x-cloak x-show="userMenuOpen" @click.away="userMenuOpen = false"
                         style="display: none;"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 py-1.5 z-50">
                        <a href="{{ route('dashboard.profile') }}"
                           class="flex items-center px-3.5 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                            <i class="fas fa-user mr-2.5 w-3.5 text-center text-slate-400"></i> Profil
                        </a>
                        <a href="{{ route('dashboard.notifications.index') }}"
                           class="flex items-center justify-between px-3.5 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition group">
                            <div class="flex items-center">
                                <i class="fas fa-bell mr-2.5 w-3.5 text-center text-slate-400 group-hover:text-emerald-500 transition-colors"></i> Notifikasi Saya
                            </div>
                            <span x-cloak x-show="totalCount > 0" x-text="totalCount" 
                                  style="display: none;"
                                  class="bg-rose-500 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full min-w-4 text-center">
                            </span>
                        </a>
                        <hr class="my-1 border-slate-100 dark:border-slate-700">
                        <button onclick="triggerLogout()"
                                class="w-full flex items-center px-3.5 py-2 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                            <i class="fas fa-sign-out-alt mr-2.5 w-3.5 text-center"></i> Logout
                        </button>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="main-wrap pt-14 min-h-screen bg-slate-50 dark:bg-slate-950"
              :class="{ 'shifted': collapsed }">
            <div class="p-6 page-enter">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('modals')



    <script type="module">
        // Page transition
        document.querySelectorAll('.nav-go').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.classList.contains('!bg-emerald-50') || this.classList.contains('dark:!bg-emerald-500/10')) return;
                if (e.ctrlKey || e.metaKey || e.shiftKey) return;
                e.preventDefault();
                const href = this.getAttribute('href');
                document.getElementById('page-loader').classList.add('show');
                setTimeout(() => { window.location.href = href; }, 100);
            });
        });

        // Toasts
        const showToasts = () => {
            @if(session('success'))
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true });
            @endif
            @if(session('error'))
                Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: '{{ session('error') }}', showConfirmButton: false, timer: 3000 });
            @endif
            @if($errors->any())
                Swal.fire({ icon: 'error', title: 'Oops!', html: '<ul class="text-left text-sm">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>', confirmButtonColor: '#059669' });
            @endif
        };

        if (window.Swal) {
            showToasts();
        } else {
            let checkCount = 0;
            const swalCheck = setInterval(() => {
                checkCount++;
                if (window.Swal) {
                    clearInterval(swalCheck);
                    showToasts();
                }
                if (checkCount > 100) clearInterval(swalCheck); // stop after 5s
            }, 50);
        }

        // Logout
        window.triggerLogout = function() {
            if (window.Swal) {
                Swal.fire({
                    title: 'Keluar dari Dashboard?',
                    text: 'Sesi Anda akan diakhiri.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then(r => {
                    if (r.isConfirmed) document.getElementById('logout-form').submit();
                });
            } else {
                if (confirm('Keluar dari Dashboard? Sesi Anda akan diakhiri.')) {
                    document.getElementById('logout-form').submit();
                }
            }
        };

        window.confirmDelete = function(button) {
            if (window.Swal) {
                Swal.fire({
                    title: 'Hapus data ini?', text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
                }).then(r => { if (r.isConfirmed) button.closest('form').submit(); });
            } else {
                if (confirm('Hapus data ini?')) button.closest('form').submit();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>