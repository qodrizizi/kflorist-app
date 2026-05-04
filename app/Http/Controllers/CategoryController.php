<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Menampilkan halaman untuk mengelola kategori.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        Category::create($validatedData);

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kategori yang ada.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $category->update($validatedData);

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Opsional: Cek jika kategori masih digunakan oleh bonsai
        if ($category->bonsais()->count() > 0) {
            return redirect()->route('dashboard.categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data bonsai.');
        }

        $category->delete();

        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
