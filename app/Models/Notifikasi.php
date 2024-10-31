<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'judul',
        'pesan',
        'data',
        'id_user',
        'id_sender',
        'read_at',
    ];

    // Relasi ke model User (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'id_sender', 'id_user');
    }

    /**
     * Mendapatkan notifikasi untuk user tertentu.
     *
     * @param int $userId ID user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotificationsForUser($userId)
    {
        return self::where('id_user', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca.
     *
     * @param int $notificationId ID notifikasi
     * @return bool
     */
    public static function markAsRead($notificationId)
    {
        $notification = self::findOrFail($notificationId);
        $notification->read_at = now();
        return $notification->save();
    }
}
