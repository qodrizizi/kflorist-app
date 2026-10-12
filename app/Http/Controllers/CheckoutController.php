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
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        if (empty(\Midtrans\Config::$serverKey)) {
            return redirect()->back()->with('error', 'Konfigurasi pembayaran belum lengkap: MIDTRANS_SERVER_KEY belum diisi di file .env.');
        }

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
        $midtransOrderId = $baseOrderCode . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $subtotal,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'shipping_address' => [
                    'first_name' => Auth::user()->name,
                    'address' => $request->alamat_pengiriman,
                ]
            ],
            'item_details' => $item_details,
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour'
            ]
        ];

        try {
            // Generate Snap Token (Midtrans All Payment Channels)
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $updateData = [
                'metode_pembayaran' => $paymentMethod,
                'midtrans_order_id' => $midtransOrderId,
                'snap_token' => $snapToken,
                'payment_expiry_time' => now()->addHours(24),
            ];

            // Jika user memilih metode spesifik, coba juga CoreApi untuk direct VA / QRIS jika diperlukan
            if (in_array($paymentMethod, ['bca', 'bri', 'bni', 'mandiri', 'qris'])) {
                try {
                    $coreParams = $params;
                    if ($paymentMethod === 'qris') {
                        $coreParams['payment_type'] = 'qris';
                        $coreParams['qris'] = ['acquirer' => 'gopay'];
                    } else if ($paymentMethod === 'mandiri') {
                        $coreParams['payment_type'] = 'echannel';
                        $coreParams['echannel'] = [
                            'bill_info1' => 'Pembayaran Bonsai',
                            'bill_info2' => $baseOrderCode
                        ];
                    } else {
                        $coreParams['payment_type'] = 'bank_transfer';
                        $coreParams['bank_transfer'] = ['bank' => $paymentMethod];
                    }

                    $response = \Midtrans\CoreApi::charge($coreParams);
                    $updateData['payment_type'] = $response->payment_type ?? $paymentMethod;

                    if ($paymentMethod === 'qris') {
                        $qrUrl = null;
                        if (!empty($response->actions) && is_array($response->actions)) {
                            foreach ($response->actions as $action) {
                                if (isset($action->name) && $action->name === 'generate-qr-code') {
                                    $qrUrl = $action->url;
                                    break;
                                }
                            }
                            if (!$qrUrl && isset($response->actions[0]->url)) {
                                $qrUrl = $response->actions[0]->url;
                            }
                        }
                        $updateData['payment_qr_url'] = $qrUrl;
                        $updateData['payment_va_number'] = $response->qr_string ?? null;
                        $updateData['payment_bank'] = 'qris';
                    } else if ($paymentMethod === 'mandiri') {
                        $updateData['payment_bill_key'] = $response->bill_key ?? null;
                        $updateData['payment_biller_code'] = $response->biller_code ?? null;
                        $updateData['payment_bank'] = 'mandiri';
                    } else {
                        $updateData['payment_va_number'] = $response->va_numbers[0]->va_number ?? null;
                        $updateData['payment_bank'] = $paymentMethod;
                    }
                } catch (\Exception $coreEx) {
                    // Jika CoreApi gagal, abaikan karena Snap Token sudah berhasil
                    \Illuminate\Support\Facades\Log::warning('CoreApi charge skipped/failed: ' . $coreEx->getMessage());
                }
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

    /**
     * Ganti metode pembayaran pada pesanan pending
     */
    public function changePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:midtrans,bca,bni,bri,mandiri,qris',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('order_code', $id);
            })
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Metode pembayaran tidak dapat diubah karena status pesanan: ' . $order->status);
        }

        // Ambil base code (ORD-XXXX)
        $parts = explode('-', $order->order_code);
        $baseOrderCode = (count($parts) >= 2) ? ($parts[0] . '-' . $parts[1]) : $order->order_code;
        $allOrders = Order::with('bonsai')
            ->where('order_code', 'like', $baseOrderCode . '%')
            ->get();

        $subtotal = $allOrders->sum('total_price');
        $paymentMethod = $request->metode_pembayaran;

        // Siapkan item details
        $item_details = [];
        foreach ($allOrders as $ord) {
            $item_details[] = [
                'id' => $ord->bonsai_id,
                'price' => (int) ($ord->bonsai ? $ord->bonsai->current_value : ($ord->total_price / max(1, $ord->quantity))),
                'quantity' => (int) $ord->quantity,
                'name' => substr($ord->bonsai ? $ord->bonsai->name : 'Bonsai Item', 0, 50)
            ];
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        if (empty(\Midtrans\Config::$serverKey)) {
            return redirect()->back()->with('error', 'Konfigurasi pembayaran belum lengkap: MIDTRANS_SERVER_KEY belum diisi di file .env.');
        }

        $newMidtransOrderId = $baseOrderCode . '-' . time();
        $params = [
            'transaction_details' => [
                'order_id' => $newMidtransOrderId,
                'gross_amount' => (int) $subtotal,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'shipping_address' => [
                    'first_name' => Auth::user()->name,
                    'address' => $order->alamat_pengiriman,
                ]
            ],
            'item_details' => $item_details,
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour'
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $updateData = [
                'metode_pembayaran' => $paymentMethod,
                'snap_token' => $snapToken,
                'midtrans_order_id' => $newMidtransOrderId,
                'payment_expiry_time' => now()->addHours(24),
                'payment_bank' => null,
                'payment_va_number' => null,
                'payment_bill_key' => null,
                'payment_biller_code' => null,
                'payment_qr_url' => null,
            ];

            if (in_array($paymentMethod, ['bca', 'bri', 'bni', 'mandiri', 'qris'])) {
                try {
                    $coreParams = $params;
                    if ($paymentMethod === 'qris') {
                        $coreParams['payment_type'] = 'qris';
                        $coreParams['qris'] = ['acquirer' => 'gopay'];
                    } else if ($paymentMethod === 'mandiri') {
                        $coreParams['payment_type'] = 'echannel';
                        $coreParams['echannel'] = [
                            'bill_info1' => 'Pembayaran Bonsai',
                            'bill_info2' => $baseOrderCode
                        ];
                    } else {
                        $coreParams['payment_type'] = 'bank_transfer';
                        $coreParams['bank_transfer'] = ['bank' => $paymentMethod];
                    }

                    $response = \Midtrans\CoreApi::charge($coreParams);
                    $updateData['payment_type'] = $response->payment_type ?? $paymentMethod;

                    if ($paymentMethod === 'qris') {
                        $qrUrl = null;
                        if (!empty($response->actions) && is_array($response->actions)) {
                            foreach ($response->actions as $action) {
                                if (isset($action->name) && $action->name === 'generate-qr-code') {
                                    $qrUrl = $action->url;
                                    break;
                                }
                            }
                            if (!$qrUrl && isset($response->actions[0]->url)) {
                                $qrUrl = $response->actions[0]->url;
                            }
                        }
                        $updateData['payment_qr_url'] = $qrUrl;
                        $updateData['payment_va_number'] = $response->qr_string ?? null;
                        $updateData['payment_bank'] = 'qris';
                    } else if ($paymentMethod === 'mandiri') {
                        $updateData['payment_bill_key'] = $response->bill_key ?? null;
                        $updateData['payment_biller_code'] = $response->biller_code ?? null;
                        $updateData['payment_bank'] = 'mandiri';
                    } else {
                        $updateData['payment_va_number'] = $response->va_numbers[0]->va_number ?? null;
                        $updateData['payment_bank'] = $paymentMethod;
                    }
                } catch (\Exception $coreEx) {
                    \Illuminate\Support\Facades\Log::warning('CoreApi charge in changePaymentMethod: ' . $coreEx->getMessage());
                }
            }

            Order::where('order_code', 'like', $baseOrderCode . '%')
                ->update($updateData);

            return redirect()->route('shop.pesanan.pay', $baseOrderCode)->with('success', 'Metode pembayaran berhasil diubah ke ' . strtoupper($paymentMethod) . '!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah metode pembayaran: ' . $e->getMessage());
        }
    }
}
