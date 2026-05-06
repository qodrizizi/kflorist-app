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
     * Lanjut ke pembayaran (Custom UI) untuk pesanan yang masih pending
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

        if ($order->status !== 'pending') {
            $msg = $order->status === 'dibatalkan' ? 'Pesanan ini telah dibatalkan (Melebihi batas waktu 24 jam).' : 'Pesanan ini tidak dapat dibayar karena statusnya ' . $order->status;
            return redirect()->route('shop.pesanan')->with('error', $msg);
        }

        // Jika data pembayaran sudah ada di DB, langsung tampilkan
        if ($order->payment_va_number || $order->payment_qr_url || $order->payment_bill_key) {
            // Kita ambil base code (ORD-XXXX) untuk cari item lain dalam transaksi yang sama
            $parts = explode('-', $order->order_code);
            $baseCode = $parts[0] . '-' . $parts[1];
            $allOrders = Order::where('order_code', 'like', $baseCode . '%')->get();
            $totalAmount = $allOrders->sum('total_price');

            return view('shop.payment', [
                'order' => $order,
                'orderCode' => $order->order_code,
                'subtotal' => $totalAmount,
                'allOrders' => $allOrders
            ]);
        }

        // Jika belum ada (misal order lama), kita buatkan via Core API (default BCA)
        // ... (Logika fallback bisa ditambah di sini jika perlu)
        
        return redirect()->route('shop.pesanan')->with('error', 'Data pembayaran tidak ditemukan. Silakan hubungi admin.');
    }
}
