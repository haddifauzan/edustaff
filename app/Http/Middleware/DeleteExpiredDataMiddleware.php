<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DeleteExpiredDataMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Panggil perintah artisan untuk memperbarui status acara
        Artisan::call('data:delete-expired');

        return $next($request);
    }
}
