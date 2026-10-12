<?php

namespace App\Http\Controllers;

use App\Models\Bonsai;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Halaman utama shop - hero + kategori + produk terlaris
     */
    public function index()
    {
        $categories = Category::withCount('bonsais')->get();

        $featuredProducts = Bonsai::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', 'available')
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $totalBonsai = Bonsai::where('is_active', true)->where('status', 'available')->count();

        return view('shop.index', compact('categories', 'featuredProducts', 'totalBonsai'));
    }

    /**
     * Halaman semua produk - filter, search, sort
     */
    public function produk(Request $request)
    {
        $categories = Category::all();

        // Query dasar
        $baseQuery = Bonsai::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_active', true);

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $baseQuery->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->kategori);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Clone untuk produk tersedia
        $availableQuery = (clone $baseQuery)->where('status', 'available');
        
        // Sort untuk produk tersedia
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'termurah': $availableQuery->orderBy('current_value', 'asc'); break;
            case 'termahal': $availableQuery->orderBy('current_value', 'desc'); break;
            case 'nama':     $availableQuery->orderBy('name', 'asc'); break;
            default:         $availableQuery->latest(); break;
        }

        $availableProducts = $availableQuery->paginate(12, ['*'], 'page_available')->appends($request->query());

        // Clone untuk produk terjual (biasanya diurutkan dari yang paling baru terjual/paling baru diinput)
        $soldProducts = (clone $baseQuery)->where('status', 'sold')->latest()->take(8)->get();

        $totalProducts = Bonsai::where('is_active', true)->where('status', 'available')->count();

        return view('shop.produk', compact('categories', 'availableProducts', 'soldProducts', 'totalProducts'));
    }

    /**
     * Halaman detail produk
     */
    public function show($id)
    {
        $product = Bonsai::with(['category', 'reviews.user', 'perawatans'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);
        
        // Produk terkait dalam kategori yang sama atau produk unggulan lain jika kategori sedikit
        $relatedProducts = Bonsai::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->where('status', 'available')
            ->where(function ($query) use ($product) {
                if ($product->category_id) {
                    $query->where('category_id', $product->category_id);
                }
            })
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Bonsai::with('category')
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('id', '!=', $id)
                ->where('is_active', true)
                ->where('status', 'available')
                ->latest()
                ->take(4)
                ->get();
        }
            
        return view('shop.detail', compact('product', 'relatedProducts'));
    }
}
