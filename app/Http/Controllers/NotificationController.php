<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use App\Models\Perawatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $adminId = Auth::id();

        // 1. Pesan Chat (Grouped by sender to avoid spam)
        $unreadMessages = Message::select('sender_id', DB::raw('count(*) as total'), DB::raw('max(created_at) as last_time'))
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->groupBy('sender_id')
            ->get()
            ->map(function($group) {
                $sender = \App\Models\User::find($group->sender_id);
                return [
                    'type' => 'chat',
                    'title' => 'Pesan Baru',
                    'message' => $sender->name . ' mengirim ' . $group->total . ' pesan',
                    'time' => \Carbon\Carbon::parse($group->last_time)->diffForHumans(),
                    'timestamp' => $group->last_time,
                    'url' => route('dashboard.chat.show', $group->sender_id),
                    'icon' => 'fas fa-comments text-blue-500'
                ];
            });

        // 2. Pesanan Masuk (Pending)
        $newOrders = Order::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(function($order) {
                return [
                    'type' => 'order',
                    'title' => 'Pesanan Baru',
                    'message' => 'Pesanan #' . $order->order_code . ' dari ' . $order->user->name,
                    'time' => $order->created_at->diffForHumans(),
                    'timestamp' => $order->created_at,
                    'url' => route('dashboard.orders'), // Adjust to your order route name
                    'icon' => 'fas fa-shopping-cart text-emerald-500'
                ];
            });

        // 3. Perawatan (Scheduled)
        $maintenanceTasks = Perawatan::with('bonsai')
            ->where('status', 'dijadwalkan')
            ->where('tanggal_perawatan', '<=', now()->toDateString())
            ->latest()
            ->get()
            ->map(function($task) {
                return [
                    'type' => 'maintenance',
                    'title' => 'Tugas Perawatan',
                    'message' => $task->jenis_perawatan . ' untuk ' . $task->bonsai->name,
                    'time' => 'Jadwal: ' . $task->tanggal_perawatan,
                    'timestamp' => $task->created_at,
                    'url' => route('dashboard.perawatan'),
                    'icon' => 'fas fa-leaf text-amber-500'
                ];
            });

        $allNotifications = $unreadMessages->concat($newOrders)->concat($maintenanceTasks)->sortByDesc('timestamp');

        return response()->json([
            'notifications' => $allNotifications->values(),
            'total_count' => $allNotifications->count()
        ]);
    }
}
