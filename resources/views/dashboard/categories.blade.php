@extends('layouts.app')
@section('title', 'Kategori Bonsai')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kategori Bonsai</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola kategori untuk produk bonsai Anda.</p>
    </div>
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Kategori
    </button>
</div>

<!-- Category Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach($categories as $cat)
    <div class="dash-card p-5 hover:shadow-md transition">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center
                @if($cat->color === 'green') bg-emerald-50 dark:bg-emerald-900/30
                @elseif($cat->color === 'orange') bg-orange-50 dark:bg-orange-900/30
                @elseif($cat->color === 'purple') bg-purple-50 dark:bg-purple-900/30
                @else bg-teal-50 dark:bg-teal-900/30
                @endif">
                <i class="{{ $cat->icon ?? 'fas fa-leaf' }}
                    @if($cat->color === 'green') text-emerald-500
                    @elseif($cat->color === 'orange') text-orange-500
                    @elseif($cat->color === 'purple') text-purple-500
                    @else text-teal-500
                    @endif"></i>
            </div>
            <div class="flex gap-1">
                <button onclick="openEditModal({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->description }}', '{{ $cat->icon }}', '{{ $cat->color }}')"
                        class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <i class="fas fa-pen text-xs text-slate-400"></i>
                </button>
                <form action="{{ route('dashboard.categories.destroy', $cat) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete(this)"
                            class="p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                        <i class="fas fa-trash text-xs text-red-400"></i>
                    </button>
                </form>
            </div>
        </div>
        <h3 class="text-base font-semibold text-slate-800 dark:text-white">{{ $cat->name }}</h3>
        <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $cat->description ?? 'Tanpa deskripsi' }}</p>
        <div class="mt-3 pt-3 border-t border-slate-100 dark:border-slate-700">
            <span class="text-xs text-slate-400">
                <i class="fas fa-seedling mr-1"></i>{{ $cat->bonsais_count }} bonsai
            </span>
        </div>
    </div>
    @endforeach
</div>

{{ $categories->links() }}

<!-- Add Modal -->
<div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Tambah Kategori</h3>
            <button onclick="document.getElementById('addModal').classList.add('hidden')"
                    class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                <i class="fas fa-times text-slate-400"></i>
            </button>
        </div>
        <form action="{{ route('dashboard.categories.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Nama</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Icon (FA class)</label>
                        <input type="text" name="icon" placeholder="fas fa-leaf"
                               class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Warna</label>
                        <select name="color"
                                class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white">
                            <option value="green">Hijau</option>
                            <option value="orange">Oranye</option>
                            <option value="purple">Ungu</option>
                            <option value="teal">Teal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Edit Kategori</h3>
            <button onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                <i class="fas fa-times text-slate-400"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Nama</label>
                    <input type="text" name="name" id="editName" required
                           class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Deskripsi</label>
                    <textarea name="description" id="editDescription" rows="3"
                              class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Icon</label>
                        <input type="text" name="icon" id="editIcon"
                               class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-300 mb-1">Warna</label>
                        <select name="color" id="editColor"
                                class="w-full px-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-slate-700 dark:text-white">
                            <option value="green">Hijau</option>
                            <option value="orange">Oranye</option>
                            <option value="purple">Ungu</option>
                            <option value="teal">Teal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, description, icon, color) {
    document.getElementById('editForm').action = '/dashboard/categories/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = description;
    document.getElementById('editIcon').value = icon;
    document.getElementById('editColor').value = color;
    document.getElementById('editModal').classList.remove('hidden');
}
</script>
@endsection
