@extends('layouts.app')

@section('title', 'Manajemen Keuangan Bonsai')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2">
                Laporan Keuangan 💰
            </h2>
            <p class="text-sm md:text-base text-gray-600 font-medium">Pantau semua transaksi dan analisis keuntungan bisnis bonsai Anda</p>
        </div>
        <button onclick="openAddTransactionModal()" class="bg-gradient-to-r from-bonsai-500 to-bonsai-600 hover:from-bonsai-600 hover:to-bonsai-700 text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
            <span class="text-xl">➕</span>
            <span class="hidden sm:inline">Tambah Transaksi</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-green-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Total Pemasukan</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($stats['income'] ?? 15000000) }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">📈</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-red-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Total Pengeluaran</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($stats['expense'] ?? 5000000) }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">📉</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-blue-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Profit Bersih</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($stats['profit'] ?? 10000000) }}</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">💸</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-xl p-4 md:p-6 border border-white/20 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1 max-w-lg">
                <div class="relative">
                    <input type="text" id="transactionSearch" placeholder="Cari transaksi..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300 text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400">🔍</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <select id="typeFilter" class="px-4 py-2.5 rounded-lg border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none bg-white text-sm font-medium text-gray-700">
                    <option value="">Semua Tipe</option>
                    <option value="income">Pemasukan</option>
                    <option value="expense">Pengeluaran</option>
                </select>
                
                <input type="date" id="dateFrom" class="px-4 py-2.5 rounded-lg border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none bg-white text-sm">
                <input type="date" id="dateTo" class="px-4 py-2.5 rounded-lg border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none bg-white text-sm">

                <button onclick="resetTransactionFilters()" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-300 text-sm font-medium">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border border-white/20 p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            ID Transaksi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody id="transactionTableBody" class="bg-white divide-y divide-gray-200">
                    <tr class="transaction-row" data-type="income" data-date="2025-09-01">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            TRX-001
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            01 Sep 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Penjualan Bonsai Ficus
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                            Pemasukan
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            Rp 800.000
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="editTransaction('TRX-001')" class="text-blue-600 hover:text-blue-900 mr-2 transition-colors">Edit</button>
                            <button onclick="deleteTransaction('TRX-001')" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                        </td>
                    </tr>
                    <tr class="transaction-row" data-type="expense" data-date="2025-09-02">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            TRX-002
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            02 Sep 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Beli pupuk organik
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                            Pengeluaran
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                            Rp 250.000
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="editTransaction('TRX-002')" class="text-blue-600 hover:text-blue-900 mr-2 transition-colors">Edit</button>
                            <button onclick="deleteTransaction('TRX-002')" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                        </td>
                    </tr>
                    <tr class="transaction-row" data-type="income" data-date="2025-09-05">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            TRX-003
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            05 Sep 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Penjualan Bonsai Juniper
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">
                            Pemasukan
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            Rp 1.500.000
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="editTransaction('TRX-003')" class="text-blue-600 hover:text-blue-900 mr-2 transition-colors">Edit</button>
                            <button onclick="deleteTransaction('TRX-003')" class="text-red-600 hover:text-red-900 transition-colors">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="addTransactionModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl md:text-2xl font-bold text-gray-800">Tambah Transaksi Baru</h3>
                        <button onclick="closeAddTransactionModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="text-2xl">×</span>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form id="addTransactionForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Transaksi</label>
                                <select name="type" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                                <input type="date" name="date" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp)</label>
                            <input type="number" name="amount" min="0" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-bonsai-500 focus:ring-2 focus:ring-bonsai-500/20 outline-none transition-all duration-300">
                        </div>
                        <div class="flex space-x-4">
                            <button type="button" onclick="closeAddTransactionModal()" class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-semibold transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-bonsai-500 to-bonsai-600 hover:from-bonsai-600 hover:to-bonsai-700 text-white rounded-xl font-semibold transition-all duration-300">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter and Search Functions for Transactions
        function filterTransactions() {
            const searchTerm = document.getElementById('transactionSearch').value.toLowerCase();
            const typeFilter = document.getElementById('typeFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;
            const rows = document.querySelectorAll('.transaction-row');

            rows.forEach(row => {
                const description = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const type = row.dataset.type;
                const date = row.dataset.date;

                const matchesSearch = description.includes(searchTerm);
                const matchesType = !typeFilter || type === typeFilter;
                const matchesDate = (!dateFrom || date >= dateFrom) && (!dateTo || date <= dateTo);

                if (matchesSearch && matchesType && matchesDate) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        }

        document.getElementById('transactionSearch').addEventListener('input', filterTransactions);
        document.getElementById('typeFilter').addEventListener('change', filterTransactions);
        document.getElementById('dateFrom').addEventListener('change', filterTransactions);
        document.getElementById('dateTo').addEventListener('change', filterTransactions);

        function resetTransactionFilters() {
            document.getElementById('transactionSearch').value = '';
            document.getElementById('typeFilter').value = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            filterTransactions();
        }

        // Modal Functions
        function openAddTransactionModal() {
            document.getElementById('addTransactionModal').classList.remove('hidden');
        }

        function closeAddTransactionModal() {
            document.getElementById('addTransactionModal').classList.add('hidden');
        }

        // Action Functions (placeholders)
        function editTransaction(id) {
            alert('Mengedit transaksi dengan ID: ' + id);
        }

        function deleteTransaction(id) {
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                alert('Menghapus transaksi dengan ID: ' + id);
            }
        }
    </script>
@endsection