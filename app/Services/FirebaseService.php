<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = json_decode(file_get_contents('D:\\XAMPP\\htdocs\\administrasi_kepegawaian\\config\\edustaff-a741c-firebase-adminsdk-6g5ue-b4d40e48fc.json'), true);
    }

    public function sendFCMNotification($userId, $title, $body)
    {
        $user = User::find($userId);
        if (!$user || !$user->fcm_token) {
            return false;
        }

        $message = CloudMessage::withTarget('token', $user->fcm_token)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ]);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send FCM notification: ' . $e->getMessage());
            return false;
        }
    }
}
