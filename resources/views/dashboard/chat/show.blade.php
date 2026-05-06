@extends('layouts.app')

@section('title', 'Chat with ' . $user->name)

@section('content')
<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('dashboard.chat.index') }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
        <i class="fas fa-arrow-left text-sm"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">{{ $user->name }}</h2>
        <p class="text-[11px] text-slate-400">{{ $user->email }}</p>
    </div>
</div>

<div x-data="adminChat()" x-init="init()" class="flex flex-col h-[calc(100vh-220px)] dash-card overflow-hidden">
    <!-- Messages Area -->
    <div id="admin-chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50/50 dark:bg-slate-950/20">
        <template x-for="msg in messages" :key="msg.id">
            <div class="flex" :class="msg.sender_id === '{{ Auth::id() }}' ? 'justify-end' : 'justify-start'">
                <div :class="msg.sender_id === '{{ Auth::id() }}' ? 'bg-emerald-600 text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-r-2xl rounded-tl-2xl border border-slate-100 dark:border-slate-700'" 
                     class="max-w-[80%] px-4 py-2.5 shadow-sm">
                    
                    <!-- Attachment Display -->
                    <template x-if="msg.attachment_path">
                        <div class="mb-2">
                            <template x-if="msg.attachment_type === 'image'">
                                <img :src="'/storage/' + msg.attachment_path" class="rounded-lg max-w-full h-auto cursor-pointer hover:opacity-90" @click="window.open('/storage/' + msg.attachment_path)">
                            </template>
                            <template x-if="msg.attachment_type === 'video'">
                                <video controls class="rounded-lg max-w-full h-auto">
                                    <source :src="'/storage/' + msg.attachment_path" type="video/mp4">
                                </video>
                            </template>
                        </div>
                    </template>

                    <p x-show="msg.message" class="text-sm leading-relaxed" x-text="msg.message"></p>
                    <p class="text-[9px] mt-1 opacity-60" :class="msg.sender_id === '{{ Auth::id() }}' ? 'text-right' : ''" x-text="formatTime(msg.created_at)"></p>
                </div>
            </div>
        </template>
        <div x-show="messages.length === 0" class="text-center py-20 text-slate-400">
            <p class="text-sm">Belum ada pesan</p>
        </div>
    </div>

    <!-- Preview Area -->
    <div x-show="filePreview" class="p-4 bg-slate-100 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <template x-if="fileType === 'image'">
                <img :src="filePreview" class="w-12 h-12 rounded object-cover">
            </template>
            <template x-if="fileType === 'video'">
                <div class="w-12 h-12 rounded bg-black flex items-center justify-center text-white">
                    <i class="fas fa-video text-xs"></i>
                </div>
            </template>
            <span class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-[200px]" x-text="fileName"></span>
        </div>
        <button @click="clearFile()" class="text-red-500 hover:text-red-600">
            <i class="fas fa-times-circle"></i>
        </button>
    </div>

    <!-- Input Area -->
    <div class="p-4 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
        <form @submit.prevent="sendMessage()" class="flex items-end gap-2">
            <button type="button" @click="$refs.fileInput.click()" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition">
                <i class="fas fa-paperclip text-lg"></i>
            </button>
            <input type="file" x-ref="fileInput" class="hidden" @change="handleFileSelect($event)" accept="image/*,video/*">
            
            <textarea x-model="newMessage" rows="1" placeholder="Tulis pesan..." @keydown.enter.prevent="sendMessage()"
                   class="flex-1 px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition resize-none"></textarea>
            
            <button type="submit" :disabled="!newMessage.trim() && !fileSelected" 
                    class="w-10 h-10 flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-lg transition-all active:scale-95 disabled:opacity-50">
                <i class="fas fa-paper-plane text-sm"></i>
            </button>
        </form>
    </div>
</div>

<script>
    function adminChat() {
        return {
            messages: @json($messages),
            newMessage: '',
            userId: '{{ $user->id }}',
            fileSelected: null,
            filePreview: null,
            fileType: null,
            fileName: '',

            init() {
                this.$nextTick(() => this.scrollToBottom());
                setInterval(() => this.fetchMessages(), 3000);
            },

            handleFileSelect(e) {
                const file = e.target.files[0];
                if (!file) return;

                this.fileSelected = file;
                this.fileName = file.name;
                this.fileType = file.type.includes('image') ? 'image' : 'video';

                if (this.fileType === 'image') {
                    const reader = new FileReader();
                    reader.onload = (e) => this.filePreview = e.target.result;
                    reader.readAsDataURL(file);
                } else {
                    this.filePreview = 'video';
                }
            },

            clearFile() {
                this.fileSelected = null;
                this.filePreview = null;
                this.fileType = null;
                this.fileName = '';
                this.$refs.fileInput.value = '';
            },

            async fetchMessages() {
                try {
                    const res = await fetch('{{ route('dashboard.chat.messages', $user->id) }}');
                    const data = await res.json();
                    
                    if (data.messages.length > this.messages.length) {
                        this.messages = data.messages;
                        this.$nextTick(() => this.scrollToBottom());
                    }
                } catch (e) { console.error('Fetch error', e); }
            },

            async sendMessage() {
                if (!this.newMessage.trim() && !this.fileSelected) return;
                
                const formData = new FormData();
                formData.append('message', this.newMessage);
                formData.append('receiver_id', this.userId);
                if (this.fileSelected) {
                    formData.append('attachment', this.fileSelected);
                }

                this.newMessage = '';
                this.clearFile();

                try {
                    const res = await fetch('{{ route('dashboard.chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await res.json();
                    if (data.success) {
                        this.messages.push(data.message);
                        this.$nextTick(() => this.scrollToBottom());
                    }
                } catch (e) { console.error('Send error', e); }
            },

            scrollToBottom() {
                const box = document.getElementById('admin-chat-box');
                if (box) box.scrollTop = box.scrollHeight;
            },

            formatTime(dateStr) {
                const date = new Date(dateStr);
                return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
            }
        }
    }
</script>
@endsection
