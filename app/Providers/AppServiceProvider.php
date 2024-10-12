<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\UpdateStatusJabatanJob;

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
    }


}
