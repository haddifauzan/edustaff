<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function getNotifications(Request $request)
    {
        $userId = $request->user()->id_user;
        $notifications = Notifikasi::getNotificationsForUser($userId);
        return response()->json($notifications);
    }

    public function markAsRead(Request $request, $notificationId)
    {
        if (Notifikasi::markAsRead($notificationId)) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai sudah dibaca'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi'
            ], 500);
        }
    }
}
