<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Simpan penilaian produk
     */
    public function store(Request $request)
    {
        $request->validate([
            'bonsai_id' => 'required|exists:bonsais,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Cek apakah user sudah pernah mereview produk ini (opsional, tapi bagus untuk data)
        // Review::where('user_id', auth()->id())->where('bonsai_id', $request->bonsai_id)->delete();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => auth()->id(),
            'bonsai_id' => $request->bonsai_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image_path' => $imagePath
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih! Penilaian Anda telah berhasil disimpan.'
        ]);
    }
}
