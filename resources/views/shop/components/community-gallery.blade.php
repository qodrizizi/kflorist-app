@php
    $rawImages = $images ?? [];
    if (!is_array($rawImages)) {
        $rawImages = [];
    }
    $imgCount = count($rawImages);
    $formattedImages = array_map(function($img) {
        return str_starts_with($img, 'http') ? $img : asset($img);
    }, $rawImages);
    $imagesJson = json_encode($formattedImages);
@endphp

@if($imgCount > 0)
    <div class="community-gallery w-full bg-slate-950 overflow-hidden select-none">
        @if($imgCount === 1)
            <!-- 1 Image: Full Width -->
            <div class="relative max-h-[460px] overflow-hidden flex items-center justify-center cursor-pointer group"
                 onclick="openLightbox({{ $imagesJson }}, 0)">
                <img src="{{ $formattedImages[0] }}" 
                     alt="Foto Bonsai" 
                     loading="lazy"
                     class="w-full h-full max-h-[460px] object-cover transition-transform duration-300 group-hover:scale-102">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-between p-3.5 pointer-events-none">
                    <span class="px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-xs font-semibold flex items-center gap-1.5 shadow-lg border border-white/15">
                        <i class="fas fa-search-plus text-emerald-400"></i> Klik untuk memperbesar
                    </span>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[11px] font-bold backdrop-blur-md">
                        1 Foto
                    </span>
                </div>
            </div>

        @elseif($imgCount === 2)
            <!-- 2 Images: 50 / 50 Grid -->
            <div class="grid grid-cols-2 gap-1 max-h-[360px] sm:max-h-[380px] overflow-hidden">
                @foreach($formattedImages as $idx => $imgUrl)
                    <div class="relative h-60 sm:h-72 overflow-hidden cursor-pointer group"
                         onclick="openLightbox({{ $imagesJson }}, {{ $idx }})">
                        <img src="{{ $imgUrl }}" 
                             alt="Foto Bonsai {{ $idx + 1 }}" 
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/25 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none">
                            <span class="w-10 h-10 rounded-full bg-slate-900/80 text-white flex items-center justify-center text-sm shadow-xl border border-white/20">
                                <i class="fas fa-expand"></i>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        @elseif($imgCount === 3)
            <!-- 3 Images: 1 Left Big (2 cols) + 2 Right Stacked (1 col) -->
            <div class="grid grid-cols-3 gap-1 max-h-[380px] sm:max-h-[420px] overflow-hidden">
                <div class="col-span-2 h-72 sm:h-80 relative overflow-hidden cursor-pointer group"
                     onclick="openLightbox({{ $imagesJson }}, 0)">
                    <img src="{{ $formattedImages[0] }}" 
                         alt="Foto Bonsai 1" 
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/25 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none">
                        <span class="w-10 h-10 rounded-full bg-slate-900/80 text-white flex items-center justify-center text-sm shadow-xl border border-white/20">
                            <i class="fas fa-expand"></i>
                        </span>
                    </div>
                </div>
                <div class="col-span-1 grid grid-rows-2 gap-1 h-72 sm:h-80">
                    @for($i = 1; $i <= 2; $i++)
                        <div class="relative h-full overflow-hidden cursor-pointer group"
                             onclick="openLightbox({{ $imagesJson }}, {{ $i }})">
                            <img src="{{ $formattedImages[$i] }}" 
                                 alt="Foto Bonsai {{ $i + 1 }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/25 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none">
                                <span class="w-8 h-8 rounded-full bg-slate-900/80 text-white flex items-center justify-center text-xs shadow-xl border border-white/20">
                                    <i class="fas fa-expand"></i>
                                </span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

        @elseif($imgCount === 4)
            <!-- 4 Images: 2x2 Grid -->
            <div class="grid grid-cols-2 gap-1 max-h-[380px] sm:max-h-[420px] overflow-hidden">
                @foreach($formattedImages as $idx => $imgUrl)
                    <div class="relative h-44 sm:h-48 overflow-hidden cursor-pointer group"
                         onclick="openLightbox({{ $imagesJson }}, {{ $idx }})">
                        <img src="{{ $imgUrl }}" 
                             alt="Foto Bonsai {{ $idx + 1 }}" 
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/25 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none">
                            <span class="w-8 h-8 rounded-full bg-slate-900/80 text-white flex items-center justify-center text-xs shadow-xl border border-white/20">
                                <i class="fas fa-expand"></i>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- 5+ Images: 2x2 Grid with +N Badge on 4th image -->
            <div class="grid grid-cols-2 gap-1 max-h-[380px] sm:max-h-[420px] overflow-hidden">
                @for($idx = 0; $idx < 3; $idx++)
                    <div class="relative h-44 sm:h-48 overflow-hidden cursor-pointer group"
                         onclick="openLightbox({{ $imagesJson }}, {{ $idx }})">
                        <img src="{{ $formattedImages[$idx] }}" 
                             alt="Foto Bonsai {{ $idx + 1 }}" 
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-950/0 group-hover:bg-slate-950/25 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100 pointer-events-none">
                            <span class="w-8 h-8 rounded-full bg-slate-900/80 text-white flex items-center justify-center text-xs shadow-xl border border-white/20">
                                <i class="fas fa-expand"></i>
                            </span>
                        </div>
                    </div>
                @endfor
                <!-- 4th item with overlay -->
                <div class="relative h-44 sm:h-48 overflow-hidden cursor-pointer group"
                     onclick="openLightbox({{ $imagesJson }}, 3)">
                    <img src="{{ $formattedImages[3] }}" 
                         alt="Foto Bonsai 4" 
                         loading="lazy"
                         class="w-full h-full object-cover brightness-75">
                    <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-[2px] flex flex-col items-center justify-center text-white transition group-hover:bg-slate-950/60">
                        <span class="text-2xl sm:text-3xl font-black font-mono tracking-tight">+{{ $imgCount - 3 }}</span>
                        <span class="text-[11px] font-bold tracking-wider uppercase text-emerald-300 mt-1 flex items-center gap-1">
                            <i class="fas fa-images"></i> Lihat Semua
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endif
