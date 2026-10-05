<?php

namespace App\Http\Controllers;

use App\Models\Bonsai;
use App\Models\Message;
use App\Models\Order;
use App\Models\Perawatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Tampilkan halaman utama Notifikasi Saya
     */
    public function index(Request $request)
    {
        $data = $this->collectNotifications();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'notifications' => $data['notifications'],
                'total_count' => $data['unread_count'],
                'all_count' => $data['total_count']
            ]);
        }

        return view('dashboard.notifications', [
            'notifications' => $data['notifications'],
            'totalCount' => $data['total_count'],
            'unreadCount' => $data['unread_count'],
            'orderCount' => $data['order_count'],
            'chatCount' => $data['chat_count'],
            'maintenanceCount' => $data['maintenance_count'],
            'healthCount' => $data['health_count']
        ]);
    }

    /**
     * API JSON untuk Navbar Dropdown & Polling
     */
    public function getNotifications()
    {
        $data = $this->collectNotifications();

        return response()->json([
            'notifications' => $data['notifications'],
            'total_count' => $data['unread_count'],
            'all_count' => $data['total_count']
        ]);
    }

    /**
     * Mengumpulkan semua notifikasi (Chat, Order, Perawatan, Kesehatan Bonsai)
     */
    public function collectNotifications()
    {
        $adminId = Auth::id();
        $readIds = Cache::get("admin_{$adminId}_read_notifications", []);
        $allReadAt = Cache::get("admin_{$adminId}_all_read_at");

        // 1. Pesan Chat Masuk
        $unreadMessages = Message::select('sender_id', DB::raw('count(*) as total'), DB::raw('max(created_at) as last_time'))
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->groupBy('sender_id')
            ->get()
            ->map(function ($group) use ($readIds, $allReadAt) {
                $sender = User::find($group->sender_id);
                $senderName = $sender ? $sender->name : 'Pelanggan';
                $id = 'chat_' . $group->sender_id;
                $isRead = in_array($id, $readIds) || ($allReadAt && $group->last_time <= $allReadAt);

                return [
                    'id' => $id,
                    'type' => 'chat',
                    'category_label' => 'Chat Pelanggan',
                    'title' => 'Pesan Baru dari ' . $senderName,
                    'message' => $senderName . ' mengirimkan ' . $group->total . ' pesan belum dibaca.',
                    'time' => Carbon::parse($group->last_time)->diffForHumans(),
                    'timestamp' => $group->last_time,
                    'url' => route('dashboard.chat.show', $group->sender_id),
                    'icon' => 'fas fa-comments',
                    'icon_color' => 'text-blue-500 bg-blue-50 dark:bg-blue-500/10',
                    'badge_color' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                    'is_read' => $isRead,
                ];
            });

        // 2. Pesanan Masuk (Status Pending)
        $newOrders = Order::with('user', 'bonsai')
            ->where('status', 'pending')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($order) use ($readIds, $allReadAt) {
                $id = 'order_' . $order->id;
                $isRead = in_array($id, $readIds) || ($allReadAt && $order->created_at <= $allReadAt);
                $userName = $order->user ? $order->user->name : 'Pelanggan';
                $bonsaiName = $order->bonsai ? $order->bonsai->name : 'Bonsai';

                return [
                    'id' => $id,
                    'type' => 'order',
                    'category_label' => 'Pesanan Masuk',
                    'title' => 'Pesanan Baru #' . $order->order_code,
                    'message' => $userName . ' memesan ' . $bonsaiName . ' (Rp ' . number_format($order->total_price, 0, ',', '.') . ').',
                    'time' => $order->created_at->diffForHumans(),
                    'timestamp' => $order->created_at,
                    'url' => route('dashboard.orders'),
                    'icon' => 'fas fa-shopping-bag',
                    'icon_color' => 'text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10',
                    'badge_color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                    'is_read' => $isRead,
                ];
            });

        // 3. Tugas Perawatan Dijadwalkan
        $maintenanceTasks = Perawatan::with('bonsai')
            ->where('status', 'dijadwalkan')
            ->where('tanggal_perawatan', '<=', now()->toDateString())
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($task) use ($readIds, $allReadAt) {
                $id = 'maint_' . $task->id;
                $isRead = in_array($id, $readIds) || ($allReadAt && $task->created_at <= $allReadAt);
                $bonsaiName = $task->bonsai ? $task->bonsai->name : 'Bonsai';

                return [
                    'id' => $id,
                    'type' => 'maintenance',
                    'category_label' => 'Jadwal Perawatan',
                    'title' => 'Tugas: ' . $task->jenis_perawatan,
                    'message' => 'Perawatan untuk ' . $bonsaiName . ' (Jadwal: ' . Carbon::parse($task->tanggal_perawatan)->translatedFormat('d F Y') . ').',
                    'time' => Carbon::parse($task->tanggal_perawatan)->diffForHumans(),
                    'timestamp' => $task->created_at,
                    'url' => route('dashboard.perawatan'),
                    'icon' => 'fas fa-hand-holding-water',
                    'icon_color' => 'text-amber-500 bg-amber-50 dark:bg-amber-500/10',
                    'badge_color' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                    'is_read' => $isRead,
                ];
            });

        // 4. Kondisi Kesehatan Bonsai Kritis / Perlu Perhatian
        $criticalBonsai = Bonsai::whereIn('health_status', ['critical', 'poor'])
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($bonsai) use ($readIds, $allReadAt) {
                $id = 'health_' . $bonsai->id;
                $isRead = in_array($id, $readIds) || ($allReadAt && $bonsai->updated_at <= $allReadAt);
                $label = $bonsai->health_status === 'critical' ? 'Kritis' : 'Kurang Baik';

                return [
                    'id' => $id,
                    'type' => 'health',
                    'category_label' => 'Kondisi Bonsai',
                    'title' => 'Peringatan Kesehatan: ' . $label,
                    'message' => 'Bonsai "' . $bonsai->name . '" (Kode: ' . $bonsai->code . ') membutuhkan tindakan perawatan segera.',
                    'time' => $bonsai->updated_at->diffForHumans(),
                    'timestamp' => $bonsai->updated_at,
                    'url' => route('dashboard.manajemen'),
                    'icon' => 'fas fa-heartbeat',
                    'icon_color' => 'text-rose-500 bg-rose-50 dark:bg-rose-500/10',
                    'badge_color' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300',
                    'is_read' => $isRead,
                ];
            });

        $allNotifications = $unreadMessages
            ->concat($newOrders)
            ->concat($maintenanceTasks)
            ->concat($criticalBonsai)
            ->sortByDesc('timestamp')
            ->values();

        $unreadCount = $allNotifications->where('is_read', false)->count();

        return [
            'notifications' => $allNotifications,
            'total_count' => $allNotifications->count(),
            'unread_count' => $unreadCount,
            'order_count' => $newOrders->count(),
            'chat_count' => $unreadMessages->count(),
            'maintenance_count' => $maintenanceTasks->count(),
            'health_count' => $criticalBonsai->count(),
        ];
    }

    /**
     * Tandai semua notifikasi telah dibaca
     */
    public function markAllAsRead()
    {
        $adminId = Auth::id();

        // 1. Set pesan chat sebagai dibaca
        Message::where('receiver_id', $adminId)->where('is_read', false)->update(['is_read' => true]);

        // 2. Simpan timestamp tanda baca semua
        Cache::put("admin_{$adminId}_all_read_at", now()->toDateTimeString(), now()->addDays(30));

        // 3. Simpan semua id notifikasi saat ini sebagai telah dibaca
        $data = $this->collectNotifications();
        $ids = $data['notifications']->pluck('id')->toArray();
        Cache::put("admin_{$adminId}_read_notifications", $ids, now()->addDays(30));

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai sebagai dibaca.'
            ]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    /**
     * Tandai satu notifikasi telah dibaca
     */
    public function markAsRead($id)
    {
        $adminId = Auth::id();

        // Jika chat, tandai chat sender tersebut sebagai read
        if (str_starts_with($id, 'chat_')) {
            $senderId = str_replace('chat_', '', $id);
            Message::where('receiver_id', $adminId)
                ->where('sender_id', $senderId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        $readIds = Cache::get("admin_{$adminId}_read_notifications", []);
        if (!in_array($id, $readIds)) {
            $readIds[] = $id;
            Cache::put("admin_{$adminId}_read_notifications", $readIds, now()->addDays(30));
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifikasi ditandai dibaca.');
    }
}
