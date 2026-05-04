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
        foreach ($bonsais->take(5) as $bonsai) {
            Order::create([
                'order_code' => 'ORD-' . now()->format('Ymd') . '-' . str_pad($orderNum, 3, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'bonsai_id' => $bonsai->id,
                'quantity' => 1,
                'total_price' => $bonsai->current_value ?? 500000,
                'status' => $statuses[array_rand($statuses)],
                'alamat_pengiriman' => 'Jl. Contoh No. ' . rand(1, 100) . ', Jakarta Selatan',
                'metode_pembayaran' => $metode[array_rand($metode)],
                'catatan' => 'Pesanan bonsai ' . $bonsai->name,
            ]);
            $orderNum++;
        }
    }
}
