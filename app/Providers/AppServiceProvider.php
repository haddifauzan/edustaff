<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\UpdateStatusJabatanJob;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mendaftarkan middleware
        $this->app['router']->aliasMiddleware('checkrole', \App\Http\Middleware\CheckRole::class);

        dispatch(new UpdateStatusJabatanJob());


        view()->composer(['pegawai.layout.navbar', 'operator.layout.navbar', 'admin.layout.navbar'], function ($view) {
            if (Auth::check()) {
                // Ambil notifikasi user yang sedang login
                $userId = Auth::id();
                $notifications = Notifikasi::where('id_user', $userId)
                                ->where('read_at', null)
                                ->orderBy('created_at', 'desc')
                                ->get();
                // Kirim data notifikasi ke view
                $view->with('notifications', $notifications);
            }
        });
    }


}
