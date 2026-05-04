<?php

namespace App\Http\Controllers;

use App\Models\Bonsai;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout/payment
     */
    public function index(Request $request)
    {
        $items = [];
        $subtotal = 0;
        $isDirectBuy = false;

        // Jika Beli Langsung
        if ($request->has('bonsai_id')) {
            $bonsai = Bonsai::findOrFail($request->bonsai_id);
            if ($bonsai->status !== 'available' || !$bonsai->is_active) {
                return redirect()->route('shop.produk')->with('error', 'Produk tidak tersedia.');
            }
            $items[] = [
                'bonsai' => $bonsai,
                'quantity' => 1,
                'total' => $bonsai->current_value
            ];
            $subtotal = $bonsai->current_value;
            $isDirectBuy = true;
        } 
        // Jika dari Keranjang
        else {
            $cartItems = Cart::with('bonsai')->where('user_id', Auth::id())->get();
            if ($cartItems->isEmpty()) {
                return redirect()->route('shop.keranjang')->with('error', 'Keranjang Anda kosong.');
            }
            
            foreach ($cartItems as $cart) {
                $items[] = [
                    'bonsai' => $cart->bonsai,
                    'quantity' => $cart->quantity,
                    'total' => $cart->bonsai->current_value * $cart->quantity
                ];
                $subtotal += $cart->bonsai->current_value * $cart->quantity;
            }
        }

        return view('shop.checkout', compact('items', 'subtotal', 'isDirectBuy'));
    }

    /**
     * Proses pembayaran/checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $baseOrderCode = 'ORD-' . strtoupper(Str::random(8));
        $subtotal = 0;
        $item_details = [];

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Jika Beli Langsung
        if ($request->has('bonsai_id')) {
            $bonsai = Bonsai::findOrFail($request->bonsai_id);
            if ($bonsai->status !== 'available' || !$bonsai->is_active) {
                return redirect()->route('shop.produk')->with('error', 'Produk tidak tersedia.');
            }

            $order = Order::create([
                'order_code' => $baseOrderCode,
                'user_id' => Auth::id(),
                'bonsai_id' => $bonsai->id,
                'quantity' => 1,
                'total_price' => $bonsai->current_value,
                'status' => 'pending',
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'catatan' => $request->catatan,
            ]);
            
            // Tandai terjual
            $bonsai->update(['status' => 'sold']);
            
            $subtotal = $bonsai->current_value;
            $item_details[] = [
                'id' => $bonsai->id,
                'price' => $bonsai->current_value,
                'quantity' => 1,
                'name' => substr($bonsai->name, 0, 50)
            ];
        } 
        // Jika dari Keranjang
        else {
            $cartItems = Cart::with('bonsai')->where('user_id', Auth::id())->get();
            if ($cartItems->isEmpty()) {
                return redirect()->route('shop.keranjang')->with('error', 'Keranjang Anda kosong.');
            }

            foreach ($cartItems as $index => $cart) {
                Order::create([
                    'order_code' => $baseOrderCode . '-' . ($index + 1), // Supaya unique
                    'user_id' => Auth::id(),
                    'bonsai_id' => $cart->bonsai_id,
                    'quantity' => $cart->quantity,
                    'total_price' => $cart->bonsai->current_value * $cart->quantity,
                    'status' => 'pending',
                    'alamat_pengiriman' => $request->alamat_pengiriman,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'catatan' => $request->catatan,
                ]);
                
                // Tandai terjual
                $cart->bonsai->update(['status' => 'sold']);
                
                $subtotal += $cart->bonsai->current_value * $cart->quantity;
                $item_details[] = [
                    'id' => $cart->bonsai_id,
                    'price' => $cart->bonsai->current_value,
                    'quantity' => $cart->quantity,
                    'name' => substr($cart->bonsai->name, 0, 50)
                ];
            }

            // Kosongkan keranjang
            Cart::where('user_id', Auth::id())->delete();
        }

        // Ambil Metode Pembayaran
        $paymentMethod = $request->metode_pembayaran;
        $params = [
            'transaction_details' => [
                'order_id' => $baseOrderCode . '-' . time(),
                'gross_amount' => $subtotal,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'shipping_address' => [
                    'first_name' => Auth::user()->name,
                    'address' => $request->alamat_pengiriman,
                ]
            ],
            'item_details' => $item_details
        ];

        // Konfigurasi Payment Type untuk Core API
        if ($paymentMethod === 'qris') {
            $params['payment_type'] = 'qris';
        } else if ($paymentMethod === 'mandiri') {
            $params['payment_type'] = 'echannel';
            $params['echannel'] = [
                'bill_info1' => 'Pembayaran Bonsai',
                'bill_info2' => $baseOrderCode
            ];
        } else {
            // Default ke bank_transfer (bca, bri, bni)
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = [
                'bank' => $paymentMethod
            ];
        }

        try {
            $response = \Midtrans\CoreApi::charge($params);
            
            // Siapkan data untuk update ke DB
            $updateData = [
                'payment_type' => $response->payment_type ?? $paymentMethod,
                'payment_expiry_time' => $response->expiry_time ?? null,
            ];

            if ($paymentMethod === 'qris') {
                $updateData['payment_qr_url'] = $response->actions[0]->url ?? null;
            } else if ($paymentMethod === 'mandiri') {
                $updateData['payment_bill_key'] = $response->bill_key ?? null;
                $updateData['payment_biller_code'] = $response->biller_code ?? null;
                $updateData['payment_bank'] = 'mandiri';
            } else {
                $updateData['payment_va_number'] = $response->va_numbers[0]->va_number ?? null;
                $updateData['payment_bank'] = $paymentMethod;
            }

            // Update semua order yang baru dibuat
            Order::where('order_code', $baseOrderCode)
                ->orWhere('order_code', 'like', $baseOrderCode . '-%')
                ->update($updateData);
            
            return redirect()->route('shop.pesanan.pay', $baseOrderCode);

        } catch (\Exception $e) {
            return redirect()->route('shop.pesanan')->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}
