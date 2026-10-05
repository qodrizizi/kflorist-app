<?php

namespace App\Http\Controllers;

use App\Models\Bonsai;
use App\Models\Perawatan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'image_path.required' => 'Gambar bonsai wajib diupload.',
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus berupa PNG, JPG, JPEG, WEBP, atau GIF.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
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
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'image_path.image' => 'File harus berupa gambar.',
            'image_path.mimes' => 'Format gambar harus berupa PNG, JPG, JPEG, WEBP, atau GIF.',
            'image_path.max' => 'Ukuran gambar maksimal 5MB.',
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

    public function perawatan(Request $request)
    {
        $bonsais = Bonsai::orderBy('name')->get();
        
        // Ambil semua perawatan untuk kalender (tanpa paginasi untuk JS kalender)
        $allTasks = Perawatan::with('bonsai')->get()->map(function($p) {
            return [
                'id' => $p->id,
                'bonsai_name' => $p->bonsai->name,
                'task_type' => $p->jenis_perawatan,
                'date' => $p->tanggal_perawatan->format('Y-m-d'),
                'status' => $p->status,
                'notes' => $p->catatan
            ];
        });

        // Query untuk riwayat dengan filter
        $query = Perawatan::with('bonsai');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('bonsai', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            })->orWhere('jenis_perawatan', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_perawatan', $request->jenis);
        }

        $riwayat = $query->latest()->paginate(10)->withQueryString();

        // Hitung statistik real
        $stats = [
            'upcoming' => Perawatan::where('tanggal_perawatan', '>=', now()->toDateString())->where('status', 'dijadwalkan')->count(),
            'overdue' => Perawatan::where('tanggal_perawatan', '<', now()->toDateString())->where('status', 'dijadwalkan')->count(),
            'needing_care' => Bonsai::where('health_status', '!=', 'sehat')->count(),
            'total_selesai' => Perawatan::where('status', 'selesai')->count(),
            'total_terjadwal' => Perawatan::where('status', 'dijadwalkan')->count(),
        ];

        return view('dashboard.perawatan', compact('bonsais', 'allTasks', 'stats', 'riwayat'));
    }

    public function storePerawatan(Request $request)
    {
        $request->validate([
            'bonsai_ids' => 'required|array',
            'bonsai_ids.*' => 'exists:bonsais,id',
            'tanggal_perawatan' => 'required|date',
            'jenis_perawatan' => 'required|string',
            'catatan' => 'nullable|string',
            'status' => 'required|string|in:selesai,dijadwalkan',
        ]);

        foreach ($request->bonsai_ids as $bonsai_id) {
            Perawatan::create([
                'bonsai_id' => $bonsai_id,
                'user_id' => auth()->id(),
                'tanggal_perawatan' => $request->tanggal_perawatan,
                'jenis_perawatan' => $request->jenis_perawatan,
                'catatan' => $request->catatan,
                'status' => $request->status,
            ]);
        }

        return redirect()->route('dashboard.perawatan')->with('success', count($request->bonsai_ids) . ' tugas perawatan berhasil disimpan.');
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
        return redirect()->route('dashboard.perawatan')->with('success', 'Catatan perawatan berhasil diperbarui.');
    }

    public function updateStatusPerawatan(Request $request, Perawatan $perawatan)
    {
        $request->validate([
            'status' => 'required|string|in:selesai,dijadwalkan',
        ]);

        $perawatan->update(['status' => $request->status]);
        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    public function destroyPerawatan(Perawatan $perawatan)
    {
        $perawatan->delete();
        return redirect()->route('dashboard.perawatan')->with('success', 'Catatan perawatan berhasil dihapus.');
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

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}

