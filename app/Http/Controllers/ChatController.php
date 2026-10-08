<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    // For Admin: List users who have messaged
    public function index()
    {
        $adminId = Auth::id();
        
        $userIds = Message::where('sender_id', $adminId)
            ->orWhere('receiver_id', $adminId)
            ->get()
            ->map(function ($message) use ($adminId) {
                return $message->sender_id == $adminId ? $message->receiver_id : $message->sender_id;
            })
            ->unique();

        $chats = User::whereIn('id', $userIds)->get()->map(function ($user) use ($adminId) {
            $user->unread_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $adminId)
                ->where('is_read', false)
                ->count();
            return $user;
        });

        if (request()->expectsJson()) {
            return response()->json(['chats' => $chats]);
        }

        return view('dashboard.chat.index', compact('chats'));
    }

    // For Admin: Get total unread messages count
    public function getAdminUnreadCount()
    {
        $adminId = Auth::id();
        $count = Message::where('receiver_id', $adminId)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }

    public function show(User $user)
    {
        $adminId = Auth::id();
        
        $messages = Message::where(function ($query) use ($adminId, $user) {
            $query->where('sender_id', $adminId)->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($adminId, $user) {
            $query->where('sender_id', $user->id)->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('dashboard.chat.show', compact('user', 'messages'));
    }

    public function getMessages(User $user)
    {
        $adminId = Auth::id();
        
        $messages = Message::where(function ($query) use ($adminId, $user) {
            $query->where('sender_id', $adminId)->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($adminId, $user) {
            $query->where('sender_id', $user->id)->where('receiver_id', $adminId);
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }

    public function getUserMessages()
    {
        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json(['messages' => []]);
        }

        $messages = Message::where(function ($query) use ($userId, $admin) {
            $query->where('sender_id', $userId)->where('receiver_id', $admin->id);
        })->orWhere(function ($query) use ($userId, $admin) {
            $query->where('sender_id', $admin->id)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        $unreadCount = Message::where('sender_id', $admin->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'messages' => $messages,
            'admin_name' => $admin->name,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead()
    {
        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Message::where('sender_id', $admin->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'receiver_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480', // Max 20MB
        ]);

        if (Auth::id() === $request->receiver_id) {
            return response()->json(['error' => 'Tidak dapat mengirim pesan ke diri sendiri.'], 422);
        }

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $mime = $file->getMimeType();
            
            if (str_contains($mime, 'image')) {
                $attachmentType = 'image';
                $attachmentPath = $this->handleImageUpload($file);
            } elseif (str_contains($mime, 'video')) {
                $attachmentType = 'video';
                $attachmentPath = $file->store('attachments/videos', 'public');
            }
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message ?? '',
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
            'is_read' => false
        ]);

        broadcast(new \App\Events\MessageSent($message));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back();
    }

    private function handleImageUpload($file)
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = 'attachments/images/' . $filename;
        
        // Simple compression using GD
        $imageInfo = getimagesize($file);
        $mime = $imageInfo['mime'];
        
        switch ($mime) {
            case 'image/jpeg': $img = imagecreatefromjpeg($file); break;
            case 'image/png': $img = imagecreatefrompng($file); break;
            default: return $file->store('attachments/images', 'public');
        }

        // Resize if too large (max width 1200px)
        $width = imagesx($img);
        $height = imagesy($img);
        $maxWidth = 1200;
        
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = ($height / $width) * $maxWidth;
            $newImg = imagecreatetruecolor($newWidth, $newHeight);
            
            // Maintain transparency for PNG
            if ($mime == 'image/png') {
                imagealphablending($newImg, false);
                imagesavealpha($newImg, true);
            }
            
            imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $img = $newImg;
        }

        // Save to temporary buffer
        ob_start();
        if ($mime == 'image/jpeg') {
            imagejpeg($img, null, 75); // 75% quality
        } else {
            imagepng($img, null, 7); // 0-9 compression level
        }
        $content = ob_get_clean();
        
        Storage::disk('public')->put($path, $content);
        imagedestroy($img);

        return $path;
    }
}
