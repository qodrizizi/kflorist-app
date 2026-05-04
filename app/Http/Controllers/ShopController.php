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

        $totalBonsai = Bonsai::where('is_active', true)->count();

        return view('shop.index', compact('categories', 'featuredProducts', 'totalBonsai'));
    }

    /**
     * Halaman semua produk - filter, search, sort
     */
    public function produk(Request $request)
    {
        $categories = Category::all();

        $query = Bonsai::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_active', true);

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->kategori);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('current_value', 'asc');
                break;
            case 'termahal':
                $query->orderBy('current_value', 'desc');
                break;
            case 'nama':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->appends($request->query());

        $totalProducts = Bonsai::where('is_active', true)->count();

        return view('shop.produk', compact('categories', 'products', 'totalProducts'));
    }

    /**
     * Halaman detail produk
     */
    public function show($id)
    {
        $product = Bonsai::with(['category', 'reviews.user'])->findOrFail($id);
        
        // Produk terkait
        $relatedProducts = Bonsai::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->where('status', 'available')
            ->take(4)
            ->get();
            
        return view('shop.detail', compact('product', 'relatedProducts'));
    }
}
