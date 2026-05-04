<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    /**
     * Handle notification callback dari Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil order_code asli (buang suffix timestamp)
        $orderIdParts = explode('-', $request->order_id);
        array_pop($orderIdParts); 
        $cleanOrderCode = implode('-', $orderIdParts);

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        // Cari order yang sesuai
        // Jika dari keranjang, kodenya ORD-XXXX-1, ORD-XXXX-2, dll. base code nya ORD-XXXX
        // Jika dari bayar satuan, kodenya ORD-XXXX
        $orders = Order::where('order_code', $cleanOrderCode)
                    ->orWhere('order_code', 'like', $cleanOrderCode . '-%')
                    ->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        foreach ($orders as $order) {
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->update(['status' => 'pending']);
                } else if ($fraudStatus == 'accept') {
                    $order->update(['status' => 'diproses']);
                }
            } else if ($transactionStatus == 'settlement') {
                $order->update(['status' => 'diproses']);
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $order->update(['status' => 'dibatalkan']);
                // Kembalikan stok jika perlu (dalam hal ini ubah status bonsai jadi available lagi)
                if ($order->bonsai) {
                    $order->bonsai->update(['status' => 'available']);
                }
            } else if ($transactionStatus == 'pending') {
                $order->update(['status' => 'pending']);
            }
        }

        return response()->json(['message' => 'Callback handled successfully']);
    }
}
