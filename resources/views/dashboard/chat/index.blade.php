@extends('layouts.app')

@section('title', 'Pesan Chat')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Pesan Chat</h2>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola percakapan dengan pelanggan Anda.</p>
</div>

<div x-data="adminChatList()" x-init="init()" class="dash-card overflow-hidden">
    <div class="divide-y divide-slate-100 dark:divide-slate-800">
        <template x-for="chat in chats" :key="chat.id">
            <a :href="'/dashboard/chat/' + chat.id" class="flex items-center gap-4 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition group">
                <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold text-lg" x-text="chat.name.charAt(0).toUpperCase()">
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 transition-colors" x-text="chat.name"></h3>
                        <div class="flex items-center gap-2">
                            <span x-show="chat.unread_count > 0" x-text="chat.unread_count" 
                                  class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                            </span>
                            <span class="text-[10px] text-slate-400" x-text="chat.email"></span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">
                        Klik untuk membuka percakapan
                    </p>
                </div>
                <div class="text-slate-300 dark:text-slate-600">
                    <i class="fas fa-chevron-right text-xs"></i>
                </div>
            </a>
        </template>
        
        <div x-show="chats.length === 0" class="py-20 text-center text-slate-400">
            <i class="fas fa-comments text-4xl mb-3 block opacity-20"></i>
            <p class="text-sm">Belum ada percakapan masuk</p>
        </div>
    </div>
</div>

<script>
    function adminChatList() {
        return {
            chats: @json($chats),
            isFetching: false,
            
            init() {
                if (window.Echo) {
                    window.Echo.private('chat.{{ Auth::id() }}')
                        .listen('.message.sent', () => {
                            this.fetchChats();
                        });
                }

                // Fallback sync inbox list tiap 10 detik (hanya saat tab aktif)
                setInterval(() => {
                    if (!document.hidden && !this.isFetching) {
                        this.fetchChats();
                    }
                }, 10000);
            },

            async fetchChats() {
                if (this.isFetching) return;
                this.isFetching = true;
                try {
                    const res = await fetch('{{ route('dashboard.chat.index') }}', {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data && data.chats) {
                        if (JSON.stringify(this.chats) !== JSON.stringify(data.chats)) {
                            this.chats = data.chats;
                        }
                    }
                } catch (e) { console.error('Fetch chats error', e); }
                finally {
                    this.isFetching = false;
                }
            }
        }
    }
</script>
@endsection
