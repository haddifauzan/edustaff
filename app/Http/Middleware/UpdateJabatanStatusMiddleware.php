<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class UpdateJabatanStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Panggil perintah artisan untuk memperbarui status acara
        Artisan::call('jabatan:update-status');

        return $next($request);
    }
}
