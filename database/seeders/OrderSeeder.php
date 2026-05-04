<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Bonsai;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        $bonsais = Bonsai::where('status', 'available')->get();

        $statuses = ['pending', 'diproses', 'dikirim', 'selesai'];
        $metode = ['Transfer Bank', 'E-Wallet', 'COD'];

        $orderNum = 1;
        // Create specific order types for testing
        $specificStatuses = ['pending', 'diproses', 'dikirim', 'selesai'];
        
        foreach ($bonsais->take(4) as $index => $bonsai) {
            $status = $specificStatuses[$index];
            Order::create([
                'order_code' => 'ORD-' . now()->format('Ymd') . '-' . str_pad($orderNum, 3, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'bonsai_id' => $bonsai->id,
                'quantity' => 1,
                'total_price' => $bonsai->current_value ?? 500000,
                'status' => $status,
                'alamat_pengiriman' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
                'metode_pembayaran' => 'Transfer Bank',
                'catatan' => 'Pesanan testing untuk status ' . $status,
            ]);

            // Jika status bukan pending, tandai bonsai sebagai sold
            if ($status !== 'pending') {
                $bonsai->update(['status' => 'sold']);
            }
            
            $orderNum++;
        }
    }
}
