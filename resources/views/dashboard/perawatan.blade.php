@extends('layouts.app')

@section('title', 'Jadwal Perawatan')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2">
                Jadwal Perawatan 📅
            </h2>
            <p class="text-sm md:text-base text-gray-600 font-medium">Jangan lewatkan satu pun perawatan penting untuk koleksi Anda.</p>
        </div>
        <button onclick="openAddTaskModal()" class="bg-gradient-to-r from-bonsai-500 to-bonsai-600 hover:from-bonsai-600 hover:to-bonsai-700 text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
            <span class="text-xl">➕</span>
            <span class="hidden sm:inline">Tambah Tugas</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-blue-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Tugas Mendatang</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['upcoming'] ?? 12 }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">🗓️</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-red-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Tugas Terlewat</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['overdue'] ?? 3 }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">⚠️</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-amber-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Bonsai Butuh Perawatan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['needing_care'] ?? 7 }}</p>
                </div>
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">🌿</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-4 md:p-6 border border-white/20">
            <div class="flex items-center justify-between mb-4">
                <button onclick="prevMonth()" class="p-2 rounded-full hover:bg-gray-100">
                    <span class="text-xl">←</span>
                </button>
                <h3 id="currentMonth" class="text-lg md:text-xl font-semibold text-gray-800">September 2025</h3>
                <button onclick="nextMonth()" class="p-2 rounded-full hover:bg-gray-100">
                    <span class="text-xl">→</span>
                </button>
            </div>
            <div class="grid grid-cols-7 text-center text-sm font-semibold text-gray-500 mb-2">
                <span>Min</span>
                <span>Sen</span>
                <span>Sel</span>
                <span>Rab</span>
                <span>Kam</span>
                <span>Jum</span>
                <span>Sab</span>
            </div>
            <div id="calendar-grid" class="grid grid-cols-7 gap-2">
                </div>
        </div>

        <div class="lg:col-span-1 bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-4 md:p-6 border border-white/20">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg md:text-xl font-semibold text-gray-800">Tugas Hari Ini</h3>
                <span id="currentDate" class="text-sm font-medium text-gray-500">{{ date('d F Y') }}</span>
            </div>
            <div id="taskList" class="space-y-3">
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500 font-medium">Tidak ada tugas hari ini.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="addTaskModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-800">Tambah Tugas Baru</h3>
                        <button onclick="closeAddTaskModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="text-2xl">×</span>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="addTaskForm" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bonsai</label>
                            <input type="text" name="bonsai_name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300" placeholder="Contoh: Ficus Benjamina">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tugas</label>
                            <select name="task_type" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                                <option value="">Pilih Jenis Tugas</option>
                                <option value="watering">💧 Penyiraman</option>
                                <option value="fertilizing">🌿 Pemupukan</option>
                                <option value="pruning">✂️ Pemangkasan</option>
                                <option value="repotting">🪴 Ganti Pot</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" name="task_date" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (opsional)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300"></textarea>
                        </div>
                        <div class="flex space-x-4">
                            <button type="button" onclick="closeAddTaskModal()" class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-semibold transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-bonsai-500 to-bonsai-600 hover:from-bonsai-600 hover:to-bonsai-700 text-white rounded-xl font-semibold transition-all duration-300">
                                Simpan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    // Sample Data (replace with your actual data from backend)
    const allTasks = [
        { id: 1, bonsai_name: 'Ficus Benjamina', task_type: 'watering', date: '2025-09-15', status: 'pending', notes: 'Siram ringan' },
        { id: 2, bonsai_name: 'Juniper', task_type: 'pruning', date: '2025-09-18', status: 'pending' },
        { id: 3, bonsai_name: 'Bonsai Pine', task_type: 'fertilizing', date: '2025-09-20', status: 'pending' },
        { id: 4, bonsai_name: 'Maple Palmatum', task_type: 'watering', date: '2025-09-15', status: 'pending' },
        { id: 5, bonsai_name: 'Bonsai A', task_type: 'repotting', date: '2025-10-10', status: 'pending' },
        { id: 6, bonsai_name: 'Bonsai B', task_type: 'watering', date: '2025-10-15', status: 'pending' },
    ];

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    const today = new Date();
    today.setHours(0, 0, 0, 0);

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

        const firstDayOfMonth = date.getDay(); // 0 for Sunday, 1 for Monday...
        const lastDateOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        // Fill leading empty days
        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarGrid.innerHTML += '<div></div>';
        }

        // Fill days of the month
        for (let day = 1; day <= lastDateOfMonth; day++) {
            const dateStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayTasks = allTasks.filter(task => task.date === dateStr);
            const isToday = (new Date(currentYear, currentMonth, day)).getTime() === today.getTime();
            
            let dayClasses = `p-2 rounded-lg text-center cursor-pointer transition-colors duration-200`;
            if (isToday) {
                dayClasses += ' bg-bonsai-500 text-white font-bold shadow-md';
            } else {
                dayClasses += ' hover:bg-gray-100 text-gray-700';
            }

            let taskIndicator = '';
            if (dayTasks.length > 0) {
                const colors = {
                    'watering': 'bg-blue-400',
                    'fertilizing': 'bg-orange-400',
                    'pruning': 'bg-purple-400',
                    'repotting': 'bg-amber-400'
                };
                taskIndicator = dayTasks.map(task => `<span class="inline-block w-2 h-2 rounded-full ${colors[task.task_type]} mx-0.5"></span>`).join('');
            }

            calendarGrid.innerHTML += `
                <div class="${dayClasses}" onclick="displayTasksForDate(new Date(${currentYear}, ${currentMonth}, ${day}))">
                    ${day}
                    ${dayTasks.length > 0 ? `<div class="mt-1 flex justify-center flex-wrap">${taskIndicator}</div>` : ''}
                </div>
            `;
        }
    }

    function prevMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    }

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    }
    
    function displayTasksForDate(date) {
        const taskListEl = document.getElementById('taskList');
        const currentDateEl = document.getElementById('currentDate');
        const formattedDate = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        
        currentDateEl.textContent = formattedDate;
        taskListEl.innerHTML = '';

        const dateStr = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        const tasksForDay = allTasks.filter(task => task.date === dateStr);
        
        if (tasksForDay.length === 0) {
            taskListEl.innerHTML = '<div class="text-center py-4"><p class="text-sm text-gray-500 font-medium">Tidak ada tugas untuk tanggal ini.</p></div>';
            return;
        }

        tasksForDay.forEach(task => {
            const iconMap = {
                'watering': '💧',
                'fertilizing': '🌿',
                'pruning': '✂️',
                'repotting': '🪴'
            };
            const colorMap = {
                'watering': 'blue',
                'fertilizing': 'orange',
                'pruning': 'purple',
                'repotting': 'amber'
            };
            
            const taskItem = document.createElement('div');
            taskItem.className = `flex items-center p-3 rounded-lg border border-gray-200 bg-white shadow-sm`;
            taskItem.innerHTML = `
                <div class="w-8 h-8 md:w-10 md:h-10 bg-${colorMap[task.task_type]}-100 rounded-full flex items-center justify-center mr-3">
                    <span>${iconMap[task.task_type]}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">${task.bonsai_name}</p>
                    <p class="text-xs text-gray-500">${task.task_type === 'watering' ? 'Penyiraman' : (task.task_type === 'fertilizing' ? 'Pemupukan' : (task.task_type === 'pruning' ? 'Pemangkasan' : 'Ganti Pot'))}</p>
                </div>
            `;
            taskListEl.appendChild(taskItem);
        });
    }

    // Modal Functions
    function openAddTaskModal() {
        document.getElementById('addTaskModal').classList.remove('hidden');
    }

    function closeAddTaskModal() {
        document.getElementById('addTaskModal').classList.add('hidden');
    }

    // Form Submission (dummy)
    document.getElementById('addTaskForm').addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Tugas berhasil disimpan!');
        closeAddTaskModal();
        // Here you would send the data to your backend
    });

</script>
@endsection