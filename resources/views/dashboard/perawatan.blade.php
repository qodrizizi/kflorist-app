@extends('layouts.app')

@section('title', 'Jadwal Perawatan')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-white mb-2">
                Jadwal Perawatan 📅
            </h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-slate-400 font-medium">Jangan lewatkan satu pun perawatan penting untuk koleksi Anda.</p>
        </div>
        <button onclick="openAddTaskModal()" class="bg-gradient-to-r from-bonsai-500 to-bonsai-600 hover:from-bonsai-600 hover:to-bonsai-700 text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
            <span class="text-xl">➕</span>
            <span class="hidden sm:inline">Tambah Tugas</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="stat-card bg-white dark:bg-slate-900 rounded-xl p-4 md:p-6 shadow-md border-l-4 border-blue-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400 mb-1 font-medium uppercase tracking-wide">Tugas Mendatang</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['upcoming'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">🗓️</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white dark:bg-slate-900 rounded-xl p-4 md:p-6 shadow-md border-l-4 border-red-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400 mb-1 font-medium uppercase tracking-wide">Tugas Terlewat</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['overdue'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">⚠️</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white dark:bg-slate-900 rounded-xl p-4 md:p-6 shadow-md border-l-4 border-amber-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-slate-400 mb-1 font-medium uppercase tracking-wide">Bonsai Butuh Perhatian</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['needing_care'] ?? 0 }}</p>
                </div>
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">🌿</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-3xl shadow-xl p-6 border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <button onclick="prevMonth()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <i class="fas fa-chevron-left text-slate-400"></i>
                </button>
                <h3 id="currentMonth" class="text-xl font-bold text-slate-800 dark:text-white uppercase tracking-tight">...</h3>
                <button onclick="nextMonth()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <i class="fas fa-chevron-right text-slate-400"></i>
                </button>
            </div>
            <div class="grid grid-cols-7 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">
                <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
            </div>
            <div id="calendar-grid" class="grid grid-cols-7 gap-3"></div>
        </div>

        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl p-6 border border-slate-200 dark:border-slate-800 flex-1">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Tugas Hari Ini</h3>
                    <span id="currentDate" class="text-[10px] font-bold text-emerald-600 px-2 py-1 bg-emerald-50 dark:bg-emerald-500/10 rounded-lg">...</span>
                </div>
                <div id="taskList" class="space-y-4">
                    <!-- Today's tasks will be injected here -->
                </div>
            </div>
        </div>
    </div>

    {{-- RIWAYAT PERAWATAN --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Riwayat Semua Perawatan</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-1">Selesai: {{ $stats['total_selesai'] }} • Terjadwal: {{ $stats['total_terjadwal'] }}</p>
            </div>
            <form action="{{ route('dashboard.perawatan') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bonsai..." 
                           class="pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition-all w-full md:w-48">
                </div>
                <select name="status" @change="$el.form.submit()" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dijadwalkan" {{ request('status') == 'dijadwalkan' ? 'selected' : '' }}>Terjadwal</option>
                </select>
                <select name="jenis" @change="$el.form.submit()" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                    <option value="">Semua Jenis</option>
                    <option value="penyiraman" {{ request('jenis') == 'penyiraman' ? 'selected' : '' }}>💧 Penyiraman</option>
                    <option value="pemupukan" {{ request('jenis') == 'pemupukan' ? 'selected' : '' }}>🌿 Pemupukan</option>
                    <option value="pemangkasan" {{ request('jenis') == 'pemangkasan' ? 'selected' : '' }}>✂️ Pemangkasan</option>
                    <option value="repotting" {{ request('jenis') == 'repotting' ? 'selected' : '' }}>🪴 Ganti Pot</option>
                    <option value="obat" {{ request('jenis') == 'obat' ? 'selected' : '' }}>🧪 Obat</option>
                </select>
                @if(request('search') || request('status') || request('jenis'))
                    <a href="{{ route('dashboard.perawatan') }}" class="w-8 h-8 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-400 rounded-xl hover:text-red-500 transition-colors" title="Reset Filter">
                        <i class="fas fa-times text-xs"></i>
                    </a>
                @endif
                <button type="submit" class="hidden md:flex px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-all">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bonsai</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tugas</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($riwayat as $p)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-bold text-slate-800 dark:text-white">{{ $p->bonsai->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $p->bonsai->code }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-600 dark:text-slate-300 capitalize">{{ str_replace('_', ' ', $p->jenis_perawatan) }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">{{ $p->tanggal_perawatan->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase {{ $p->status === 'selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @if($p->status === 'dijadwalkan')
                                        <form action="{{ route('dashboard.perawatan.status', $p->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" title="Tandai Selesai" class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all">
                                                <i class="fas fa-check text-[10px]"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('dashboard.perawatan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-xs">Belum ada riwayat perawatan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($riwayat->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                {{ $riwayat->links() }}
            </div>
        @endif
    </div>

    <div id="addTaskModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden overflow-y-auto">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-lg w-full transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Buat Tugas Baru</h3>
                    <button onclick="closeAddTaskModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                <div class="p-6">
                    <form id="addTaskForm" action="{{ route('dashboard.perawatan.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div x-data="{ selectAll: false }">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Pilih Bonsai</label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" x-model="selectAll" @change="if(selectAll) { $el.closest('form').querySelectorAll('.bonsai-check').forEach(c => c.checked = true) } else { $el.closest('form').querySelectorAll('.bonsai-check').forEach(c => c.checked = false) }" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase group-hover:text-emerald-600 transition-colors">Semua Koleksi</span>
                                </label>
                            </div>
                            <div class="max-h-40 overflow-y-auto p-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl space-y-2">
                                @foreach($bonsais as $bonsai)
                                    <label class="flex items-center gap-3 p-2 hover:bg-white dark:hover:bg-slate-700 rounded-xl cursor-pointer transition-colors group">
                                        <input type="checkbox" name="bonsai_ids[]" value="{{ $bonsai->id }}" class="bonsai-check w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-700 dark:text-slate-200 truncate group-hover:text-emerald-600 transition-colors">{{ $bonsai->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">{{ $bonsai->code }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Tugas</label>
                                <select name="jenis_perawatan" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-200 transition-all">
                                    <option value="penyiraman">💧 Penyiraman</option>
                                    <option value="pemupukan">🌿 Pemupukan</option>
                                    <option value="pemangkasan">✂️ Pemangkasan</option>
                                    <option value="repotting">🪴 Ganti Pot</option>
                                    <option value="obat">🧪 Pemberian Obat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status</label>
                                <select name="status" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-200 transition-all">
                                    <option value="dijadwalkan">🗓️ Dijadwalkan</option>
                                    <option value="selesai">✅ Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal</label>
                            <input type="date" name="tanggal_perawatan" required value="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-200 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan (Opsional)</label>
                            <textarea name="catatan" rows="3" placeholder="Tambahkan instruksi khusus..."
                                      class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-200 transition-all"></textarea>
                        </div>
                        <div class="pt-4 flex gap-3">
                            <button type="button" onclick="closeAddTaskModal()" 
                                    class="flex-1 px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-2xl font-bold hover:bg-slate-200 transition-colors">Batal</button>
                            <button type="submit" 
                                    class="flex-1 px-6 py-3 bg-emerald-600 text-white rounded-2xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-500/20 transition-all">Simpan Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    // Data real dari database
    const allTasks = @json($allTasks);

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const modal = document.getElementById('addTaskModal');
    const modalContent = document.getElementById('modalContent');
    const addTaskForm = document.getElementById('addTaskForm');

    // Initial load
    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar();
        displayTasksForDate(new Date());
    });

    function renderCalendar() {
        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthEl = document.getElementById('currentMonth');
        calendarGrid.innerHTML = '';
        
        const date = new Date(currentYear, currentMonth, 1);
        currentMonthEl.textContent = new Date(currentYear, currentMonth).toLocaleString('id-ID', { month: 'long', year: 'numeric' });

        const firstDayOfMonth = date.getDay();
        const lastDateOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarGrid.innerHTML += '<div></div>';
        }

        for (let day = 1; day <= lastDateOfMonth; day++) {
            const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayTasks = allTasks.filter(task => task.date === dateStr);
            const isToday = (new Date(currentYear, currentMonth, day)).getTime() === today.getTime();
            
            let dayClasses = `aspect-square p-1 flex flex-col items-center justify-center rounded-2xl text-center cursor-pointer transition-all duration-200 border-2 border-transparent`;
            if (isToday) {
                dayClasses += ' bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/30';
            } else {
                dayClasses += ' hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 hover:border-slate-200 dark:hover:border-slate-700';
            }

            let taskIndicator = '';
            if (dayTasks.length > 0) {
                const colors = {
                    'penyiraman': 'bg-blue-400',
                    'pemupukan': 'bg-orange-400',
                    'pemangkasan': 'bg-purple-400',
                    'repotting': 'bg-amber-400',
                    'obat': 'bg-red-400'
                };
                taskIndicator = dayTasks.map(task => `<span class="w-1.5 h-1.5 rounded-full ${colors[task.task_type] || 'bg-slate-400'}"></span>`).join('');
            }

            calendarGrid.innerHTML += `
                <div class="${dayClasses}" onclick="displayTasksForDate(new Date(${currentYear}, ${currentMonth}, ${day}))">
                    <span class="text-xs sm:text-sm">${day}</span>
                    ${dayTasks.length > 0 ? `<div class="mt-1 flex gap-0.5 justify-center flex-wrap">${taskIndicator}</div>` : ''}
                </div>
            `;
        }
    }

    function prevMonth() { currentMonth--; if (currentMonth < 0) { currentMonth = 11; currentYear--; } renderCalendar(); }
    function nextMonth() { currentMonth++; if (currentMonth > 11) { currentMonth = 0; currentYear++; } renderCalendar(); }
    
    function displayTasksForDate(date) {
        const taskListEl = document.getElementById('taskList');
        const currentDateEl = document.getElementById('currentDate');
        const formattedDate = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        
        currentDateEl.textContent = formattedDate;
        taskListEl.innerHTML = '';

        const dateStr = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        const tasksForDay = allTasks.filter(task => task.date === dateStr);
        
        if (tasksForDay.length === 0) {
            taskListEl.innerHTML = `
                <div class="text-center py-10">
                    <i class="fas fa-calendar-check text-slate-100 dark:text-slate-800/50 text-4xl mb-3"></i>
                    <p class="text-xs text-slate-400">Tidak ada tugas hari ini.</p>
                </div>
            `;
            return;
        }

        tasksForDay.forEach(task => {
            const isToday = dateStr === `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
            
            // Jika hari ini, kita filter cuma yang 'dijadwalkan' saja agar list jadi kosong kalau sudah selesai
            if (isToday && task.status === 'selesai') return;

            const iconMap = { 'penyiraman': '💧', 'pemupukan': '🌿', 'pemangkasan': '✂️', 'repotting': '🪴', 'obat': '🧪' };
            const colors = {
                'penyiraman': { bg: 'bg-blue-50', text: 'text-blue-500', bar: 'bg-blue-500', darkBg: 'dark:bg-blue-900/20' },
                'pemupukan': { bg: 'bg-orange-50', text: 'text-orange-500', bar: 'bg-orange-500', darkBg: 'dark:bg-orange-900/20' },
                'pemangkasan': { bg: 'bg-purple-50', text: 'text-purple-500', bar: 'bg-purple-500', darkBg: 'dark:bg-purple-900/20' },
                'repotting': { bg: 'bg-amber-50', text: 'text-amber-500', bar: 'bg-amber-500', darkBg: 'dark:bg-amber-900/20' },
                'obat': { bg: 'bg-red-50', text: 'text-red-500', bar: 'bg-red-500', darkBg: 'dark:bg-red-900/20' }
            };
            const color = colors[task.task_type] || { bg: 'bg-slate-50', text: 'text-slate-500', bar: 'bg-slate-500', darkBg: 'dark:bg-slate-900/20' };
            
            const taskItem = document.createElement('div');
            taskItem.className = `flex items-center p-3 rounded-2xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-800/50 shadow-sm hover:shadow-md transition-all group relative overflow-hidden`;
            taskItem.innerHTML = `
                <div class="absolute left-0 top-0 w-1 h-full ${color.bar}"></div>
                <div class="w-10 h-10 ${color.bg} ${color.darkBg} rounded-xl flex items-center justify-center mr-3 shrink-0">
                    <span class="text-lg">${iconMap[task.task_type] || '📝'}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-800 dark:text-white truncate">${task.bonsai_name}</p>
                    <p class="text-[10px] text-slate-400 uppercase font-bold tracking-tight">${task.task_type.replace('_', ' ')} • <span class="${task.status === 'selesai' ? 'text-emerald-500' : 'text-amber-500'}">${task.status}</span></p>
                </div>
                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    ${task.status === 'dijadwalkan' ? `
                        <form action="/dashboard/perawatan/${task.id}/status" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all">
                                <i class="fas fa-check text-[10px]"></i>
                            </button>
                        </form>
                    ` : ''}
                    <form action="/dashboard/perawatan/${task.id}" method="POST" onsubmit="return confirm('Hapus tugas ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                            <i class="fas fa-trash text-[10px]"></i>
                        </button>
                    </form>
                </div>
            `;
            taskListEl.appendChild(taskItem);
        });

        if (taskListEl.innerHTML === '') {
            taskListEl.innerHTML = `
                <div class="text-center py-10">
                    <i class="fas fa-calendar-check text-slate-100 dark:text-slate-800/50 text-4xl mb-3"></i>
                    <p class="text-xs text-slate-400">Semua tugas selesai!</p>
                </div>
            `;
        }
    }

    function openAddTaskModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeAddTaskModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            addTaskForm.reset();
        }, 300);
    }

    addTaskForm.addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    });
</script>
@endsection