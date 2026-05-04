<?php

namespace App\Http\Controllers;

use App\Models\Bonsai;
use App\Models\Category;
use App\Models\Order;
use App\Models\Perawatan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard Home - Overview & Stats
     */
    public function home()
    {
        $totalBonsai = Bonsai::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'user')->count();

        $ordersPending = Order::where('status', 'pending')->count();
        $ordersSelesai = Order::where('status', 'selesai')->count();
        $totalRevenue = Order::where('status', 'selesai')->sum('total_price');

        // Perawatan terjadwal
        $perawatanDijadwalkan = Perawatan::where('status', 'dijadwalkan')->count();

        // Bonsai per kategori
        $bonsaiPerKategori = Category::withCount('bonsais')->get();

        // Pesanan terbaru
        $recentOrders = Order::with(['user', 'bonsai'])->latest()->take(5)->get();

        // Perawatan terbaru
        $recentPerawatan = Perawatan::with('bonsai')->latest()->take(5)->get();

        return view('dashboard.home', compact(
            'totalBonsai',
            'totalCategories',
            'totalOrders',
            'totalUsers',
            'ordersPending',
            'ordersSelesai',
            'totalRevenue',
            'perawatanDijadwalkan',
            'bonsaiPerKategori',
            'recentOrders',
            'recentPerawatan'
        ));
    }

    /**
     * Kategori - CRUD Kategori Bonsai
     */
    public function categories()
    {
        $categories = Category::withCount('bonsais')->latest()->paginate(10);
        return view('dashboard.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        Category::create($request->all());

        return redirect()->route('dashboard.categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $category->update($request->all());

        return redirect()->route('dashboard.categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->bonsais()->count() > 0) {
            return redirect()->route('dashboard.categories')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan.');
        }

        $category->delete();

        return redirect()->route('dashboard.categories')->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Pesanan - Kelola pesanan masuk
     */
    public function orders()
    {
        $orders = Order::with(['user', 'bonsai'])->latest()->paginate(10);
        return view('dashboard.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('dashboard.orders')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
