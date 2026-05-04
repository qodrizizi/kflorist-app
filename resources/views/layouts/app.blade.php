<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bonsai Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Apply dark mode BEFORE render to prevent flicker --}}
    <script>
        (function(){
            if(localStorage.getItem('darkMode')==='true') document.documentElement.classList.add('dark');
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
        .header-wrap.shifted { left: 72px; }
        .main-wrap { margin-left: 260px; transition: margin-left 0.3s ease; }
        .main-wrap.shifted { margin-left: 72px; }

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
    </style>
</head>

<body class="antialiased bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-200">
    <div x-data="{
            collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
            dark: document.documentElement.classList.contains('dark')
         }"
         x-init="
            $watch('dark', v => {
                v ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
                localStorage.setItem('darkMode', v);
            });
         "
         class="min-h-screen">

        {{-- PAGE LOADER --}}
        <div id="page-loader" class="fixed inset-0 z-[9999] flex-col items-center justify-center bg-slate-50 dark:bg-slate-950">
            <i class="fas fa-leaf leaf-spin text-4xl text-emerald-500"></i>
            <span class="mt-3 text-xs font-medium text-slate-400">Memuat...</span>
        </div>

        {{-- SIDEBAR --}}
        <aside class="sidebar-wrap fixed top-0 left-0 h-full z-40 flex flex-col bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 overflow-hidden"
               :class="{ 'collapsed': collapsed }">

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

                <p class="nav-section sb-text text-slate-400 mt-5">Akun</p>

                <a href="{{ route('dashboard.profile') }}"
                   class="nav-item nav-go text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white {{ request()->routeIs('dashboard.profile') ? '!bg-emerald-50 !text-emerald-600 !font-semibold dark:!bg-emerald-500/10 dark:!text-emerald-400' : '' }}">
                    <i class="fas fa-user-circle"></i><span class="sb-text">Profil Saya</span>
                </a>
            </nav>

            {{-- Logout --}}
            <div class="px-2.5 py-3 shrink-0 border-t border-slate-100 dark:border-slate-800">
                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" id="logout-btn"
                            class="nav-item w-full text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">
                        <i class="fas fa-sign-out-alt"></i><span class="sb-text">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- HEADER --}}
        <header class="header-wrap fixed top-0 right-0 h-14 z-30 flex items-center justify-between px-6 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800"
                :class="{ 'shifted': collapsed }">

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

                {{-- User --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <div class="w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="hidden md:block text-xs font-medium text-slate-700 dark:text-slate-200">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                        <i class="fas fa-chevron-down text-slate-400 transition-transform duration-200" style="font-size: 9px;" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-44 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 py-1.5 z-50">
                        <a href="{{ route('dashboard.profile') }}"
                           class="flex items-center px-3.5 py-2 text-xs text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                            <i class="fas fa-user mr-2.5 w-3.5 text-center text-slate-400"></i> Profil
                        </a>
                        <hr class="my-1 border-slate-100 dark:border-slate-700">
                        <button onclick="document.getElementById('logout-btn').click()"
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

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Page transition
            document.querySelectorAll('.nav-go').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.classList.contains('!bg-emerald-50') || this.classList.contains('dark:!bg-emerald-500/10')) return;
                    if (e.ctrlKey || e.metaKey || e.shiftKey) return;
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    document.getElementById('page-loader').classList.add('show');
                    setTimeout(() => { window.location.href = href; }, 350);
                });
            });

            // Toasts
            @if(session('success'))
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true });
            @endif
            @if(session('error'))
                Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: '{{ session('error') }}', showConfirmButton: false, timer: 3000 });
            @endif
            @if($errors->any())
                Swal.fire({ icon: 'error', title: 'Oops!', html: '<ul class="text-left text-sm">@foreach($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>', confirmButtonColor: '#059669' });
            @endif

            // Logout
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Keluar dari Dashboard?', text: 'Sesi Anda akan diakhiri.',
                        icon: 'question', showCancelButton: true,
                        confirmButtonColor: '#059669', cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ya, Logout', cancelButtonText: 'Batal'
                    }).then(r => { if (r.isConfirmed) document.getElementById('logout-form').submit(); });
                });
            }
        });

        function confirmDelete(button) {
            Swal.fire({
                title: 'Hapus data ini?', text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then(r => { if (r.isConfirmed) button.closest('form').submit(); });
        }
    </script>
</body>
</html>