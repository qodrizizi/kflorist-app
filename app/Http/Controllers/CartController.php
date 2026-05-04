<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Bonsai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cartItems = Cart::with('bonsai')
            ->where('user_id', Auth::id())
            ->get();
            
        return view('shop.keranjang', compact('cartItems'));
    }

    /**
     * Tambahkan item ke keranjang
     */
    public function store(Request $request)
    {
        $request->validate([
            'bonsai_id' => 'required|exists:bonsais,id',
            'quantity' => 'integer|min:1'
        ]);

        $bonsai = Bonsai::findOrFail($request->bonsai_id);
        
        // Cek stok/status
        if ($bonsai->status !== 'available' || !$bonsai->is_active) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Produk tidak tersedia.'], 400);
            }
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('bonsai_id', $request->bonsai_id)
                    ->first();

        $quantity = $request->input('quantity', 1);

        if ($cart) {
            $cart->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'bonsai_id' => $request->bonsai_id,
                'quantity' => $quantity,
            ]);
        }

        if ($request->wantsJson()) {
            // Get total items in cart for updating badge
            $totalItems = Cart::where('user_id', Auth::id())->sum('quantity');
            return response()->json([
                'success' => true, 
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $totalItems
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity di keranjang
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang diperbarui.'
        ]);
    }

    /**
     * Hapus dari keranjang
     */
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
