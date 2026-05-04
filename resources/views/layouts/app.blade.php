<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bonsai Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'bonsai': {
                            50: '#ecfdf5',
                            100: '#d1fae5', 
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b'
                        },
                        'dark': {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="antialiased overflow-x-hidden" 
      x-data="{ 
        sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
        darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }" 
      x-init="
        $nextTick(() => { $el.style.opacity = '1' });
        if (darkMode) document.documentElement.classList.add('dark');
        $watch('darkMode', value => {
          if (value) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
          } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
          }
        })
      " 
      style="opacity: 0; transition: opacity 0.3s ease;"
      :class="{ 'dark': darkMode }">

    <header class="header-gradient fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="flex items-center justify-between h-16 px-6">
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen; localStorage.setItem('sidebarOpen', sidebarOpen)" 
                        class="glow-effect p-2 rounded-xl hover:bg-white/50 dark:hover:bg-slate-700/50 transition-all duration-300 group">
                    <div class="relative">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-300 transition-transform duration-300" 
                             :class="{ 'rotate-90': !sidebarOpen }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </div>
                </button>
                
                <div class="flex items-center space-x-3">
                    <div class="logo-animate text-2xl">🌿</div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-bonsai-600 to-bonsai-800 bg-clip-text text-transparent">
                            Bonsai
                        </h1>
                        <p class="text-xs text-slate-500 font-medium">Dashboard</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" 
                        class="dark-mode-toggle glow-effect p-2.5 rounded-xl hover:bg-white/50 dark:hover:bg-slate-700/50 transition-all duration-300 group">
                    <svg x-show="!darkMode" class="w-5 h-5 text-slate-600 group-hover:text-bonsai-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5 text-yellow-500 group-hover:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
                
                <div class="relative">
                    <button class="glow-effect p-2.5 rounded-xl hover:bg-white/50 dark:hover:bg-slate-700/50 transition-all duration-300 group">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-300 group-hover:text-bonsai-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 15a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </button>
                    <div class="absolute -top-1 -right-1">
                        <span class="notification-dot absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </div>
                </div>

                <div class="relative" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" 
                            class="flex items-center space-x-3 p-2 rounded-xl hover:bg-white/50 dark:hover:bg-slate-700/50 transition-all duration-300 group">
                        <div class="user-avatar w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'JD', 0, 2)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ Auth::user()->name ?? 'John Doe' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Admin</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 transition-transform duration-300 group-hover:text-bonsai-600" 
                             :class="{ 'rotate-180': userMenuOpen }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="userMenuOpen" 
                          @click.away="userMenuOpen = false"
                          x-transition:enter="transition ease-out duration-200"
                          x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                          x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                          x-transition:leave="transition ease-in duration-150"
                          x-transition:leave-start="opacity-100 scale-100"
                          x-transition:leave-end="opacity-0 scale-95"
                          class="absolute right-0 mt-2 w-56 glass-card rounded-2xl shadow-xl py-2 z-50">
                        
                        <a href="{{ route('dashboard.profile') }}" class="flex items-center px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-gradient-to-r hover:from-bonsai-50 dark:hover:from-bonsai-900/20 hover:to-transparent transition-all duration-200 group">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <span class="text-blue-600 dark:text-blue-400 text-sm">👤</span>
                            </div>
                            <div>
                                <p class="font-medium">Profile</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Manage your account</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-gradient-to-r hover:from-bonsai-50 dark:hover:from-bonsai-900/20 hover:to-transparent transition-all duration-200 group">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900 dark:to-purple-800 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <span class="text-purple-600 dark:text-purple-400 text-sm">⚙️</span>
                            </div>
                            <div>
                                <p class="font-medium">Settings</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Preferences</p>
                            </div>
                        </a>
                        
                        <hr class="my-2 border-slate-200/50 dark:border-slate-600/50">
                        
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button" id="logout-btn" class="w-full flex items-center px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-gradient-to-r hover:from-red-50 dark:hover:from-red-900/20 hover:to-transparent transition-all duration-200 group">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900 dark:to-red-800 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <span class="text-red-600 dark:text-red-400 text-sm">🚪</span>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium">Sign out</p>
                                    <p class="text-xs text-red-400 dark:text-red-500">End your session</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <aside class="sidebar-gradient fixed left-0 top-16 bottom-0 transition-all z-40" 
           :class="sidebarOpen ? 'sidebar-open' : 'sidebar-closed'">
        <div class="p-4 h-full">
            <nav class="space-y-2 mt-4">
                <a href="{{ route('dashboard.home') }}" class="nav-link px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-200 font-medium group">
                    <div class="nav-icon w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900 dark:to-blue-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-blue-600 dark:text-blue-400 text-lg">🏠</span>
                    </div>
                    <div class="nav-text">
                        <p class="font-semibold">Dashboard</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Overview & stats</p>
                    </div>
                </a>
                
                <a href="{{ route('dashboard.manajemen') }}" class="nav-link px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-200 font-medium group">
                    <div class="nav-icon w-10 h-10 rounded-xl bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900 dark:to-green-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-green-600 dark:text-green-400 text-lg">🌱</span>
                    </div>
                    <div class="nav-text">
                        <p class="font-semibold">Manajemen</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Manage bonsai</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.keuangan') }}" class="nav-link px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-200 font-medium group">
                    <div class="nav-icon w-10 h-10 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900 dark:to-yellow-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-yellow-600 dark:text-yellow-400 text-lg">💰</span>
                    </div>
                    <div class="nav-text">
                        <p class="font-semibold">Keuangan</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Financial data</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.laporan') }}" class="nav-link px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-200 font-medium group">
                    <div class="nav-icon w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900 dark:to-purple-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-purple-600 dark:text-purple-400 text-lg">📊</span>
                    </div>
                    <div class="nav-text">
                        <p class="font-semibold">Laporan</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Reports & analytics</p>
                    </div>
                </a>

                <a href="{{ route('dashboard.perawatan') }}" class="nav-link px-4 py-3.5 rounded-2xl text-slate-700 dark:text-slate-200 font-medium group">
                    <div class="nav-icon w-10 h-10 rounded-xl bg-gradient-to-br from-red-100 to-red-200 dark:from-red-900 dark:to-red-800 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                        <span class="text-red-600 dark:text-red-400 text-lg">⚙️</span>
                    </div>
                    <div class="nav-text">
                        <p class="font-semibold">Perawatan</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Maintenance</p>
                    </div>
                </a>
            </nav>

            <div class="absolute bottom-8 left-4 right-4" 
                 x-show="sidebarOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
            </div>
        </div>
    </aside>

    <main class="content-transition pt-16 min-h-screen" 
          :class="sidebarOpen ? 'ml-[280px]' : 'ml-[80px]'">
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    <footer class="glass-card border-0 border-t border-slate-200/50 dark:border-slate-600/50 content-transition" 
            :class="sidebarOpen ? 'ml-[280px]' : 'ml-[80px]'">
        <div class="px-6 py-4">
            <div class="flex items-center justify-center space-x-2">
                <span class="text-sm text-slate-500 dark:text-slate-400">Made with</span>
                <span class="text-red-500 animate-pulse">❤️</span>
                <span class="text-sm text-slate-500 dark:text-slate-400">for bonsai enthusiasts</span>
                <div class="flex space-x-1 ml-4">
                    <div class="w-2 h-2 bg-bonsai-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-bonsai-600 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-bonsai-700 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced active menu highlighting
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Success notifications
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    background: 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                    color: '#fff',
                    iconColor: '#fff'
                });
            @endif

            // Error handling
            @if($errors->any())
                const errorMessages = [
                    @foreach($errors->all() as $error)
                        '{{ $error }}',
                    @endforeach
                ];
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong',
                    html: '<div class="text-left space-y-2">' + 
                        errorMessages.map(error => `<div class="flex items-center space-x-2"><span class="text-red-500">•</span><span>${error}</span></div>`).join('') +
                        '</div>',
                    confirmButtonColor: '#ef4444',
                    background: 'linear-gradient(135deg, #fff 0%, #fef2f2 100%)',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl'
                    }
                });
            @endif

            // Logout with style
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Ready to leave? 🌿',
                        text: "Your session will be ended safely",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: '✨ Yes, Sign Out',
                        cancelButtonText: 'Stay Here',
                        background: 'linear-gradient(135deg, #fff 0%, #f0fdf4 100%)',
                        customClass: {
                            popup: 'rounded-2xl shadow-2xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            }
        });

        // Enhanced delete confirmation
        function confirmDelete(button) {
            Swal.fire({
                title: 'Delete Forever? 🗑️',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '🔥 Yes, Delete It!',
                cancelButtonText: 'Keep It Safe',
                background: 'linear-gradient(135deg, #fff 0%, #fef2f2 100%)',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        // Smooth page transitions
        window.addEventListener('beforeunload', function() {
            document.body.style.opacity = '0';
        });
    </script>
</body>
</html>