@extends('layouts.shop')

@section('content')
<div class="bg-slate-50 min-h-screen pb-16">

    <!-- ================= HERO / BANNER KOMUNITAS ================= -->
    <div class="relative bg-gradient-to-r from-emerald-950 via-teal-950 to-slate-950 text-white overflow-hidden py-9 lg:py-12 border-b border-emerald-800/40">
        <!-- Background Ambient Glow & Wallpaper -->
        <div class="absolute inset-0 opacity-15 bg-cover bg-center" style="background-image: url('{{ asset('images/bglogin.webp') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/40 to-transparent"></div>
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold mb-2.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Ruang Komunitas Kolektor & Pecinta Seni Bonsai</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-2.5">
                    Komunitas Bonsai Nusantara 🌿
                </h1>
                <p class="text-emerald-100/80 text-xs sm:text-sm leading-relaxed mb-5">
                    Tempat berkumpul, bertukar wawasan perawatan, memamerkan transformasi karya, serta mengakses penawaran eksklusif khusus member langsung dari Khadir Florist.
                </p>

                <!-- Quick Stats -->
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-xs text-emerald-200/90 pt-3 border-t border-white/10">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-users text-emerald-400 text-sm"></i>
                        <span><strong class="text-white font-bold">{{ \App\Models\User::count() + 1250 }}+</strong> Anggota Aktif</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-comments text-emerald-400 text-sm"></i>
                        <span><strong class="text-white font-bold">{{ \App\Models\CommunityPost::count() + 4800 }}+</strong> Diskusi & Solusi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-certificate text-emerald-400 text-sm"></i>
                        <span><strong class="text-white font-bold">100%</strong> Terverifikasi Khadir Florist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SOROTAN PEKAN INI (CENTERED PODIUM) ================= -->
    <div class="bg-white border-b border-slate-200/80 py-5 shadow-xs">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-flex items-center justify-center gap-2 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                <span class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fas fa-trophy text-amber-500"></i>
                    <span>Sorotan Pekan Ini (Bonsai of the Week)</span>
                </span>
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            </div>

            <!-- Centered Story Cards -->
            <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 max-w-4xl mx-auto">
                @foreach($spotlights as $spotlight)
                    <div class="flex items-center gap-3 p-2.5 pr-4 bg-slate-50 hover:bg-emerald-50/70 border border-slate-200/80 hover:border-emerald-300 rounded-2xl cursor-pointer transition shadow-2xs hover:shadow-sm group">
                        <!-- Thumbnail with glow border -->
                        <div class="relative w-12 h-12 rounded-xl overflow-hidden ring-2 ring-emerald-500/30 group-hover:ring-emerald-500 transition flex-shrink-0">
                            <img src="{{ $spotlight['image'] }}" alt="{{ $spotlight['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        </div>
                        <div class="text-left">
                            <span class="inline-block text-[9px] font-extrabold uppercase px-1.5 py-0.2 rounded bg-emerald-100 text-emerald-800 leading-tight">
                                {{ $spotlight['badge'] }}
                            </span>
                            <h4 class="text-xs font-bold text-slate-800 leading-tight mt-0.5 group-hover:text-emerald-700 transition">
                                {{ $spotlight['title'] }}
                            </h4>
                            <p class="text-[10px] text-slate-400 leading-tight">{{ $spotlight['author'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ================= MAIN CONTAINER 3-COLUMN LAYOUT ================= -->
    <div class="container mx-auto px-4 pt-6">
        
        <!-- Flash Alert Messages -->
        @if(session('success'))
            <div class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold">
                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold">
                    <i class="fas fa-exclamation-circle text-rose-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- ================= LEFT COLUMN: USER PROFILE, BADGES & CATEGORIES (3 COLS) ================= -->
            <div class="lg:col-span-3 space-y-5">
                
                <!-- Profile / Login Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5">
                    @auth
                        @php
                            $user = Auth::user();
                            $isAdmin = $user->role === 'admin';
                            $initial = strtoupper(substr($user->name, 0, 1));
                            $userPostsCount = \App\Models\CommunityPost::where('user_id', $user->id)->count();
                            $userSuburCount = \App\Models\CommunityReaction::where('user_id', $user->id)->where('type', 'subur')->count();
                            $userSolvedCount = \App\Models\CommunityComment::where('user_id', $user->id)->where('is_best_solution', true)->count();
                        @endphp
                        <div class="flex items-center space-x-3.5 mb-4 pb-4 border-b border-slate-100">
                            <div class="w-12 h-12 rounded-full bg-emerald-500 text-white font-bold flex items-center justify-center text-lg shadow-sm flex-shrink-0 overflow-hidden ring-2 ring-emerald-100">
                                @if($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ $initial }}
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-sm font-bold text-slate-800 truncate">{{ $user->name }}</h3>
                                    @if($isAdmin)
                                        <i class="fas fa-check-circle text-emerald-600 text-xs" title="Toko Resmi"></i>
                                    @endif
                                </div>
                                <span class="inline-block text-[11px] font-bold px-2 py-0.5 rounded-full mt-0.5 border {{ $isAdmin ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}">
                                    @if($isAdmin)
                                        👑 Toko Resmi
                                    @elseif($userPostsCount >= 10)
                                        🌳 Kolektor Senior
                                    @elseif($userPostsCount >= 3)
                                        🌿 Pecinta Ranting
                                    @else
                                        🌱 Tunas Baru
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- User Gamification Stats -->
                        <div class="grid grid-cols-3 gap-2 text-center text-xs pb-3 mb-3 border-b border-slate-100">
                            <div>
                                <span class="font-extrabold text-slate-800 block text-sm">{{ $userPostsCount }}</span>
                                <span class="text-[10px] text-slate-400">Postingan</span>
                            </div>
                            <div>
                                <span class="font-extrabold text-emerald-700 block text-sm">{{ $userSuburCount }}</span>
                                <span class="text-[10px] text-slate-400">🌿 Subur</span>
                            </div>
                            <div>
                                <span class="font-extrabold text-slate-800 block text-sm">{{ $userSolvedCount }}</span>
                                <span class="text-[10px] text-slate-400">Solusi ✔</span>
                            </div>
                        </div>

                        <button type="button" onclick="focusCreatePost()" 
                                class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm hover:shadow flex items-center justify-center gap-2">
                            <i class="fas fa-pen-nib"></i>
                            <span>Buat Postingan Baru</span>
                        </button>
                    @else
                        <div class="text-center py-2">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-seedling text-xl"></i>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 mb-1">Gabung Komunitas</h3>
                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                                Masuk untuk membagikan foto bonsai, bertanya tips perawatan, dan berinteraksi.
                            </p>
                            <div class="space-y-2">
                                <a href="{{ route('login') }}" class="block w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                                    Masuk Akun
                                </a>
                                <a href="{{ route('register') }}" class="block w-full py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                                    Daftar Gratis
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Category Filter Menu -->
                @php
                    $currentCat = request('category', 'all');
                    $currentSpecies = request('species', 'Semua');
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4">
                    <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-3 px-2">
                        Kategori Diskusi
                    </h4>
                    <nav class="space-y-1">
                        <a href="{{ route('shop.komunitas', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
                           class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition {{ $currentCat === 'all' ? 'font-bold bg-emerald-50 text-emerald-800' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-globe text-emerald-600 w-4 text-center"></i>
                                <span>Semua Diskusi</span>
                            </span>
                            <span class="text-[10px] {{ $currentCat === 'all' ? 'bg-white text-emerald-700 shadow-xs' : 'bg-slate-100 text-slate-600' }} px-2 py-0.5 rounded-full font-bold">
                                {{ \App\Models\CommunityPost::count() }}
                            </span>
                        </a>

                        <a href="{{ route('shop.komunitas', array_merge(request()->except('category', 'page'), ['category' => 'promosi'])) }}"
                           class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition {{ $currentCat === 'promosi' ? 'font-bold bg-amber-50 text-amber-900' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-bolt text-amber-500 w-4 text-center"></i>
                                <span>Promo Khusus Toko</span>
                            </span>
                            <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full">Resmi</span>
                        </a>

                        <a href="{{ route('shop.komunitas', array_merge(request()->except('category', 'page'), ['category' => 'diskusi'])) }}"
                           class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition {{ $currentCat === 'diskusi' ? 'font-bold bg-emerald-50 text-emerald-800' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-question-circle text-rose-500 w-4 text-center"></i>
                                <span>Tanya Jawab Perawatan</span>
                            </span>
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-medium">
                                {{ \App\Models\CommunityPost::where('category', 'diskusi')->count() }}
                            </span>
                        </a>

                        <a href="{{ route('shop.komunitas', array_merge(request()->except('category', 'page'), ['category' => 'showcase'])) }}"
                           class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition {{ $currentCat === 'showcase' ? 'font-bold bg-emerald-50 text-emerald-800' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-retweet text-blue-500 w-4 text-center"></i>
                                <span>Transformasi Karya</span>
                            </span>
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-medium">
                                {{ \App\Models\CommunityPost::where('category', 'showcase')->count() }}
                            </span>
                        </a>

                        <a href="{{ route('shop.komunitas', array_merge(request()->except('category', 'page'), ['category' => 'poll'])) }}"
                           class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition {{ $currentCat === 'poll' ? 'font-bold bg-emerald-50 text-emerald-800' : 'font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <span class="flex items-center gap-2.5">
                                <i class="fas fa-poll text-purple-500 w-4 text-center"></i>
                                <span>Poling Desain Cabang</span>
                            </span>
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full font-medium">
                                {{ \App\Models\CommunityPost::where('category', 'poll')->count() }}
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Level Gamification Legend -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4">
                    <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-2.5 px-2">
                        Peringkat Kolektor
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between px-2 py-1 rounded-lg bg-amber-50/60 border border-amber-200/60">
                            <span class="font-bold text-amber-900 flex items-center gap-1.5">
                                👑 Toko Resmi
                            </span>
                            <span class="text-[10px] text-amber-700 font-semibold">Khadir Florist</span>
                        </div>
                        <div class="flex items-center justify-between px-2 py-1 rounded-lg bg-emerald-50/60 border border-emerald-200/60">
                            <span class="font-semibold text-emerald-900 flex items-center gap-1.5">
                                🌳 Kolektor Senior
                            </span>
                            <span class="text-[10px] text-emerald-700">10+ Postingan</span>
                        </div>
                        <div class="flex items-center justify-between px-2 py-1 rounded-lg bg-teal-50/60 border border-teal-200/60">
                            <span class="font-semibold text-teal-900 flex items-center gap-1.5">
                                🌿 Pecinta Ranting
                            </span>
                            <span class="text-[10px] text-teal-700">3+ Postingan</span>
                        </div>
                        <div class="flex items-center justify-between px-2 py-1 rounded-lg bg-slate-50 border border-slate-200/60">
                            <span class="font-semibold text-slate-700 flex items-center gap-1.5">
                                🌱 Tunas Baru
                            </span>
                            <span class="text-[10px] text-slate-500">Anggota Baru</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= CENTER COLUMN: SPECIES CHIPS & MAIN FEED (6 COLS) ================= -->
            <div class="lg:col-span-6 space-y-5">
                
                <!-- ================= SPECIES FILTER CHIPS ================= -->
                <div class="bg-white rounded-2xl p-3 border border-slate-200/80 shadow-xs flex items-center gap-2 overflow-x-auto scrollbar-none">
                    <span class="text-xs font-bold text-slate-400 pl-1 flex-shrink-0 flex items-center gap-1">
                        <i class="fas fa-filter text-emerald-600"></i>
                        <span>Pohon:</span>
                    </span>
                    @foreach($speciesList as $species)
                        @php
                            $isSelected = $currentSpecies === $species;
                        @endphp
                        <a href="{{ route('shop.komunitas', array_merge(request()->except('species', 'page'), ['species' => $species])) }}"
                           class="flex-shrink-0 px-3 py-1 rounded-xl text-xs transition {{ $isSelected ? 'bg-emerald-600 text-white shadow-xs font-bold' : 'bg-slate-100 hover:bg-slate-200/70 text-slate-600 font-semibold' }}">
                            {{ $species }}
                        </a>
                    @endforeach
                </div>

                <!-- ================= CREATE POST BOX (FORM ASLI) ================= -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4 sm:p-5 transition hover:border-slate-300" id="createPostCard">
                    @auth
                        @php
                            $user = Auth::user();
                            $isAdmin = $user->role === 'admin';
                            $initial = strtoupper(substr($user->name, 0, 1));
                        @endphp

                        <form action="{{ route('shop.komunitas.store') }}" method="POST" enctype="multipart/form-data" id="mainPostForm">
                            @csrf
                            
                            <div class="flex items-start space-x-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-500 text-white font-bold flex items-center justify-center text-sm shadow-sm flex-shrink-0 overflow-hidden ring-2 ring-emerald-100">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $initial }}
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <textarea name="content" id="postInput" rows="2" required
                                              placeholder="Bagikan foto transformasi, kendala daun/akar, atau ajukan poling desain..."
                                              class="w-full text-xs sm:text-sm text-slate-800 placeholder-slate-400 bg-slate-50 hover:bg-slate-100/70 focus:bg-white rounded-xl p-3 border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/15 focus:outline-none transition resize-none"></textarea>
                                </div>
                            </div>

                            <!-- Rule Notice: Only Store Can Sell -->
                            @if($isAdmin)
                                <div class="mb-3 px-3 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-crown text-amber-600"></i>
                                        <span class="font-semibold">Mode Toko Resmi: Anda dapat merilis Promo Flash Deal & menautkan produk katalog.</span>
                                    </div>
                                    <span class="text-[10px] bg-amber-200 text-amber-900 px-2 py-0.5 rounded-full font-bold">Admin Toko</span>
                                </div>
                            @else
                                <div class="mb-3 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 text-[11px] flex items-center gap-2">
                                    <i class="fas fa-info-circle text-slate-400"></i>
                                    <span>Posting diskusi, pamer karya, dan poling bebas. Postingan jualan/promosi dikhususkan untuk Toko Resmi.</span>
                                </div>
                            @endif

                            <!-- DYNAMIC EXPANDER: BEFORE AFTER UPLOAD -->
                            <div id="beforeAfterSection" class="hidden mb-3 p-3 bg-blue-50/60 rounded-xl border border-blue-200 space-y-2">
                                <span class="text-[11px] font-bold text-blue-900 block flex items-center gap-1.5">
                                    <i class="fas fa-arrows-alt-h text-blue-600"></i>
                                    <span>Upload 2 Foto untuk Slider Sebelum & Sesudah:</span>
                                </span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-500 block mb-1">Foto Sebelum (Bahan Awal):</label>
                                        <input type="file" name="before_image" accept="image/*" class="w-full text-xs text-slate-600 file:py-1 file:px-2 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-800">
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-500 block mb-1">Foto Sesudah (Hasil Karya):</label>
                                        <input type="file" name="after_image" accept="image/*" class="w-full text-xs text-slate-600 file:py-1 file:px-2 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-800">
                                    </div>
                                </div>
                            </div>

                            <!-- DYNAMIC EXPANDER: POLL OPTIONS -->
                            <div id="pollSection" class="hidden mb-3 p-3 bg-purple-50/60 rounded-xl border border-purple-200 space-y-2">
                                <span class="text-[11px] font-bold text-purple-900 block flex items-center gap-1.5">
                                    <i class="fas fa-poll text-purple-600"></i>
                                    <span>Pertanyaan & Pilihan Poling:</span>
                                </span>
                                <input type="text" name="poll_question" placeholder="Pertanyaan poling (misal: Arah cabang bagus gaya apa?)"
                                       class="w-full text-xs p-2 rounded-lg border border-purple-200 focus:outline-none focus:ring-1 focus:ring-purple-400">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="text" name="poll_option_a" placeholder="Pilihan A (misal: Gaya Kengai)"
                                           class="w-full text-xs p-2 rounded-lg border border-purple-200 focus:outline-none focus:ring-1 focus:ring-purple-400">
                                    <input type="text" name="poll_option_b" placeholder="Pilihan B (misal: Gaya Moyogi)"
                                           class="w-full text-xs p-2 rounded-lg border border-purple-200 focus:outline-none focus:ring-1 focus:ring-purple-400">
                                </div>
                            </div>

                            <!-- DYNAMIC EXPANDER: PROMOSI RESMI TOKO (ADMIN ONLY) -->
                            @if($isAdmin)
                                <div id="promosiSection" class="hidden mb-3 p-3 bg-amber-50 rounded-xl border border-amber-200 space-y-2.5">
                                    <span class="text-[11px] font-bold text-amber-900 block flex items-center gap-1.5">
                                        <i class="fas fa-tag text-amber-600"></i>
                                        <span>Konfigurasi Promo Resmi Khadir Florist:</span>
                                    </span>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-500 block mb-1">Tautkan Produk Katalog:</label>
                                            <select name="bonsai_id" class="w-full text-xs p-2 rounded-lg border border-amber-200 bg-white">
                                                <option value="">-- Pilih Produk Terkait (Opsional) --</option>
                                                @foreach($allActiveBonsais as $bonsaiOpt)
                                                    <option value="{{ $bonsaiOpt->id }}">{{ $bonsaiOpt->name }} - Rp {{ number_format($bonsaiOpt->current_value, 0, ',', '.') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-500 block mb-1">Kode Voucher Diskon:</label>
                                            <input type="text" name="discount_code" placeholder="Misal: KOMUNITAS10"
                                                   class="w-full text-xs p-2 rounded-lg border border-amber-200 bg-white uppercase font-mono">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-500 block mb-1">Countdown Flash Deal (Jam):</label>
                                            <input type="number" name="flash_sale_hours" min="1" max="72" value="6" placeholder="Berapa jam aktif"
                                                   class="w-full text-xs p-2 rounded-lg border border-amber-200 bg-white">
                                        </div>
                                        <div>
                                            <label class="text-[10px] font-bold text-slate-500 block mb-1">Diskon Persen:</label>
                                            <input type="text" name="discount_percent" placeholder="Misal: 10%"
                                                   class="w-full text-xs p-2 rounded-lg border border-amber-200 bg-white">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Hidden file input for standard photos -->
                            <input type="file" name="images[]" id="standardImagesInput" multiple accept="image/*" class="hidden" onchange="updateFileCountText(this)">

                            <!-- Action Bar inside Create Post -->
                            <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-slate-100">
                                <div class="flex flex-wrap items-center gap-2">
                                    <!-- Upload Photo Button -->
                                    <button type="button" onclick="document.getElementById('standardImagesInput').click()"
                                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-emerald-700 bg-slate-100 hover:bg-emerald-50 px-2.5 py-1.5 rounded-lg transition">
                                        <i class="fas fa-image text-emerald-600"></i>
                                        <span id="photoBtnText">Foto Bonsai</span>
                                    </button>

                                    <!-- Category Dropdown Selection -->
                                    <select name="category" id="categorySelect" onchange="handleCategoryChange(this.value)"
                                            class="text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200/80 rounded-lg px-2.5 py-1.5 border-none focus:ring-1 focus:ring-emerald-500 focus:outline-none cursor-pointer">
                                        <option value="diskusi">❓ Tanya Jawab</option>
                                        <option value="showcase">📸 Pamer / Before-After</option>
                                        <option value="poll">📊 Poling Desain</option>
                                        @if($isAdmin)
                                            <option value="promosi" class="font-bold text-amber-700">🏷️ Promo Toko (Resmi)</option>
                                        @endif
                                    </select>

                                    <!-- Species Dropdown Selection -->
                                    <select name="species"
                                            class="text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200/80 rounded-lg px-2.5 py-1.5 border-none focus:ring-1 focus:ring-emerald-500 focus:outline-none cursor-pointer">
                                        <option value="Santigi Karang">Santigi Karang</option>
                                        <option value="Beringin Kimeng">Beringin Kimeng</option>
                                        <option value="Cemara Udang">Cemara Udang</option>
                                        <option value="Anting Putri">Anting Putri</option>
                                        <option value="Sancang">Sancang</option>
                                        <option value="Asam Jawa">Asam Jawa</option>
                                        <option value="Lainnya">Spesies Lainnya</option>
                                    </select>

                                    <input type="hidden" name="post_type" id="postTypeHidden" value="standard">
                                </div>

                                <button type="submit"
                                        class="py-1.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm hover:shadow flex items-center gap-1.5">
                                    <span>Terbitkan</span>
                                    <i class="fas fa-paper-plane text-[10px]"></i>
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Guest Callout to Post -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center text-sm">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-slate-800">Ingin ikut berdiskusi atau memamerkan koleksi?</p>
                                    <p class="text-[11px] text-slate-400">Masuk terlebih dahulu ke akun BonsaiKu Anda.</p>
                                </div>
                            </div>
                            <a href="{{ route('login') }}" class="py-1.5 px-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                                Masuk
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Feed Sort & Filter Toolbar -->
                @php
                    $currentSort = request('sort', 'latest');
                @endphp
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-700">Diskusi Komunitas</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    </div>

                    <div class="flex items-center space-x-1 bg-white p-1 rounded-xl border border-slate-200/80 text-xs">
                        <a href="{{ route('shop.komunitas', array_merge(request()->except('sort', 'page'), ['sort' => 'latest'])) }}"
                           class="px-3 py-1 rounded-lg font-bold transition {{ $currentSort === 'latest' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            Terbaru
                        </a>
                        <a href="{{ route('shop.komunitas', array_merge(request()->except('sort', 'page'), ['sort' => 'popular'])) }}"
                           class="px-3 py-1 rounded-lg font-bold transition {{ $currentSort === 'popular' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            Populer 🔥
                        </a>
                        <a href="{{ route('shop.komunitas', array_merge(request()->except('sort', 'page'), ['sort' => 'solved'])) }}"
                           class="px-3 py-1 rounded-lg font-bold transition {{ $currentSort === 'solved' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                            Solusi ✔
                        </a>
                    </div>
                </div>

                <!-- ================= POSTS FEED LIST ================= -->
                <div class="space-y-5">
                    @forelse($posts as $post)
                        @php
                            $author = $post->user;
                            $isAuthorAdmin = $author && $author->role === 'admin';
                            $authorInitial = $author ? strtoupper(substr($author->name, 0, 1)) : '?';
                            $userHasSubur = Auth::check() ? $post->isReactedBy(Auth::id(), 'subur') : false;
                            $userHasLike = Auth::check() ? $post->isReactedBy(Auth::id(), 'like') : false;
                        @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:border-slate-300 transition duration-200" id="post-card-{{ $post->id }}">
                            
                            <!-- Post Header -->
                            <div class="p-4 sm:p-5 pb-3">
                                <div class="flex items-start justify-between">
                                    
                                    <!-- Author Info & Badge -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-11 h-11 rounded-full {{ $isAuthorAdmin ? 'bg-emerald-800 p-1.5 ring-2 ring-emerald-300' : 'bg-emerald-500' }} text-white font-bold flex items-center justify-center text-sm shadow-xs flex-shrink-0 overflow-hidden">
                                            @if($author && $author->profile_photo_path)
                                                <img src="{{ asset('storage/' . $author->profile_photo_path) }}" alt="{{ $author->name }}" class="w-full h-full object-cover">
                                            @elseif($isAuthorAdmin)
                                                <img src="{{ asset('images/logonobg.png') }}" alt="Admin" class="w-full h-full object-contain">
                                            @else
                                                {{ $authorInitial }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5">
                                                <h3 class="text-sm font-bold text-slate-900">{{ $author ? $author->name : 'Pengguna' }}</h3>
                                                @if($isAuthorAdmin)
                                                    <i class="fas fa-check-circle text-emerald-600 text-xs" title="Toko Resmi"></i>
                                                @endif
                                                <span class="inline-block text-[10px] font-bold px-2 py-0.2 rounded-full border {{ $isAuthorAdmin ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}">
                                                    {{ $isAuthorAdmin ? '👑 Toko Resmi' : 'Kolektor' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-[11px] text-slate-400 mt-0.5">
                                                <span class="text-emerald-700 font-medium">#{{ $post->species ?: 'Bonsai' }}</span>
                                                <span>•</span>
                                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Category Pill & Delete Option -->
                                    <div class="flex items-center gap-2">
                                        @if($post->category === 'promosi')
                                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border bg-amber-100 text-amber-800 border-amber-200">
                                                ⚡ Promo Eksklusif Toko
                                            </span>
                                        @elseif($post->category === 'showcase' || $post->post_type === 'before_after')
                                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border bg-blue-100 text-blue-800 border-blue-200">
                                                📸 Transformasi Karya
                                            </span>
                                        @elseif($post->category === 'poll' || $post->post_type === 'poll')
                                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border bg-purple-100 text-purple-800 border-purple-200">
                                                📊 Poling Desain
                                            </span>
                                        @else
                                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full border bg-rose-100 text-rose-800 border-rose-200">
                                                ❓ Tanya Jawab
                                            </span>
                                        @endif

                                        @auth
                                            @if(Auth::id() === $post->user_id || Auth::user()->role === 'admin')
                                                <form action="{{ route('shop.komunitas.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition p-1" title="Hapus Postingan">
                                                        <i class="fas fa-trash-alt text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>

                                <!-- Post Text Content -->
                                <div class="mt-3.5 text-xs sm:text-sm text-slate-800 leading-relaxed whitespace-pre-line">
                                    {{ $post->content }}
                                </div>
                            </div>

                            <!-- ================= TYPE: FLASH SALE PROMO (KHUSUS TOKO RESMI) ================= -->
                            @if($post->post_type === 'flash_sale')
                                @if($post->discount_code || $post->flash_sale_ends_at)
                                    <div class="mx-4 sm:mx-5 mb-4 p-3 bg-gradient-to-r from-amber-500 via-emerald-600 to-teal-700 text-white rounded-xl flex items-center justify-between shadow-xs">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-stopwatch text-amber-200 text-base animate-pulse"></i>
                                            <div>
                                                <span class="text-[10px] uppercase font-bold tracking-wider text-amber-100 block">Flash Deal Komunitas:</span>
                                                <span class="text-sm font-mono font-extrabold countdown-timer">04:45:20</span>
                                            </div>
                                        </div>
                                        @if($post->discount_code)
                                            <div class="text-right">
                                                <span class="text-[10px] text-emerald-100 block">Kupon Diskon:</span>
                                                <button type="button" onclick="copyCoupon('{{ $post->discount_code }}')" 
                                                        class="px-2.5 py-0.5 rounded bg-white text-emerald-800 text-xs font-bold font-mono tracking-wider hover:bg-emerald-50 transition shadow-xs">
                                                    {{ $post->discount_code }} 📋
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Promo Images -->
                                @if(!empty($post->images))
                                    <div class="relative bg-slate-950 overflow-hidden max-h-[380px] flex items-center justify-center">
                                        <img src="{{ asset($post->images[0]) }}" alt="Foto Promo" class="w-full h-full object-cover">
                                    </div>
                                @endif

                                <!-- Linked Catalog Product -->
                                @if($post->bonsai)
                                    <div class="m-4 sm:m-5 p-3.5 bg-gradient-to-r from-emerald-50/80 via-teal-50/50 to-white rounded-xl border border-emerald-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
                                        <div class="flex items-center gap-3 w-full sm:w-auto">
                                            <div class="w-14 h-14 rounded-lg bg-white border border-emerald-100 overflow-hidden flex-shrink-0 shadow-xs">
                                                @if($post->bonsai->image_path)
                                                    <img src="{{ asset('storage/' . $post->bonsai->image_path) }}" alt="{{ $post->bonsai->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <img src="{{ asset('images/bghero.png') }}" alt="{{ $post->bonsai->name }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <div>
                                                <span class="inline-block text-[10px] font-bold tracking-wider uppercase text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded">
                                                    Katalog Resmi Khadir Florist
                                                </span>
                                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 mt-0.5">{{ $post->bonsai->name }}</h4>
                                                <p class="text-xs font-extrabold text-emerald-700 mt-0.5">
                                                    Rp {{ number_format($post->bonsai->current_value ?? 0, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('shop.produk.show', $post->bonsai->id) }}" 
                                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 py-2 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm flex-shrink-0">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Klaim & Beli Sekarang</span>
                                        </a>
                                    </div>
                                @endif

                            <!-- ================= TYPE: BEFORE VS AFTER SLIDER ================= -->
                            @elseif($post->post_type === 'before_after' && $post->before_image && $post->after_image)
                                <div class="relative w-full h-[360px] sm:h-[400px] overflow-hidden select-none bg-slate-950 before-after-container" id="ba-container-{{ $post->id }}">
                                    <!-- AFTER IMAGE (Background) -->
                                    <img src="{{ asset($post->after_image) }}" alt="Sesudah" class="absolute inset-0 w-full h-full object-cover pointer-events-none">
                                    <span class="absolute top-3 right-3 bg-emerald-900/80 backdrop-blur-md text-emerald-200 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-400/30 z-10">
                                        ✨ Sesudah
                                    </span>

                                    <!-- BEFORE IMAGE (Clipped Foreground) -->
                                    <div class="absolute inset-0 overflow-hidden pointer-events-none before-clip" style="width: 50%;">
                                        <img src="{{ asset($post->before_image) }}" alt="Sebelum" class="absolute inset-0 w-full h-full object-cover max-w-none" style="width: 100vw; max-width: 650px;">
                                        <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-md text-slate-200 text-[10px] font-bold px-2.5 py-1 rounded-full border border-white/20 z-10">
                                            ⏳ Sebelum
                                        </span>
                                    </div>

                                    <!-- Draggable Range Slider Bar -->
                                    <input type="range" min="0" max="100" value="50" 
                                           oninput="handleBeforeAfterSlide(this, 'ba-container-{{ $post->id }}')"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-ew-resize z-20">

                                    <!-- Divider Visual Line & Handle Icon -->
                                    <div class="absolute top-0 bottom-0 pointer-events-none divider-line z-10 flex items-center justify-center" style="left: 50%; transform: translateX(-50%);">
                                        <div class="w-0.5 h-full bg-white shadow-md"></div>
                                        <div class="absolute w-8 h-8 rounded-full bg-white text-emerald-700 shadow-xl flex items-center justify-center text-xs font-bold border border-slate-200">
                                            <i class="fas fa-arrows-alt-h"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-2 bg-slate-100 text-center text-[11px] text-slate-500 font-medium">
                                    👈 Geser slider ke kiri & kanan untuk membandingkan transformasi karya 👉
                                </div>

                            <!-- ================= TYPE: POLL INTERAKTIF ================= -->
                            @elseif($post->post_type === 'poll' && $post->poll)
                                @if(!empty($post->images))
                                    <div class="relative bg-slate-950 overflow-hidden max-h-[320px] flex items-center justify-center">
                                        <img src="{{ asset($post->images[0]) }}" alt="Foto Poling" class="w-full h-full object-cover">
                                    </div>
                                @endif

                                @php
                                    $poll = $post->poll;
                                    $userVoted = Auth::check() ? $poll->userVotedOption(Auth::id()) : null;
                                    $totalVotes = $poll->total_votes;
                                @endphp

                                <div class="m-4 sm:m-5 p-4 bg-slate-50 rounded-2xl border border-slate-200" id="poll-box-{{ $poll->id }}" data-poll-id="{{ $poll->id }}">
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                                        <i class="fas fa-poll text-purple-600"></i>
                                        <span>{{ $poll->question }}</span>
                                    </h4>

                                    <div class="space-y-2.5 poll-options-wrapper">
                                        @foreach($poll->options as $opt)
                                            @php
                                                $votes = $opt['votes'] ?? 0;
                                                $percent = $totalVotes > 0 ? round(($votes / $totalVotes) * 100) : 0;
                                                $isThisVoted = $userVoted === $opt['id'];
                                            @endphp
                                            <div onclick="submitVote('{{ $poll->id }}', '{{ $opt['id'] }}')"
                                                 class="poll-option relative p-3 rounded-xl border {{ $isThisVoted ? 'border-purple-500 ring-2 ring-purple-400' : 'border-slate-200 hover:border-purple-300' }} bg-white cursor-pointer transition overflow-hidden">
                                                <!-- Animated Progress Bar -->
                                                <div class="poll-bar absolute inset-0 bg-purple-100/70 transition-all duration-700" style="width: {{ $percent }}%;"></div>
                                                <div class="relative z-10 flex items-center justify-between text-xs font-semibold text-slate-800">
                                                    <span>{{ $opt['text'] }}</span>
                                                    <span class="font-bold text-purple-700 font-mono">{{ $percent }}%</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2.5 text-right total-votes-text">Total {{ $totalVotes }} kolektor telah memberikan suara</p>
                                </div>

                            <!-- ================= STANDARD PHOTO DISPLAY ================= -->
                            @elseif(!empty($post->images))
                                <div class="relative bg-slate-950 overflow-hidden max-h-[380px] flex items-center justify-center">
                                    <img src="{{ asset($post->images[0]) }}" alt="Foto Postingan" class="w-full h-full object-cover">
                                </div>
                            @endif

                            <!-- Action Bar: Reactions & Comments Counter -->
                            <div class="px-4 sm:px-5 py-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                                
                                <!-- Reaction Counters (AJAX Connected) -->
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="sendReaction('{{ $post->id }}', 'subur', this)"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg {{ $userHasSubur ? 'text-emerald-700 bg-emerald-50' : 'hover:bg-emerald-50 hover:text-emerald-700' }} font-semibold transition group">
                                        <span class="text-base group-hover:scale-125 transition-transform">🌿</span>
                                        <span>Subur</span>
                                        <span class="font-bold text-slate-700 subur-count">{{ $post->subur_count }}</span>
                                    </button>

                                    <button type="button" onclick="sendReaction('{{ $post->id }}', 'like', this)"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg {{ $userHasLike ? 'text-rose-600 bg-rose-50' : 'hover:bg-rose-50 hover:text-rose-600' }} font-semibold transition group">
                                        <i class="{{ $userHasLike ? 'fas' : 'far' }} fa-heart text-rose-500 group-hover:scale-125 transition-transform"></i>
                                        <span>Suka</span>
                                        <span class="font-bold text-slate-700 like-count">{{ $post->likes_count }}</span>
                                    </button>
                                </div>

                                <!-- Comment & Share Counters -->
                                <div class="flex items-center space-x-3 text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <i class="far fa-comment-dots text-slate-500"></i>
                                        <span class="font-medium text-slate-600">{{ $post->comments_count }} komentar</span>
                                    </span>
                                    <span>•</span>
                                    <button type="button" onclick="triggerMockAlert('Tautan postingan berhasil disalin ke clipboard!')" 
                                            class="hover:text-emerald-600 transition flex items-center gap-1" title="Bagikan">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Comment Section (Live Database) -->
                            <div class="bg-slate-50/70 border-t border-slate-100 p-4 sm:p-5 space-y-3">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Tanggapan Komunitas ({{ $post->comments->count() }})</span>
                                
                                @foreach($post->comments as $comment)
                                    @php
                                        $commentUser = $comment->user;
                                        $isCommentAdmin = $commentUser && $commentUser->role === 'admin';
                                        $canVerify = Auth::check() && (Auth::id() === $post->user_id || Auth::user()->role === 'admin');
                                    @endphp
                                    <div class="flex items-start space-x-3 text-xs" id="comment-box-{{ $comment->id }}">
                                        <div class="w-7 h-7 rounded-full {{ $isCommentAdmin ? 'bg-emerald-800' : 'bg-slate-300' }} text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0">
                                            @if($commentUser && $commentUser->profile_photo_path)
                                                <img src="{{ asset('storage/' . $commentUser->profile_photo_path) }}" alt="{{ $commentUser->name }}" class="w-full h-full object-cover rounded-full">
                                            @else
                                                {{ $commentUser ? strtoupper(substr($commentUser->name, 0, 1)) : '?' }}
                                            @endif
                                        </div>
                                        
                                        <!-- Comment Body & Solution Highlight -->
                                        <div class="flex-1 p-3 rounded-xl border shadow-xs transition {{ $comment->is_best_solution ? 'bg-emerald-50/90 border-emerald-300 ring-1 ring-emerald-300/40' : 'bg-white border-slate-200/70' }}">
                                            
                                            @if($comment->is_best_solution)
                                                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-extrabold mb-1.5 shadow-xs">
                                                    <i class="fas fa-check-circle"></i>
                                                    <span>🏆 Solusi Terverifikasi</span>
                                                </div>
                                            @endif

                                            <div class="flex items-center justify-between mb-1">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="font-bold text-slate-900">{{ $commentUser ? $commentUser->name : 'Member' }}</span>
                                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded {{ $isCommentAdmin ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                                                        {{ $isCommentAdmin ? 'Toko Resmi' : 'Member' }}
                                                    </span>
                                                </div>
                                                
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                    @if($canVerify)
                                                        <button type="button" onclick="toggleBestSolution('{{ $comment->id }}')"
                                                                class="text-[10px] font-semibold text-emerald-600 hover:text-emerald-800 transition" title="Tandai / Batalkan Solusi Terbaik">
                                                            <i class="fas fa-award"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="text-slate-700 leading-relaxed">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Comment Input Form -->
                                @auth
                                    <form action="{{ route('shop.komunitas.comment', $post->id) }}" method="POST" class="pt-2 flex items-center space-x-2">
                                        @csrf
                                        <input type="text" name="comment" required placeholder="Tulis komentar atau tanggapan..."
                                               class="w-full text-xs text-slate-800 placeholder-slate-400 bg-white rounded-xl py-2 px-3 border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition">
                                        <button type="submit"
                                                class="py-2 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition flex-shrink-0">
                                            Kirim
                                        </button>
                                    </form>
                                @else
                                    <div class="pt-2 text-center text-xs text-slate-500">
                                        <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Masuk</a> untuk menulis komentar diskusi.
                                    </div>
                                @endauth
                            </div>

                        </div>
                    @empty
                        <div class="bg-white rounded-2xl p-10 text-center border border-slate-200">
                            <i class="fas fa-leaf text-emerald-200 text-5xl mb-3"></i>
                            <h4 class="text-sm font-bold text-slate-800">Belum ada postingan dalam kategori ini.</h4>
                            <p class="text-xs text-slate-400 mt-1">Jadilah yang pertama memulai diskusi seru di komunitas!</p>
                        </div>
                    @endforelse

                    <!-- Pagination Links -->
                    <div class="pt-2">
                        {{ $posts->links() }}
                    </div>
                </div>

            </div>

            <!-- ================= RIGHT COLUMN: WIDGETS & RECOMMENDATIONS (3 COLS) ================= -->
            <div class="lg:col-span-3 space-y-5">
                
                <!-- Popular Hashtags Widget -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5">
                    <div class="flex items-center justify-between mb-3.5">
                        <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-fire text-amber-500"></i>
                            <span>Topik Hangat</span>
                        </h4>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('shop.komunitas', ['species' => 'Santigi Karang']) }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-lg hover:bg-emerald-50 text-xs text-slate-700 group transition">
                            <span class="font-bold text-slate-800 group-hover:text-emerald-700">#SantigiKarang</span>
                            <span class="text-[11px] text-slate-400 font-medium">Spesies Favorit</span>
                        </a>
                        <a href="{{ route('shop.komunitas', ['species' => 'Beringin Kimeng']) }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-lg hover:bg-emerald-50 text-xs text-slate-700 group transition">
                            <span class="font-bold text-slate-800 group-hover:text-emerald-700">#BeringinKimeng</span>
                            <span class="text-[11px] text-slate-400 font-medium">Bahan Primadona</span>
                        </a>
                        <a href="{{ route('shop.komunitas', ['species' => 'Cemara Udang']) }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-lg hover:bg-emerald-50 text-xs text-slate-700 group transition">
                            <span class="font-bold text-slate-800 group-hover:text-emerald-700">#CemaraUdang</span>
                            <span class="text-[11px] text-slate-400 font-medium">Koleksi Juara</span>
                        </a>
                        <a href="{{ route('shop.komunitas', ['category' => 'showcase']) }}" class="flex items-center justify-between py-1.5 px-2.5 rounded-lg hover:bg-emerald-50 text-xs text-slate-700 group transition">
                            <span class="font-bold text-slate-800 group-hover:text-emerald-700">#TransformasiKarya</span>
                            <span class="text-[11px] text-slate-400 font-medium">Before-After</span>
                        </a>
                    </div>
                </div>

                <!-- Featured Store Bonsais -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5">
                    <div class="flex items-center justify-between mb-3.5">
                        <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-leaf text-emerald-600"></i>
                            <span>Bonsai Pilihan Toko</span>
                        </h4>
                        <a href="{{ route('shop.produk') }}" class="text-[11px] font-bold text-emerald-600 hover:underline">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="space-y-3">
                        @forelse($featuredProducts as $item)
                            <a href="{{ route('shop.produk.show', $item->id) }}" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-200 group">
                                <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0">
                                    @if($item->image_path)
                                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                    @else
                                        <img src="{{ asset('images/b.jpg') }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h5 class="text-xs font-bold text-slate-800 truncate group-hover:text-emerald-700">{{ $item->name }}</h5>
                                    <p class="text-[11px] text-slate-400">{{ $item->species ?? 'Tanaman Hias' }}</p>
                                    <span class="text-xs font-extrabold text-emerald-700">
                                        Rp {{ number_format($item->current_value ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-2">Belum ada data bonsai.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Daily Tips Card -->
                <div class="bg-gradient-to-br from-slate-900 to-emerald-950 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
                    <div class="absolute -bottom-6 -right-6 w-28 h-28 rounded-full bg-emerald-500/20 blur-xl pointer-events-none"></div>
                    <div class="flex items-center gap-2 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">
                        <i class="fas fa-lightbulb"></i>
                        <span>Tips Singkat Hari Ini</span>
                    </div>
                    <p class="text-xs text-emerald-100/90 leading-relaxed">
                        "Jangan terburu-buru memupuk kimia pada bonsai yang baru saja dipangkas drastis atau ganti pot. Berikan waktu akar beradaptasi 10-14 hari dengan siraman vitamin B1."
                    </p>
                    <span class="block text-[10px] text-emerald-400/80 font-semibold mt-3 text-right">
                        — Tim Botani Khadir Florist
                    </span>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- ================= JAVASCRIPT INTERACTIONS ================= -->
<script>
    function focusCreatePost() {
        const input = document.getElementById('postInput');
        if (input) {
            input.focus();
            input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Dynamic Form Expander
    function handleCategoryChange(cat) {
        const baSec = document.getElementById('beforeAfterSection');
        const pollSec = document.getElementById('pollSection');
        const promoSec = document.getElementById('promosiSection');
        const typeHidden = document.getElementById('postTypeHidden');

        if (baSec) baSec.classList.add('hidden');
        if (pollSec) pollSec.classList.add('hidden');
        if (promoSec) promoSec.classList.add('hidden');

        if (cat === 'showcase') {
            if (baSec) baSec.classList.remove('hidden');
            typeHidden.value = 'before_after';
        } else if (cat === 'poll') {
            if (pollSec) pollSec.classList.remove('hidden');
            typeHidden.value = 'poll';
        } else if (cat === 'promosi') {
            if (promoSec) promoSec.classList.remove('hidden');
            typeHidden.value = 'flash_sale';
        } else {
            typeHidden.value = 'standard';
        }
    }

    function updateFileCountText(input) {
        const textSpan = document.getElementById('photoBtnText');
        if (input.files.length > 0) {
            textSpan.textContent = input.files.length + ' Foto Dipilih';
        } else {
            textSpan.textContent = 'Foto Bonsai';
        }
    }

    // Before After Slider Handler
    function handleBeforeAfterSlide(rangeInput, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const val = rangeInput.value;
        const beforeClip = container.querySelector('.before-clip');
        const dividerLine = container.querySelector('.divider-line');
        if (beforeClip) beforeClip.style.width = val + '%';
        if (dividerLine) dividerLine.style.left = val + '%';
    }

    // Reaction AJAX Handler
    async function sendReaction(postId, type, btn) {
        try {
            const res = await fetch(`/komunitas/post/${postId}/react`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type })
            });

            if (res.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            const data = await res.json();
            if (data.success) {
                const suburSpan = btn.closest('#post-card-' + postId).querySelector('.subur-count');
                const likeSpan = btn.closest('#post-card-' + postId).querySelector('.like-count');
                
                if (suburSpan) suburSpan.textContent = data.subur_count;
                if (likeSpan) likeSpan.textContent = data.likes_count;

                if (type === 'subur') {
                    if (data.active) {
                        btn.classList.add('text-emerald-700', 'bg-emerald-50');
                    } else {
                        btn.classList.remove('text-emerald-700', 'bg-emerald-50');
                    }
                } else {
                    const icon = btn.querySelector('i');
                    if (data.active) {
                        btn.classList.add('text-rose-600', 'bg-rose-50');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        btn.classList.remove('text-rose-600', 'bg-rose-50');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                }
            }
        } catch (e) {
            console.error('Reaction error', e);
        }
    }

    // Best Solution AJAX Handler
    async function toggleBestSolution(commentId) {
        try {
            const res = await fetch(`/komunitas/comment/${commentId}/best-solution`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                location.reload();
            } else {
                triggerMockAlert(data.message || 'Gagal mengubah status solusi.');
            }
        } catch (e) {
            console.error('Error toggling solution', e);
        }
    }

    // Submit Poll Vote AJAX Handler
    async function submitVote(pollId, optionId) {
        try {
            const res = await fetch(`/komunitas/poll/${pollId}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ option_id: optionId })
            });

            if (res.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            const data = await res.json();
            if (data.success) {
                const pollBox = document.getElementById('poll-box-' + pollId);
                if (pollBox) {
                    const wrapper = pollBox.querySelector('.poll-options-wrapper');
                    wrapper.innerHTML = '';
                    data.options.forEach(opt => {
                        const isVoted = opt.id === data.voted_option;
                        const optDiv = document.createElement('div');
                        optDiv.className = `poll-option relative p-3 rounded-xl border ${isVoted ? 'border-purple-500 ring-2 ring-purple-400' : 'border-slate-200'} bg-white transition overflow-hidden`;
                        optDiv.innerHTML = `
                            <div class="poll-bar absolute inset-0 bg-purple-100/70 transition-all duration-700" style="width: ${opt.percent}%;"></div>
                            <div class="relative z-10 flex items-center justify-between text-xs font-semibold text-slate-800">
                                <span>${opt.text}</span>
                                <span class="font-bold text-purple-700 font-mono">${opt.percent}%</span>
                            </div>
                        `;
                        wrapper.appendChild(optDiv);
                    });

                    const totalText = pollBox.querySelector('.total-votes-text');
                    if (totalText) {
                        totalText.textContent = `Total ${data.total_votes} kolektor telah memberikan suara`;
                    }
                }
                triggerMockAlert(data.message);
            } else {
                triggerMockAlert(data.message || 'Gagal memberikan suara.');
            }
        } catch (e) {
            console.error('Vote error', e);
        }
    }

    // Copy Coupon
    function copyCoupon(code) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(code);
        }
        triggerMockAlert('Kode voucher ' + code + ' disalin! Gunakan saat checkout belanja.');
    }

    // Mock Alert Helper
    function triggerMockAlert(msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Komunitas BonsaiKu',
                text: msg,
                confirmButtonColor: '#059669',
                confirmButtonText: 'Oke Mengerti'
            });
        } else {
            alert(msg);
        }
    }

    // Countdown Timer Simulation
    setInterval(function() {
        document.querySelectorAll('.countdown-timer').forEach(el => {
            let parts = el.textContent.split(':');
            if (parts.length === 3) {
                let h = parseInt(parts[0]), m = parseInt(parts[1]), s = parseInt(parts[2]);
                if (s > 0) s--;
                else {
                    s = 59;
                    if (m > 0) m--;
                    else { m = 59; if (h > 0) h--; }
                }
                el.textContent = String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            }
        });
    }, 1000);
</script>
@endsection
