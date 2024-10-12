<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Session\Events\SessionActivity;
use App\Listeners\UpdateLastSeen;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserActivityEvent::class => [
            UpdateUserOnlineStatus::class,
        ],
    ];
    
    
    public function boot()
    {
        parent::boot();
    }
}
