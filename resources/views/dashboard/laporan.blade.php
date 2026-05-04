@extends('layouts.app')

@section('title', 'Laporan & Analitik')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-2">
                Laporan & Analitik 📊
            </h2>
            <p class="text-sm md:text-base text-gray-600 font-medium">Dapatkan wawasan mendalam tentang koleksi dan kinerja bisnis Anda.</p>
        </div>
        <button onclick="printReport()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl font-semibold transition-colors duration-300 transform hover:scale-105 flex items-center space-x-2">
            <span class="text-xl">🖨️</span>
            <span class="hidden sm:inline">Cetak Laporan</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-bonsai-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Bonsai Ditambahkan (Bulan Ini)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['bonsai_added'] ?? 5 }}</p>
                </div>
                <div class="bg-gradient-to-br from-bonsai-50 to-bonsai-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">🌱</span>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-green-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Profit Bersih (Bulan Ini)</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">Rp {{ number_format($stats['net_profit'] ?? 10000000) }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">💸</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-white/80 backdrop-blur-sm rounded-xl p-4 md:p-6 shadow-md border-l-4 border-purple-500 hover:shadow-xl group transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm text-gray-500 mb-1 font-medium uppercase tracking-wide">Total Nilai Koleksi</p>
                    <p class="text-xl md:text-3xl font-bold text-gray-800">Rp {{ number_format($stats['total_value'] ?? 50000000) }}</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                    <span class="text-2xl md:text-3xl">💎</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dummy Chart Animation CSS */
        @keyframes draw-bar {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }
        @keyframes draw-line {
            from { stroke-dashoffset: 1000; }
            to { stroke-dashoffset: 0; }
        }
        .animate-bar {
            transform-origin: bottom;
            animation: draw-bar 1s ease-out forwards;
        }
        .animate-line {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: draw-line 2s ease-out forwards;
        }
    </style>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-4 md:p-6 border border-white/20">
            <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <span class="text-xl md:text-2xl mr-2">📈</span>
                Pertumbuhan Koleksi
            </h3>
            <div class="h-64 flex items-end justify-between px-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-40 bg-bonsai-500 rounded-t animate-bar" style="animation-delay: 0.1s; height: 75%;"></div>
                    <span class="text-xs text-gray-500 mt-2">Jan</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-40 bg-bonsai-500 rounded-t animate-bar" style="animation-delay: 0.2s; height: 80%;"></div>
                    <span class="text-xs text-gray-500 mt-2">Feb</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-40 bg-bonsai-500 rounded-t animate-bar" style="animation-delay: 0.3s; height: 60%;"></div>
                    <span class="text-xs text-gray-500 mt-2">Mar</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-40 bg-bonsai-500 rounded-t animate-bar" style="animation-delay: 0.4s; height: 90%;"></div>
                    <span class="text-xs text-gray-500 mt-2">Apr</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-40 bg-bonsai-500 rounded-t animate-bar" style="animation-delay: 0.5s; height: 70%;"></div>
                    <span class="text-xs text-gray-500 mt-2">Mei</span>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md p-4 md:p-6 border border-white/20">
            <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <span class="text-xl md:text-2xl mr-2">💰</span>
                Analisis Keuangan
            </h3>
            <div class="h-64 relative">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path class="stroke-bonsai-500 stroke-2 fill-none animate-line" d="M 0 80 C 20 60, 40 40, 60 55, 80 45, 100 30" style="animation-delay: 0.1s;"></path>
                    <path class="stroke-red-500 stroke-2 fill-none animate-line" d="M 0 70 C 20 75, 40 60, 60 70, 80 65, 100 75" style="animation-delay: 0.5s;"></path>
                </svg>
                <div class="absolute inset-0 flex items-end justify-between px-4 text-xs text-gray-500 font-medium">
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>Mei</span>
                </div>
            </div>
            <div class="mt-4 flex justify-center space-x-6 text-sm font-medium">
                <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 rounded-full bg-bonsai-500"></div>
                    <span>Pemasukan</span>
                </div>
                <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    <span>Pengeluaran</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border border-white/20 p-6">
        <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <span class="text-xl md:text-2xl mr-2">📋</span>
            Detail Laporan
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="data-row">
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
                    </tr>
                    <tr class="data-row">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            02 Sep 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Pembelian pupuk organik
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">
                            Pengeluaran
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                            Rp 250.000
                        </td>
                    </tr>
                    <tr class="data-row">
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
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <button class="text-bonsai-500 font-semibold hover:underline">
                Lihat Semua Laporan
            </button>
        </div>
    </div>

<script>
    // Dummy function for printing
    function printReport() {
        alert('Fungsi cetak laporan akan diaktifkan.');
        // In a real application, you'd trigger a print dialog or PDF generation here
        window.print();
    }
</script>
@endsection