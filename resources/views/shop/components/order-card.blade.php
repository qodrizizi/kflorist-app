@php
    $statusMap = [
        'pending' => [
            'label' => 'Belum Bayar',
            'badge' => 'bg-amber-50 text-amber-700 border-amber-200',
            'dot' => 'bg-amber-400 animate-pulse',
            'icon' => 'fa-wallet'
        ],
        'diproses' => [
            'label' => 'Sedang Diproses',
            'badge' => 'bg-sky-50 text-sky-700 border-sky-200',
            'dot' => 'bg-sky-500',
            'icon' => 'fa-box-open'
        ],
        'dikirim' => [
            'label' => 'Dalam Pengiriman',
            'badge' => 'bg-purple-50 text-purple-700 border-purple-200',
            'dot' => 'bg-purple-500 animate-pulse',
            'icon' => 'fa-truck-fast'
        ],
        'selesai' => [
            'label' => 'Pesanan Selesai',
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'dot' => 'bg-emerald-500',
            'icon' => 'fa-circle-check'
        ],
        'dibatalkan' => [
            'label' => 'Dibatalkan',
            'badge' => 'bg-rose-50 text-rose-700 border-rose-200',
            'dot' => 'bg-rose-400',
            'icon' => 'fa-ban'
        ],
    ];

    $curr = $statusMap[$order->status] ?? [
        'label' => ucfirst($order->status),
        'badge' => 'bg-slate-100 text-slate-700 border-slate-200',
        'dot' => 'bg-slate-400',
        'icon' => 'fa-info-circle'
    ];
@endphp

<div class="bg-white border border-slate-200/90 rounded-3xl p-6 md:p-7 shadow-sm hover:shadow-xl transition-all duration-300 hover:border-emerald-300/80 group">
    
    <!-- CARD TOP HEADER -->
    <div class="flex flex-wrap items-center justify-between gap-3 pb-5 border-b border-slate-100">
        <div class="flex flex-wrap items-center gap-2.5">
            <div class="inline-flex items-center gap-2 font-mono text-xs md:text-sm font-extrabold text-slate-800 bg-slate-50 border border-slate-200/80 px-3 py-1.5 rounded-xl">
                <i class="fas fa-file-invoice text-emerald-600"></i>
                <span>{{ $order->order_code }}</span>
            </div>
            <span class="text-xs text-slate-400 flex items-center gap-1.5">
                <i class="far fa-clock"></i>
                {{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB
            </span>
        </div>

        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider border {{ $curr['badge'] }}">
            <span class="w-2 h-2 rounded-full {{ $curr['dot'] }}"></span>
            <i class="fas {{ $curr['icon'] }} text-[11px]"></i>
            <span>{{ $curr['label'] }}</span>
        </span>
    </div>

    <!-- CARD MAIN BODY -->
    <div class="flex flex-col sm:flex-row gap-5 md:gap-6 my-5">
        <!-- Bonsai Thumbnail Image -->
        <div class="w-full sm:w-24 sm:h-24 md:w-28 md:h-28 aspect-video sm:aspect-square shrink-0 bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 relative shadow-2xs">
            @if($order->bonsai && $order->bonsai->image_path)
                <img src="{{ asset('storage/' . $order->bonsai->image_path) }}" alt="{{ $order->bonsai->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-emerald-400">
                    <i class="fas fa-seedling text-3xl"></i>
                </div>
            @endif
        </div>

        <!-- Bonsai Details -->
        <div class="flex-grow space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                @if($order->bonsai && $order->bonsai->category)
                    <span class="text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-md border border-emerald-100">
                        {{ $order->bonsai->category->name }}
                    </span>
                @endif
                <h3 class="text-base md:text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors">
                    {{ $order->bonsai ? $order->bonsai->name : 'Pohon Bonsai' }}
                </h3>
            </div>

            <p class="text-xs md:text-sm text-slate-500 font-medium">
                {{ $order->quantity }} Pohon × <span class="font-mono text-slate-700">Rp {{ number_format($order->bonsai ? $order->bonsai->current_value : ($order->total_price / max(1, $order->quantity)), 0, ',', '.') }}</span>
            </p>

            @if($order->catatan)
                <div class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-150 flex items-start gap-2">
                    <i class="fas fa-comment-dots text-emerald-600 mt-0.5 shrink-0"></i>
                    <span class="italic">"{{ $order->catatan }}"</span>
                </div>
            @endif
        </div>

        <!-- Total Price Block -->
        <div class="sm:text-right border-t sm:border-t-0 sm:border-l border-slate-100 pt-4 sm:pt-0 sm:pl-6 flex flex-col justify-center shrink-0">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Belanja</span>
            <span class="text-xl md:text-2xl font-black text-emerald-600 font-mono tracking-tight">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- CARD FOOTER ACTIONS -->
    <div class="border-t border-slate-100 pt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="text-[11px] text-slate-400 font-medium hidden sm:flex items-center gap-1.5">
            <i class="fas fa-shield-halved text-emerald-600"></i>
            <span>Garansi hidup peti kayu resmi RUANGBONSAI</span>
        </div>

        <div class="flex flex-wrap items-center justify-end gap-2.5 w-full sm:w-auto">
            
            <!-- Aksi: Belum Bayar -->
            @if($order->status === 'pending')
                <a href="{{ route('shop.pesanan.pay', $order->id) }}" class="w-full sm:w-auto justify-center bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-6 py-2.5 rounded-xl font-extrabold shadow-md hover:shadow-lg transition-all text-xs md:text-sm flex items-center gap-2 transform hover:-translate-y-0.5">
                    <i class="fas fa-wallet text-sm"></i>
                    <span>Bayar Sekarang</span>
                </a>
            @endif

            <!-- Aksi: Chat Penjual -->
            @if(in_array($order->status, ['diproses', 'dikirim']))
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20RUANGBONSAI,%20saya%20ingin%20bertanya%20tentang%20pesanan%20{{ $order->order_code }}" target="_blank" class="w-full sm:w-auto justify-center bg-white border border-emerald-500 text-emerald-700 hover:bg-emerald-50 px-4 py-2.5 rounded-xl font-bold shadow-2xs transition-all text-xs md:text-sm flex items-center gap-2">
                    <i class="fab fa-whatsapp text-emerald-600 text-base"></i>
                    <span>Chat Penjual</span>
                </a>
            @endif

            <!-- Aksi: Lacak Pengiriman -->
            @if($order->status === 'dikirim')
                <button onclick="lacakPengiriman('{{ $order->order_code }}')" class="w-full sm:w-auto justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-xs hover:shadow-md transition-all text-xs md:text-sm flex items-center gap-2">
                    <i class="fas fa-truck-fast"></i>
                    <span>Lacak Pengiriman</span>
                </button>

                <form action="{{ route('shop.pesanan.complete', $order->id) }}" method="POST" class="inline-block w-full sm:w-auto">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="w-full justify-center bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-xs hover:shadow-md transition-all text-xs md:text-sm flex items-center gap-2">
                        <i class="fas fa-box-open"></i>
                        <span>Pesanan Diterima</span>
                    </button>
                </form>
            @endif

            <!-- Aksi: Download Struk Resmi (PDF) -->
            @if(in_array($order->status, ['diproses', 'dikirim', 'selesai']))
                <a href="{{ route('shop.pesanan.struk', $order->id) }}" onclick="downloadStrukPdf(event, this.href)" class="w-full sm:w-auto justify-center bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 hover:text-emerald-700 px-4 py-2.5 rounded-xl font-bold shadow-2xs transition-all text-xs md:text-sm flex items-center gap-2">
                    <i class="fas fa-file-pdf text-emerald-600"></i>
                    <span>Download Struk (PDF)</span>
                </a>
            @endif

            <!-- Aksi: Rating & Ulasan -->
            @if($order->status === 'selesai')
                @php
                    $userReview = $order->bonsai ? $order->bonsai->reviews->first() : null;
                @endphp

                @if($userReview)
                    @php
                        $reviewData = [
                            "rating" => $userReview->rating,
                            "comment" => $userReview->comment,
                            "image" => $userReview->image_path ? asset("storage/" . $userReview->image_path) : null,
                            "date" => $userReview->created_at->format("d M Y")
                        ];
                    @endphp
                    <button onclick='lihatReview(@json($reviewData), "{{ $order->bonsai ? $order->bonsai->name : 'Pohon Bonsai' }}")' class="w-full sm:w-auto justify-center bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-2.5 rounded-xl font-bold hover:bg-emerald-100 transition-all text-xs md:text-sm flex items-center gap-2">
                        <i class="fas fa-circle-check text-emerald-600"></i>
                        <span>Sudah Dinilai</span>
                    </button>
                @else
                    <button onclick="beriRating('{{ $order->bonsai_id }}', '{{ $order->bonsai ? $order->bonsai->name : 'Pohon Bonsai' }}')" class="w-full sm:w-auto justify-center bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-white px-5 py-2.5 rounded-xl font-extrabold shadow-sm hover:shadow-md transition-all text-xs md:text-sm flex items-center gap-2">
                        <i class="fas fa-star text-white"></i>
                        <span>Beri Penilaian</span>
                    </button>
                @endif
            @endif

        </div>
    </div>
</div>
