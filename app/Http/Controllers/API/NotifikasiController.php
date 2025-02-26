<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\User;
use App\Services\FirebaseService;

class NotifikasiController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        $id_user = auth()->user()->id_user;
        $notifications = Notifikasi::where('id_user', $id_user)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($notifications->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Tidak ada notifikasi',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil diambil',
            'data' => $notifications
        ]);
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

    public function destroy($id)
    {
        $userId = auth()->id();

        $notifikasi = Notifikasi::where('id_user', $userId)->find($id);

        if (!$notifikasi) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ]);
        }

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }

    public function markAllAsRead()
    {
        $userId = auth()->id();

        $updatedCount = Notifikasi::where('id_user', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $updatedCount > 0 ? 'Semua notifikasi telah ditandai sebagai dibaca' : 'Tidak ada notifikasi untuk ditandai sebagai dibaca'
        ]);
    }

    public function deleteAll()
    {
        $userId = auth()->id();

        Notifikasi::where('id_user', $userId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi berhasil dihapus'
        ]);
    }

    public function sendFCMNotification($userId, $title, $message)
    {
        $success = $this->firebaseService->sendFCMNotification($userId, $title, $message);

        return response()->json([
            'message' => $success ? 'Notifikasi dikirim' : 'Gagal mengirim notifikasi'
        ], $success ? 200 : 500);
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = auth()->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json(['message' => 'Token FCM berhasil diperbarui'], 200);
    }

    public function testSendNotification($userId)
    {
        $title = "Test Notification";
        $message = "This is a test notification";
        $success = $this->sendFCMNotification($userId, $title, $message);

        return response()->json(['message' => $success ? 'Notifikasi dikirim' : 'Gagal mengirim notifikasi'], $success ? 200 : 500);
    }
}
