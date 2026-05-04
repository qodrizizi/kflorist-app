<?php

namespace App\Http\Controllers;

use App\Models\Bonsai;
use App\Models\Perawatan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BonsaiController extends Controller
{

    public function manajemen()
    {
        // Eager load relasi 'category' untuk efisiensi query
        $bonsais = Bonsai::with('category')->latest()->paginate(10);
        
        // Ambil semua kategori untuk ditampilkan di form dropdown
        $categories = Category::orderBy('name')->get();
        
        return view('dashboard.manajemen', compact('bonsais', 'categories'));
    }

    /**
     * Menyimpan data bonsai baru yang diinput dari form modal.
     */
    public function storeManajemen(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'code' => 'required|string|max:50|unique:bonsais,code',
            'category_id' => 'required|exists:categories,id',
            'species' => 'nullable|string|max:100',
            'age_years' => 'nullable|integer|min:0',
            'current_value' => 'nullable|numeric|min:0',
            'status' => 'required|string',
            'health_status' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('bonsai_images', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        Bonsai::create($validatedData);

        return redirect()->route('dashboard.manajemen')->with('success', 'Bonsai baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data bonsai yang sudah ada.
     */
    public function updateManajemen(Request $request, Bonsai $bonsai)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:150',
            'code' => ['required', 'string', 'max:50', Rule::unique('bonsais')->ignore($bonsai->id)],
            'category_id' => 'required|exists:categories,id',
            'species' => 'nullable|string|max:100',
            'age_years' => 'nullable|integer|min:0',
            'current_value' => 'nullable|numeric|min:0',
            'status' => 'required|string',
            'health_status' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            if ($bonsai->image_path) {
                Storage::disk('public')->delete($bonsai->image_path);
            }
            $imagePath = $request->file('image_path')->store('bonsai_images', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        $bonsai->update($validatedData);

        return redirect()->route('dashboard.manajemen')->with('success', 'Data bonsai berhasil diperbarui.');
    }

    /**
     * Menghapus data bonsai.
     */
    public function destroyManajemen(Bonsai $bonsai)
    {
        if ($bonsai->image_path) {
            Storage::disk('public')->delete($bonsai->image_path);
        }
        $bonsai->delete();
        return redirect()->route('dashboard.manajemen')->with('success', 'Data bonsai berhasil dihapus.');
    }
    /*
    |--------------------------------------------------------------------------
    | FUNGSI UNTUK PERAWATAN (CREATE, READ, UPDATE, DELETE)
    |--------------------------------------------------------------------------
    */

    public function perawatan()
    {
        $bonsais = Bonsai::orderBy('name')->get();
        $perawatans = Perawatan::with('bonsai')->latest()->paginate(10);
        return view('dashboard.perawatan', compact('perawatans', 'bonsais'));
    }

    public function storePerawatan(Request $request)
    {
        $request->validate([
            'bonsai_id' => 'required|exists:bonsais,id',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        Perawatan::create($request->all());
        return redirect()->route('perawatan')->with('success', 'Catatan perawatan berhasil ditambahkan.');
    }

    public function updatePerawatan(Request $request, Perawatan $perawatan)
    {
        $request->validate([
            'bonsai_id' => 'required|exists:bonsais,id',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $perawatan->update($request->all());
        return redirect()->route('perawatan')->with('success', 'Catatan perawatan berhasil diperbarui.');
    }

    public function destroyPerawatan(Perawatan $perawatan)
    {
        $perawatan->delete();
        return redirect()->route('perawatan')->with('success', 'Catatan perawatan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | PLACEHOLDER UNTUK FITUR LAIN
    |--------------------------------------------------------------------------
    */
    
    public function keuangan()
    {
        return view('dashboard.keuangan');
    }

    public function laporan()
    {
        return view('dashboard.laporan');
    }

    public function profile()
    {
        return view('dashboard.profile');
    }
}

