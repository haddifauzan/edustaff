<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $isOnline;

    public function __construct($userId, $isOnline)
    {
        $this->userId = $userId;
        $this->isOnline = $isOnline;
    }

    public function broadcastOn()
    {
        return new Channel('user-status');
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->userId,
            'is_online' => $this->isOnline,
        ];
    }
}

