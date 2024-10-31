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

        \App\Models\User::observe(\App\Observers\ModelObserver::class);
        \App\Models\Pegawai::observe(\App\Observers\ModelObserver::class);
        \App\Models\Konfirmasi::observe(\App\Observers\ModelObserver::class);
        \App\Models\Notifikasi::observe(\App\Observers\ModelObserver::class);
        \App\Models\PensiunKeluar::observe(\App\Observers\ModelObserver::class);
        \App\Models\Prestasi::observe(\App\Observers\ModelObserver::class);
        \App\Models\Kelas::observe(\App\Observers\ModelObserver::class);
        \App\Models\Jabatan::observe(\App\Observers\ModelObserver::class);
        \App\Models\Jurusan::observe(\App\Observers\ModelObserver::class);
        \App\Models\Mapel::observe(\App\Observers\ModelObserver::class);
        \App\Models\MapelKelas::observe(\App\Observers\ModelObserver::class);
        \App\Models\RiwayatJabatan::observe(\App\Observers\ModelObserver::class);
        \App\Models\TugasTambahan::observe(\App\Observers\ModelObserver::class);
    }
}
