<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{

    public function index($id_user)
    {
        $notifications = Notifikasi::where('id_user', $id_user)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('vendor.notifications.notifikasi', compact('notifications'));
    }

    public function markAllAsRead()
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak terautentikasi'], 401);
        }

        $userId = auth()->id();

        $updatedCount = Notifikasi::where('id_user', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($updatedCount === 0) {
            return response()->json(['success' => false, 'message' => 'Tidak ada notifikasi untuk ditandai sebagai dibaca'], 400);
        }

        return response()->json(['success' => true, 'message' => 'Semua notifikasi telah ditandai sebagai dibaca']);
    }

    public function markAsRead($id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak terautentikasi'], 401);
        }

        $userId = auth()->id();

        $notifikasi = Notifikasi::where('id_user', $userId)->findOrFail($id);

        if (is_null($notifikasi->read_at)) {
            $notifikasi->update(['read_at' => now()]);
        }

        return response()->json(['success' => true, 'message' => 'Notifikasi telah ditandai sebagai dibaca']);
    }

    public function destroy($id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak terautentikasi'], 401);
        }

        $userId = auth()->id();

        $notifikasi = Notifikasi::where('id_user', $userId)->findOrFail($id);
        $notifikasi->delete();

        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil dihapus']);
    }

    public function deleteAll()
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Pengguna tidak terautentikasi'], 401);
        }

        $userId = auth()->id();

        Notifikasi::where('id_user', $userId)->delete();

        return response()->json(['success' => true, 'message' => 'Semua notifikasi berhasil dihapus']);
    }
}
