<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Tampilkan halaman daftar pesanan user
     */
    public function index()
    {
        // Otomatis batalkan pesanan yang belum dibayar > 24 jam
        Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'dibatalkan']);

        // Ambil semua pesanan milik user yang sedang login, sertakan review milik user ini untuk bonsai tersebut
        $orders = Order::with(['bonsai.reviews' => function($query) {
            $query->where('user_id', Auth::id());
        }])->where('user_id', Auth::id())->latest()->get();

        // Kelompokkan berdasarkan status
        $pending = $orders->where('status', 'pending');
        $processing = $orders->where('status', 'diproses');
        $shipping = $orders->where('status', 'dikirim');
        $completed = $orders->where('status', 'selesai');
        $cancelled = $orders->where('status', 'dibatalkan');

        return view('shop.pesanan', compact('pending', 'processing', 'shipping', 'completed', 'cancelled'));
    }

    /**
     * Konfirmasi pesanan selesai
     */
    public function complete($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if ($order->status === 'dikirim') {
            $order->update(['status' => 'selesai']);
            return redirect()->back()->with('success', 'Terima kasih telah mengonfirmasi penerimaan pesanan!');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah.');
    }

    /**
     * Lanjut ke pembayaran (Midtrans Snap & Full Channels) untuk pesanan
     */
    public function pay($id)
    {
        // Bisa pakai ID (UUID) atau Order Code (string)
        $order = Order::with('bonsai')
            ->where('user_id', Auth::id())
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('order_code', $id);
            })
            ->firstOrFail();

        // Ambil base code (ORD-XXXX)
        $parts = explode('-', $order->order_code);
        $baseCode = (count($parts) >= 2) ? ($parts[0] . '-' . $parts[1]) : $order->order_code;

        $allOrders = Order::with('bonsai')->where('order_code', 'like', $baseCode . '%')->get();
        $totalAmount = $allOrders->sum('total_price');

        // Jika pesanan sudah dibayar (diproses / dikirim / selesai)
        if (in_array($order->status, ['diproses', 'dikirim', 'selesai'])) {
            return view('shop.payment', [
                'order' => $order,
                'orderCode' => $baseCode,
                'subtotal' => $totalAmount,
                'allOrders' => $allOrders,
                'isPaid' => true,
                'snapToken' => $order->snap_token
            ]);
        }

        if ($order->status === 'dibatalkan') {
            return redirect()->route('shop.pesanan')->with('error', 'Pesanan ini telah dibatalkan.');
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Sinkronisasi status langsung dari Midtrans (jika sudah ada midtrans_order_id)
        if ($order->midtrans_order_id) {
            try {
                $transStatus = \Midtrans\Transaction::status($order->midtrans_order_id);
                if ($transStatus && in_array($transStatus->transaction_status, ['settlement', 'capture'])) {
                    Order::where('order_code', 'like', $baseCode . '%')->update([
                        'status' => 'diproses',
                        'metode_pembayaran' => $transStatus->payment_type ?? $order->metode_pembayaran
                    ]);
                    $order->refresh();

                    return view('shop.payment', [
                        'order' => $order,
                        'orderCode' => $baseCode,
                        'subtotal' => $totalAmount,
                        'allOrders' => $allOrders,
                        'isPaid' => true,
                        'snapToken' => $order->snap_token
                    ]);
                } elseif ($transStatus && in_array($transStatus->transaction_status, ['cancel', 'deny', 'expire'])) {
                    Order::where('order_code', 'like', $baseCode . '%')->update(['status' => 'dibatalkan']);
                    foreach ($allOrders as $item) {
                        if ($item->bonsai) {
                            $item->bonsai->update(['status' => 'available']);
                        }
                    }
                    return redirect()->route('shop.pesanan')->with('error', 'Pembayaran telah dibatalkan atau kedaluwarsa.');
                }
            } catch (\Exception $e) {
                // Abaikan error jaringan dan lanjutkan
            }
        }

        // Jika snap_token belum ada, buatkan Snap Token sekarang agar semua metode pembayaran Midtrans aktif
        $snapToken = $order->snap_token;
        if (empty($snapToken) && !empty(\Midtrans\Config::$serverKey)) {
            try {
                $item_details = [];
                foreach ($allOrders as $ord) {
                    $item_details[] = [
                        'id' => $ord->bonsai_id,
                        'price' => (int) ($ord->bonsai ? $ord->bonsai->current_value : ($ord->total_price / max(1, $ord->quantity))),
                        'quantity' => (int) $ord->quantity,
                        'name' => substr($ord->bonsai ? $ord->bonsai->name : 'Item Bonsai', 0, 50)
                    ];
                }

                $midtransOrderId = $order->midtrans_order_id ?: ($baseCode . '-' . time());
                $params = [
                    'transaction_details' => [
                        'order_id' => $midtransOrderId,
                        'gross_amount' => (int) $totalAmount,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'shipping_address' => [
                            'first_name' => Auth::user()->name,
                            'address' => $order->alamat_pengiriman,
                        ]
                    ],
                    'item_details' => $item_details
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                Order::where('order_code', 'like', $baseCode . '%')->update([
                    'snap_token' => $snapToken,
                    'midtrans_order_id' => $midtransOrderId
                ]);
                $order->snap_token = $snapToken;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Snap token generation error: ' . $e->getMessage());
            }
        }

        return view('shop.payment', [
            'order' => $order,
            'orderCode' => $baseCode,
            'subtotal' => $totalAmount,
            'allOrders' => $allOrders,
            'isPaid' => false,
            'snapToken' => $snapToken
        ]);
    }

    /**
     * Tombol Cek / Sinkronkan Status Pembayaran dari Midtrans
     */
    public function syncStatus($id)
    {
        $order = Order::with('bonsai')
            ->where('user_id', Auth::id())
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('order_code', $id);
            })
            ->firstOrFail();

        $parts = explode('-', $order->order_code);
        $baseCode = (count($parts) >= 2) ? ($parts[0] . '-' . $parts[1]) : $order->order_code;

        if (in_array($order->status, ['diproses', 'dikirim', 'selesai'])) {
            return redirect()->route('shop.pesanan.pay', $baseCode)->with('success', 'Pembayaran telah diverifikasi (Sudah Dibayar)!');
        }

        if (!$order->midtrans_order_id) {
            return redirect()->back()->with('error', 'ID transaksi Midtrans belum tercatat untuk pesanan ini.');
        }

        try {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
            $transStatus = \Midtrans\Transaction::status($order->midtrans_order_id);

            if ($transStatus && in_array($transStatus->transaction_status, ['settlement', 'capture'])) {
                Order::where('order_code', 'like', $baseCode . '%')->update([
                    'status' => 'diproses',
                    'metode_pembayaran' => $transStatus->payment_type ?? $order->metode_pembayaran
                ]);
                return redirect()->route('shop.pesanan.pay', $baseCode)->with('success', 'Pembayaran berhasil dikonfirmasi! (Sudah Dibayar)');
            } elseif ($transStatus && in_array($transStatus->transaction_status, ['cancel', 'deny', 'expire'])) {
                Order::where('order_code', 'like', $baseCode . '%')->update(['status' => 'dibatalkan']);
                $allOrders = Order::where('order_code', 'like', $baseCode . '%')->get();
                foreach ($allOrders as $ord) {
                    if ($ord->bonsai) {
                        $ord->bonsai->update(['status' => 'available']);
                    }
                }
                return redirect()->route('shop.pesanan')->with('error', 'Pembayaran dibatalkan atau telah kedaluwarsa.');
            } else {
                return redirect()->back()->with('error', 'Pembayaran belum terdeteksi lunas di Midtrans (Status saat ini: ' . strtoupper($transStatus->transaction_status ?? 'PENDING') . '). Selesaikan pembayaran di Midtrans terlebih dahulu.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghubungi Midtrans: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint API JSON untuk cek status secara background (Auto-Refresh)
     */
    public function statusJson($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('order_code', $id);
            })
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $parts = explode('-', $order->order_code);
        $baseCode = (count($parts) >= 2) ? ($parts[0] . '-' . $parts[1]) : $order->order_code;

        $isPaid = in_array($order->status, ['diproses', 'dikirim', 'selesai']);

        if (!$isPaid && $order->midtrans_order_id) {
            try {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));
                $transStatus = \Midtrans\Transaction::status($order->midtrans_order_id);

                if ($transStatus && in_array($transStatus->transaction_status, ['settlement', 'capture'])) {
                    Order::where('order_code', 'like', $baseCode . '%')->update([
                        'status' => 'diproses',
                        'metode_pembayaran' => $transStatus->payment_type ?? $order->metode_pembayaran
                    ]);
                    $isPaid = true;
                    $order->status = 'diproses';
                }
            } catch (\Exception $e) {
                // Abaikan jika status belum siap di midtrans
            }
        }

        return response()->json([
            'status' => $order->status,
            'is_paid' => $isPaid,
            'order_code' => $baseCode
        ]);
    }

    /**
     * Download Struk Resmi Pesanan langsung dalam format PDF
     */
    public function struk(Request $request, $id)
    {
        $order = Order::with(['bonsai.category', 'user'])
            ->where('user_id', Auth::id())
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('order_code', $id);
            })
            ->firstOrFail();

        $parts = explode('-', $order->order_code);
        $baseCode = (count($parts) >= 2) ? ($parts[0] . '-' . $parts[1]) : $order->order_code;

        $allOrders = Order::with(['bonsai.category'])
            ->where('order_code', 'like', $baseCode . '%')
            ->get();

        $subtotal = $allOrders->sum('total_price');

        // Jika user secara eksplisit meminta tampilan HTML di browser (?view=html)
        if ($request->query('view') === 'html') {
            return view('shop.struk', [
                'order' => $order,
                'orderCode' => $baseCode,
                'allOrders' => $allOrders,
                'subtotal' => $subtotal
            ]);
        }

        // Ambil logo toko dalam base64 agar DomPDF merender secara instan tanpa isu jaringan/SSL
        $logoBase64 = null;
        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shop.struk_pdf', [
            'order' => $order,
            'orderCode' => $baseCode,
            'allOrders' => $allOrders,
            'subtotal' => $subtotal,
            'logoBase64' => $logoBase64
        ])->setPaper('a4', 'portrait');

        // Jika meminta preview langsung di tab browser (?preview=1)
        if ($request->has('preview')) {
            return $pdf->stream("Struk-Resmi-{$baseCode}.pdf");
        }

        // Default: LANGSUNG DOWNLOAD FILE PDF RESMI
        return $pdf->download("Struk-Resmi-{$baseCode}.pdf");
    }
}
